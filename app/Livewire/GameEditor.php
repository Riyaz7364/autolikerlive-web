<?php

namespace App\Livewire;

use App\Http\Controllers\GameMethodController;
use App\Models\Game;
use App\Models\GameLayer;
use App\Models\GameSession;
use App\Services\FacebookService;
use App\Services\ImageService;
use App\Services\ShapeFilterService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
class GameEditor extends Component
{
    use WithFileUploads;

    public $gameId = null;
    public $bg_color = '#ffffff';

    public $bgImageUpload = null;
    public $bgImagePreview = null;
    public $savedBgImage = null;

    public $layers = [];
    public $previewImage = null;
    public $error = null;

    protected FacebookService $fbService;
    protected ShapeFilterService $shapeFilter;
    protected ImageService $imageService;

    public function boot(FacebookService $fbService, ShapeFilterService $shapeFilter, ImageService $imageService)
    {
        $this->fbService = $fbService;
        $this->shapeFilter = $shapeFilter;
        $this->imageService = $imageService;
    }

    public function mount($gameId = null)
    {
        if ($gameId) {
            $game = Game::with('layers')->findOrFail($gameId);
            $this->gameId = $game->id;
            $this->bg_color = $game->bg_color ?? '#ffffff';
            $this->savedBgImage = $game->bg_image;
            $this->bgImagePreview = $game->bg_image ? Storage::disk('public')->url($game->bg_image) : null;

            foreach ($game->layers as $layer) {
                $normalizedType = $layer->type === 'dynamic' ? 'text' : $layer->type;
                $this->layers[] = [
                    'id' => $layer->id,
                    'type' => $normalizedType,
                    'source_type' => $layer->source_type ?? 'auto',
                    'prompt_label' => $layer->prompt_label,
                    'content' => $layer->content,
                    'x' => $layer->x,
                    'y' => $layer->y,
                    'w' => $layer->w,
                    'h' => $layer->h,
                    'rotation' => $layer->rotation,
                    'font_family' => $layer->font_family,
                    'font_size' => $layer->font_size,
                    'font_color' => $layer->font_color,
                    'text_align' => $layer->text_align,
                    'method_name' => $layer->method_name,
                    'method_label' => $layer->method_label,
                    'fallback_text' => $layer->fallback_text,
                    'fail_behavior' => $layer->fail_behavior ?? 'show_error',
                    'sort_order' => $layer->sort_order,
                    'visible' => $layer->visible,
                    'shape_filter' => $layer->shape_filter ?? null,
                ];
            }
        }

        if (empty($this->layers)) {
            $this->addLayer('text');
        }
    }

    public function updatedBgImageUpload()
    {
        $this->validate([
            'bgImageUpload' => 'image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $path = $this->storeBgImage($this->bgImageUpload);
        $this->savedBgImage = $path;
        $this->bgImagePreview = asset('storage/' . $path) . '?v=' . now()->timestamp;
        $this->bgImageUpload = null;

        $fullPath = Storage::disk('public')->path($path);
        if (file_exists($fullPath)) {
            [$w, $h] = getimagesize($fullPath);
            $this->dispatch('canvas-dimensions', w: $w, h: $h);
        }
    }

    public function addLayer($type = 'text', $sourceType = 'auto')
    {
        if ($type === 'image') {
            $layer = [
                'id' => null,
                'type' => 'image',
                'source_type' => $sourceType,
                'prompt_label' => $sourceType === 'user' ? 'Upload your photo' : null,
                'content' => $sourceType === 'auto' ? '' : '',
                'x' => 10,
                'y' => 10 + (count($this->layers) * 40),
                'w' => 100,
                'h' => 100,
                'rotation' => 0,
                'font_family' => null,
                'font_size' => null,
                'font_color' => null,
                'text_align' => null,
                'method_name' => $sourceType === 'auto' ? 'getProfilePic' : null,
                'method_label' => null,
                'fallback_text' => null,
                'fail_behavior' => 'show_error',
                'sort_order' => count($this->layers),
                'visible' => true,
                'shape_filter' => null,
            ];
        } else {
            $layer = [
                'id' => null,
                'type' => 'text',
                'source_type' => $sourceType,
                'prompt_label' => $sourceType === 'dob' ? 'Enter your date of birth' : ($sourceType === 'manual' ? 'Enter text' : null),
                'content' => '',
                'x' => 10,
                'y' => 10 + (count($this->layers) * 40),
                'w' => null,
                'h' => null,
                'rotation' => 0,
                'font_family' => null,
                'font_size' => 24,
                'font_color' => '#000000',
                'text_align' => 'left',
                'method_name' => $sourceType === 'auto' ? 'getName' : null,
                'method_label' => null,
                'fallback_text' => null,
                'fail_behavior' => 'show_error',
                'sort_order' => count($this->layers),
                'visible' => true,
                'shape_filter' => null,
            ];
        }
        $this->layers[] = $layer;
    }

    public function removeLayer($index)
    {
        if (isset($this->layers[$index])) {
            unset($this->layers[$index]);
            $this->layers = array_values($this->layers);
        }
    }

    public function moveLayerUp($index)
    {
        if ($index > 0) {
            $tmp = $this->layers[$index];
            $this->layers[$index] = $this->layers[$index - 1];
            $this->layers[$index - 1] = $tmp;
        }
    }

    public function moveLayerDown($index)
    {
        if ($index < count($this->layers) - 1) {
            $tmp = $this->layers[$index];
            $this->layers[$index] = $this->layers[$index + 1];
            $this->layers[$index + 1] = $tmp;
        }
    }

    public function generatePreview()
    {
        try {
            $bgPath = null;
            $canvasW = 800;
            $canvasH = 600;
         
            if ($this->savedBgImage) {
                $bgPath = $this->savedBgImage;
                $fullPath = Storage::disk('public')->path($bgPath);
                if (file_exists($fullPath)) {
                    [$canvasW, $canvasH] = getimagesize($fullPath);
                }
            }


   
            $image = Image::create($canvasW, $canvasH);
            $image->fill($this->bg_color ?? '#ffffff');
            if ($bgPath && file_exists(Storage::disk('public')->path($bgPath))) {
                $bgImg = Image::read(Storage::disk('public')->path($bgPath));
                $image->place($bgImg, 'top-left', 0, 0);
            }

            $session = $this->resolvePreviewSession();
            
            $methodController = app(GameMethodController::class);

            foreach ($this->layers as $layer) {
                if (!$layer['visible']) continue;

                $layerType = $layer['type'] === 'dynamic' ? 'text' : $layer['type'];

                if ($layerType === 'text') {
                    $text = 'Sample Text';
                    if ($layer['source_type'] === 'auto' && $layer['method_name']) {
                        $text = $this->callMethodForPreview($methodController, $layer['method_name'], $session);
                    } elseif ($layer['source_type'] === 'auto' && !$layer['method_name'] && $layer['content']) {
                        $text = $layer['content'];
                    } elseif ($layer['source_type'] === 'dob') {
                        $raw = $layer['content'] ?? '';
                        $text = $raw && preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)
                            ? \Carbon\Carbon::parse($raw)->format('d/m/Y')
                            : ($raw ?: ('[' . ($layer['prompt_label'] ?: 'Date of Birth') . ']'));
                    } elseif ($layer['source_type'] === 'manual') {
                        $text = $layer['content'] ?: ('[' . ($layer['prompt_label'] ?: 'Text') . ']');
                    }

                    $fontFile = $layer['font_family'] && file_exists($layer['font_family'])
                        ? $layer['font_family']
                        : public_path('fonts/arialbd.ttf');

                    $image->text($text, (int)$layer['x'], (int)$layer['y'], function ($font) use ($layer, $fontFile) {
                        $font->file($fontFile);
                        $font->size((int)($layer['font_size'] ?: 24));
                        $font->color($layer['font_color'] ?: '#000000');
                        $font->align($layer['text_align'] ?: 'left');
                        $font->valign('top');
                    });
                } elseif ($layerType === 'image') {
                    if ($layer['source_type'] === 'auto' && $layer['method_name']) {
                        $src = $this->callMethodForPreview($methodController, $layer['method_name'], $session);
                       
                        if (empty($src) || !str_starts_with($src, 'http')) {
                            $src = public_path('default-avatar.png');
                            if (!file_exists($src)) {
                                $src = 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png';
                            }
                        }
                    } elseif ($layer['source_type'] === 'user') {
                        continue;
                    } else {
                        $src = $layer['content'];
                    }

                    if (!empty($src)) {
                        $overlay = $this->imageService->loadOverlay($src);
                            dd($overlay);
                        if ($overlay) {
                            if ($layer['w'] && $layer['h']) {
                                $overlay->resize((int)$layer['w'], (int)$layer['h']);
                            }
                            if (!empty($layer['shape_filter'])) {
                                $overlay = $this->shapeFilter->apply($overlay, $layer['shape_filter']);
                            }
                            $image->place($overlay, 'top-left', (int)$layer['x'], (int)$layer['y']);
                        }
                    }
                }
            }

            $outputDir = storage_path('app/public/game_previews');
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $filename = $this->gameId ? "preview_{$this->gameId}.png" : 'preview_new.png';
            $image->save($outputDir . '/' . $filename, quality: 80);

            $this->previewImage = asset('storage/game_previews/' . $filename) . '?v=' . now()->timestamp;
            $this->error = null;

        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    protected function storeBgImage($upload): string
    {
        if ($this->savedBgImage) {
            $oldPath = Storage::disk('public')->path($this->savedBgImage);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        return $upload->store('games/bg', 'public');
    }

    protected function resolvePreviewSession(): GameSession
    {
        $sid = request()->cookie('game_session');
        if ($sid) {
            $existing = GameSession::find($sid);
            if ($existing) return $existing;
        }

        return GameSession::make([
            'id' => 'preview',
            'name' => 'John Doe',
            'username' => 'johndoe',
            'profile_pic' => '',
            'dob' => '15/08/1990',
        ]);
    }

    protected function callMethodForPreview(GameMethodController $controller, string $methodName, GameSession $session): string
    {
        if (method_exists($controller, $methodName)) {
            return $controller->$methodName($session);
        }
        $label = $this->getMethodLabel($methodName);
        return $label ?: $methodName;
    }

    public function save()
    {
        $bgImage = null;
        if ($this->bgImageUpload) {
            $bgImage = $this->storeBgImage($this->bgImageUpload);
        }

        $canvasW = 800;
        $canvasH = 600;
        if ($this->savedBgImage) {
            $fullPath = Storage::disk('public')->path($this->savedBgImage);
            if (file_exists($fullPath)) {
                [$canvasW, $canvasH] = getimagesize($fullPath);
            }
        } elseif ($this->gameId) {
            $existing = Game::find($this->gameId);
            if ($existing) {
                $canvasW = $existing->canvas_w;
                $canvasH = $existing->canvas_h;
            }
        }

        $data = [
            'bg_color' => $this->bg_color,
            'canvas_w' => $canvasW,
            'canvas_h' => $canvasH,
        ];

        if ($bgImage) {
            $data['bg_image'] = $bgImage;
            $this->savedBgImage = $bgImage;
            $this->bgImagePreview = Storage::disk('public')->url($bgImage);
            $this->bgImageUpload = null;
        } elseif ($this->savedBgImage) {
            $data['bg_image'] = $this->savedBgImage;
        }

        if ($this->gameId) {
            $game = Game::findOrFail($this->gameId);
            $game->update($data);
            GameLayer::where('game_id', $game->id)->delete();
        } else {
            $game = Game::create($data);
            $this->gameId = $game->id;
        }

        foreach ($this->layers as $layer) {
            $normalizedType = $layer['type'] === 'dynamic' ? 'text' : $layer['type'];
            GameLayer::create([
                'game_id' => $game->id,
                'type' => $normalizedType,
                'source_type' => $layer['source_type'] ?? 'auto',
                'prompt_label' => $layer['prompt_label'] ?? null,
                'content' => $layer['content'] ?? '',
                'x' => $layer['x'] ?? 0,
                'y' => $layer['y'] ?? 0,
                'w' => $layer['w'] ?? null,
                'h' => $layer['h'] ?? null,
                'rotation' => $layer['rotation'] ?? 0,
                'font_family' => $layer['font_family'] ?? null,
                'font_size' => $layer['font_size'] ?? 24,
                'font_color' => $layer['font_color'] ?? '#000000',
                'text_align' => $layer['text_align'] ?? 'left',
                'method_name' => $layer['method_name'] ?? null,
                'method_label' => $layer['method_label'] ?? null,
                'fallback_text' => $layer['fallback_text'] ?? null,
                'fail_behavior' => $layer['fail_behavior'] ?? 'show_error',
                'sort_order' => $layer['sort_order'] ?? 0,
                'visible' => $layer['visible'] ?? true,
                'shape_filter' => $layer['shape_filter'] ?? null,
            ]);
        }

        $this->dispatch('saved', gameId: $game->id);
        session()->flash('success', 'Canvas saved successfully!');
    }

    protected function getMethodLabel($methodName): ?string
    {
        $methods = $this->getAvailableMethods();
        return $methods[$methodName] ?? null;
    }

    public function render()
    {
        $availableMethods = $this->getAvailableMethods();
        return view('livewire.game-editor', compact('availableMethods'));
    }

    protected function getAvailableMethods(): array
    {
        return [
            'getName' => 'Full Name',
            'getUsername' => 'Username',
            'getID' => 'User ID',
            'getProfilePic' => 'Profile Pic URL',
            'currentDate' => 'Current Date',
            'currentTime' => 'Current Time',
            'randomQuote' => 'Random Quote',
            'uppercaseName' => 'Uppercase Name',
            'randomRating' => 'Random Rating %',
            'randomNumber' => 'Random Number',
        ];
    }
}
