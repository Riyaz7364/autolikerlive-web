<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameSession;
use App\Services\AiGameService;
use App\Services\FacebookService;
use App\Services\ImageService;
use App\Services\ShapeFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    protected FacebookService $fb;
    protected ShapeFilterService $shapeFilter;
    protected ImageService $imageService;
    protected AiGameService $aiGame;

    public function __construct(FacebookService $fb, ShapeFilterService $shapeFilter, ImageService $imageService, AiGameService $aiGame)
    {
        $this->fb = $fb;
        $this->shapeFilter = $shapeFilter;
        $this->imageService = $imageService;
        $this->aiGame = $aiGame;
    }

    public function show($slug)
    {
        $game = Game::with(['layers' => function ($q) {
            $q->with('aiFields');
        }, 'visibleLayers' => function ($q) {
            $q->with('aiFields');
        }])->where('slug', $slug)->where('status', 'published')->firstOrFail();

        $session = $this->getSession();

        $userInputLayers = $game->visibleLayers->filter(function ($layer) {
            $st = $layer->source_type ?? 'auto';
            return in_array($st, ['dob', 'manual', 'user', 'ai']);
        });

        $hasUserInput = $userInputLayers->isNotEmpty();

        $game->title = resolveGameTitle($game->title);

        return view('games.show', compact('game', 'session', 'userInputLayers', 'hasUserInput'));
    }

    public function myImages()
    {
        $session = $this->getSession();
        if (!$session) {
            return redirect()->route('session.login', ['redirect' => url('/my-images')]);
        }

        $outputDir = storage_path('app/public/game_output');
        $images = [];

        if (is_dir($outputDir)) {
            $files = glob($outputDir . '/*_' . $session->id . '_*.png');
            rsort($files);
            foreach (array_slice($files, 0, 50) as $file) {
                $filename = basename($file);
                $images[] = [
                    'url' => Storage::disk('public')->url('game_output/' . $filename),
                    'created_at' => date('M j, Y g:i A', filemtime($file)),
                ];
            }
        }

        return view('games.my-images', compact('session', 'images'));
    }

    public function play(Request $request, $slug)
    {
        $game = Game::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $session = $this->getSession();

        if (!$session) {
            return response()->json(['error' => 'No session'], 403);
        }

        try {
            $userInput = $request->input('user_input', []);
            $userImages = $request->file('user_images', []);
            $image = $this->renderGame($game, $session, $userInput, $userImages);

            $outputDir = storage_path('app/public/game_output');
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $hash = $session->id . '_' . time();
            $filename = $slug . '_' . $hash . '.png';
            $image->save($outputDir . '/' . $filename, quality: 80);

            $imageUrl = Storage::disk('public')->url('game_output/' . $filename);

            $ogTitle = resolveGameTitle($game->og_title ?: 'Try it yourself!');
            $shareUrl = route('game.shared', ['slug' => $slug, 'hash' => $hash]);

            return response()->json([
                'success' => true,
                'image_url' => $imageUrl,
                'share_url' => $shareUrl,
                'og_title' => $ogTitle,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function shared($slug, $hash)
    {
        $game = Game::where('slug', $slug)->where('status', 'published')->firstOrFail();

        $filename = $slug . '_' . $hash . '.png';
        $imagePath = storage_path('app/public/game_output/' . $filename);

        if (!file_exists($imagePath)) {
            abort(404);
        }

        $imageUrl = Storage::disk('public')->url('game_output/' . $filename);

        $game->title = resolveGameTitle($game->title);

        return view('games.shared', [
            'game' => $game,
            'imageUrl' => $imageUrl,
            'hash' => $hash,
        ]);
    }

    protected function renderGame(Game $game, GameSession $session, array $userInput = [], array $userImages = [])
    {
        $bgPath = $game->bg_image ? storage_path('app/public/' . $game->bg_image) : null;

        if ($bgPath && file_exists($bgPath)) {
            $canvasW = $game->canvas_w ?: imagesx(imagecreatefromstring(file_get_contents($bgPath)));
            $canvasH = $game->canvas_h ?: imagesy(imagecreatefromstring(file_get_contents($bgPath)));
            $image = Image::read($bgPath);
        } else {
            $canvasW = $game->canvas_w ?: 800;
            $canvasH = $game->canvas_h ?: 600;
            $image = Image::create($canvasW, $canvasH);
            if ($game->bg_color) {
                $image->fill($game->bg_color);
            }
        }

        foreach ($game->visibleLayers as $layer) {
            try {
                $layerType = $layer->type === 'dynamic' ? 'text' : $layer->type;
                $sourceType = $layer->source_type ?? 'auto';

                if ($layerType === 'text') {
                    if ($sourceType === 'auto' && $layer->method_name) {
                        $content = $this->callDynamicMethod($layer->method_name, $session);
                    } elseif ($sourceType === 'ai') {
                        $aiFields = $layer->aiFields()->orderBy('sort_order')->get();
                        $fields = [];
                        foreach ($aiFields as $field) {
                            $value = $userInput[$layer->id . '_' . $field->field_key] ?? '';
                            $fields[] = [
                                'key' => $field->field_key,
                                'label' => $field->field_label,
                                'value' => $value,
                            ];
                        }
                        $role = $layer->ai_role ?? 'You are a fun, entertaining AI fortune teller for a social media game.';
                        $prompt = $layer->ai_prompt ?? 'Generate a fun prediction for this person.';
                        $content = $this->aiGame->generate($role, $prompt, $fields);
                    } elseif (in_array($sourceType, ['dob', 'manual'])) {
                        $content = $userInput[$layer->id] ?? $userInput[$layer->sort_order] ?? '';
                        if ($sourceType === 'dob' && $content && preg_match('/^\d{4}-\d{2}-\d{2}$/', $content)) {
                            $content = \Carbon\Carbon::parse($content)->format('d/m/Y');
                        }
                    } else {
                        $content = $layer->content ?? '';
                    }

                    $fontFile = $this->resolveFont($layer->font_family);
                    $image->text($content, $layer->x, $layer->y, function ($font) use ($layer, $fontFile) {
                        $font->file($fontFile);
                        $font->size($layer->font_size ?: 24);
                        $font->color($layer->font_color ?: '#000000');
                        $font->align($layer->text_align ?: 'left');
                        $font->valign('top');
                        if (!empty($layer->wrap_width)) {
                            $font->wrap((int)$layer->wrap_width);
                        }
                        if (!empty($layer->line_height)) {
                            $font->lineHeight((int)$layer->line_height);
                        }
                    });
                } elseif ($layerType === 'image') {
                    if ($sourceType === 'auto' && $layer->method_name) {
                        $source = $this->callDynamicMethod($layer->method_name, $session);
                    } elseif ($sourceType === 'user') {
                        if (isset($userImages[$layer->id]) || isset($userImages[$layer->sort_order])) {
                            $file = $userImages[$layer->id] ?? $userImages[$layer->sort_order];
                            $source = $this->storeUserImage($file);
                        } else {
                            continue;
                        }
                    } else {
                        continue;
                    }

                    $overlay = $this->imageService->loadOverlay($source);
                    if ($overlay) {
                        if ($layer->w && $layer->h) {
                            $overlay->resize((int)$layer->w, (int)$layer->h);
                        }
                        if ($layer->shape_filter) {
                            $overlay = $this->shapeFilter->apply($overlay, $layer->shape_filter);
                        }
                        if (!empty($layer->rotation)) {
                            $overlay->rotate((int)$layer->rotation, 'transparent');
                        }
                        $image->place($overlay, 'top-left', (int)$layer->x, (int)$layer->y);
                    }
                }
            } catch (\Exception $e) {
                if ($layer->fail_behavior === 'show_fallback' && $layer->fallback_text) {
                    $fontFile = $this->resolveFont($layer->font_family);
                    $image->text($layer->fallback_text, $layer->x, $layer->y, function ($font) use ($layer, $fontFile) {
                        $font->file($fontFile);
                        $font->size($layer->font_size ?: 24);
                        $font->color($layer->font_color ?: '#000000');
                        $font->align($layer->text_align ?: 'left');
                        $font->valign('top');
                        if (!empty($layer->wrap_width)) {
                            $font->wrap((int)$layer->wrap_width);
                        }
                    });
                }
            }
        }

        return $image;
    }

    protected function storeUserImage($file): string
    {
        return $file->store('game_user_uploads', 'public');
    }

    protected function callDynamicMethod($methodName, GameSession $session): string
    {
        $controller = app(\App\Http\Controllers\GameMethodController::class);

        if (!method_exists($controller, $methodName)) {
            throw new \Exception("Method '$methodName' not found");
        }

        return $controller->$methodName($session);
    }

    protected function resolveFont($fontFamily): string
    {
        if (!$fontFamily) {
            return public_path('fonts/arialbd.ttf');
        }

        // Full path provided
        if (file_exists($fontFamily)) {
            return $fontFamily;
        }

        // Named font — check public/fonts/
        $fontPath = public_path('fonts/' . $fontFamily);
        if (file_exists($fontPath)) {
            return $fontPath;
        }

        return public_path('fonts/arialbd.ttf');
    }

    public function editorList()
    {
        $games = Game::orderBy('created_at', 'desc')->get();
        return view('game-editor-list', compact('games'));
    }

    public function editorCreate()
    {
        return view('game-create');
    }

    public function editorStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:games,slug',
            'description' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:3072',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('games/thumbnails', 'public');
        }

        $game = Game::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'thumbnail' => $thumbnail,
            'status' => $request->status,
        ]);

        return redirect()->route('game.editor.edit', $game->id)
            ->with('success', 'Game created! Now design your game canvas.');
    }

    public function editorEditInfo($id)
    {
        $game = Game::findOrFail($id);
        return view('game-edit', compact('game'));
    }

    public function editorUpdateInfo(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:games,slug,' . $game->id,
            'description' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:3072',
            'bg_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:3072',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'status' => $request->status,
        ];

        if ($request->hasFile('thumbnail')) {
          
            if ($game->thumbnail) {
                $oldPath = storage_path('app/public/' . $game->thumbnail);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('games/thumbnails', 'public');
            
        }


        if($request->hasFile('bg_image')){
            if ($game->bg_image) {
                $oldPath = storage_path('app/public/' . $game->bg_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['bg_image'] = $request->file('bg_image')->store('games/bg', 'public');

        }

        
   
        $game->update($data);

        return redirect()->route('game.editor.edit-info', $game->id)
            ->with('success', 'Game info updated!');
    }

    public function editorEdit($id)
    {
        $game = Game::findOrFail($id);
        return view('game-editor', ['gameId' => $game->id]);
    }

    public function editorDelete($id)
    {
        $game = Game::findOrFail($id);
        $game->layers()->delete();
        $game->delete();
        return redirect()->route('game.editor.list')->with('success', 'Game deleted.');
    }

    protected function getSession(): ?GameSession
    {
        $id = request()->cookie('game_session');
        if (!$id) return null;

        return GameSession::find($id);
    }
}
