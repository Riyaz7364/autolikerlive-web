<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AppReleaseController extends Controller
{
    public function index()
    {
        $apps = AppRelease::orderBy('name')->paginate(25);

        return view('admin.app-releases.index', compact('apps'));
    }

    public function create()
    {
        return view('admin.app-releases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:50|regex:/^[a-z0-9_\-]+$/|unique:app_releases,app_name',
            'name' => 'required|string|max:255',
            'version' => 'required|string|max:50',
            'release_code' => 'required|integer|min:1',
            'changelog' => 'nullable|string|max:5000',
            'tagline' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'force_update' => 'nullable|boolean',
            'apk_file' => 'nullable|file|max:204800|mimetypes:application/vnd.android.package-archive,application/octet-stream,application/zip',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'app_name.regex' => 'App key may only contain lowercase letters, numbers, dashes and underscores.',
        ]);

        $validated['app_name'] = AppRelease::normalizeKey($validated['app_name']);

        $apk = $request->file('apk_file');
        if ($apk) {
            $ext = strtolower($apk->getClientOriginalExtension());
            if ($ext !== 'apk') {
                return back()->withErrors(['apk_file' => 'Only .apk files are allowed.'])->withInput();
            }
            $filename = $validated['app_name'] . '_' . preg_replace('/[^0-9A-Za-z.\-]/', '', $validated['version']) . '.apk';
            $path = $apk->storeAs('builds', $filename, 'local');
            if (! $path) {
                return back()->withErrors(['apk_file' => 'Upload received but the file could not be written to storage. Check storage/app/builds permissions.'])->withInput();
            }
            $validated['apk_path'] = $path;
            $validated['apk_original_name'] = $apk->getClientOriginalName();
            $validated['apk_size'] = $apk->getSize();
        }

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->storeAs(
                'app-icons',
                $validated['app_name'] . '.' . strtolower($request->file('icon')->getClientOriginalExtension()),
                'public'
            );
            if (! $iconPath) {
                return back()->withErrors(['icon' => 'Icon received but the file could not be written to storage.'])->withInput();
            }
            $validated['icon_path'] = $iconPath;
        }

        unset($validated['apk_file'], $validated['icon']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['force_update'] = $request->boolean('force_update');

        $app = AppRelease::create($validated);

        // Keep legacy public/info.json in sync for the default app so the old
        // /download/apk endpoint keeps serving the newest build.
        $this->syncLegacyInfoJson($app);

        \App\Services\IndexNow::submitPath('download');

        return redirect()->route('admin.app-releases.index')->with('success', "App '{$app->name}' created successfully.");
    }

    public function edit($id)
    {
        $release = AppRelease::findOrFail($id);

        return view('admin.app-releases.edit', compact('release'));
    }

    public function update(Request $request, $id)
    {
        $app = AppRelease::findOrFail($id);

        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:50', 'regex:/^[a-z0-9_\-]+$/', Rule::unique('app_releases', 'app_name')->ignore($app->id)],
            'name' => 'required|string|max:255',
            'version' => 'required|string|max:50',
            'release_code' => 'required|integer|min:1',
            'changelog' => 'nullable|string|max:5000',
            'tagline' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'force_update' => 'nullable|boolean',
            'apk_file' => 'nullable|file|max:204800|mimetypes:application/vnd.android.package-archive,application/octet-stream,application/zip',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'app_name.regex' => 'App key may only contain lowercase letters, numbers, dashes and underscores.',
        ]);

        $validated['app_name'] = AppRelease::normalizeKey($validated['app_name']);

        $apk = $request->file('apk_file');
        if ($apk) {
            $ext = strtolower($apk->getClientOriginalExtension());
            if ($ext !== 'apk') {
                return back()->withErrors(['apk_file' => 'Only .apk files are allowed.'])->withInput();
            }
            // remove old build if the filename changes
            $filename = $validated['app_name'] . '_' . preg_replace('/[^0-9A-Za-z.\-]/', '', $validated['version']) . '.apk';
            $path = $apk->storeAs('builds', $filename, 'local');
            if (! $path) {
                return back()->withErrors(['apk_file' => 'Upload received but the file could not be written to storage. Check storage/app/builds permissions.'])->withInput();
            }
            if ($app->apk_path && $app->apk_path !== $path && Storage::disk('local')->exists($app->apk_path)) {
                Storage::disk('local')->delete($app->apk_path);
            }
            $validated['apk_path'] = $path;
            $validated['apk_original_name'] = $apk->getClientOriginalName();
            $validated['apk_size'] = $apk->getSize();
        }

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->storeAs(
                'app-icons',
                $validated['app_name'] . '.' . strtolower($request->file('icon')->getClientOriginalExtension()),
                'public'
            );
            if (! $iconPath) {
                return back()->withErrors(['icon' => 'Icon received but the file could not be written to storage.'])->withInput();
            }
            if ($app->icon_path && $app->icon_path !== $iconPath && Storage::disk('public')->exists($app->icon_path)) {
                Storage::disk('public')->delete($app->icon_path);
            }
            $validated['icon_path'] = $iconPath;
        }

        unset($validated['apk_file'], $validated['icon']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['force_update'] = $request->boolean('force_update');

        $app->update($validated);

        $this->syncLegacyInfoJson($app->fresh());

        \App\Services\IndexNow::submitPath('download');

        return redirect()->route('admin.app-releases.index')->with('success', "App '{$app->name}' updated successfully.");
    }

    public function destroy($id)
    {
        $app = AppRelease::findOrFail($id);

        if ($app->apk_path && Storage::disk('local')->exists($app->apk_path)) {
            Storage::disk('local')->delete($app->apk_path);
        }
        if ($app->icon_path && Storage::disk('public')->exists($app->icon_path)) {
            Storage::disk('public')->delete($app->icon_path);
        }
        $app->delete();

        return redirect()->route('admin.app-releases.index')->with('success', 'App deleted successfully.');
    }

    /**
     * Public JSON for apps: GET /api/app-update/{appName}
     * Lookup is case-insensitive by app_name key.
     */
    public function apiShow($appName)
    {
        $key = AppRelease::normalizeKey($appName);

        $app = AppRelease::where('app_name', $key)
            ->where('is_active', true)
            ->first();

        if (! $app) {
            // fall back to case-insensitive name match
            $app = AppRelease::whereRaw('LOWER(app_name) = ?', [$key])
                ->where('is_active', true)
                ->first();
        }

        if (! $app) {
            return response()->json([
                'success' => false,
                'message' => "App '{$appName}' not found.",
            ], 404);
        }

        return response()->json(array_merge(['success' => true], $app->toApiArray()));
    }

    /**
     * Public JSON list: GET /api/app-updates
     */
    public function apiIndex()
    {
        $apps = AppRelease::where('is_active', true)->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'count' => $apps->count(),
            'apps' => $apps->map->toApiArray()->values(),
        ]);
    }

    /**
     * Legacy support: the old download page + /download/apk read public/info.json.
     * Whenever the default app (first active, or "autolikerlive") is saved,
     * rewrite info.json so old clients keep working.
     */
    protected function syncLegacyInfoJson(AppRelease $app): void
    {
        $default = AppRelease::where('app_name', 'autolikerlive')->first()
            ?? AppRelease::where('is_active', true)->orderBy('id')->first();

        if (! $default || $default->id !== $app->id || ! $default->apk_original_name) {
            return;
        }

        $payload = [
            'version' => (string) $default->release_code,
            'build' => $default->version,
            'update' => $default->updated_at?->format('d M, Y') ?? now()->format('d M, Y'),
            'link' => basename($default->apk_path ?? $default->apk_original_name),
        ];

        @file_put_contents(public_path('info.json'), json_encode($payload, JSON_PRETTY_PRINT));
    }
}
