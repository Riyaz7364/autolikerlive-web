<?php

namespace App\Http\Controllers;

use App\Models\AutolikerService;
use App\Models\Link;
use App\Services\AutolikerServiceConfig;
use Illuminate\Http\Request;

class AutolikerServiceAdminController extends Controller
{
    public function index()
    {
        $services = AutolikerServiceConfig::forAdmin();

        try {
            $recentOrders = Link::query()
                ->whereNotNull('order_id')
                ->whereIn('service', ['followers', 'likes', 'comments'])
                ->orderByDesc('id')
                ->limit(20)
                ->get();
        } catch (\Throwable $e) {
            $recentOrders = collect();
        }

        return view('admin.autoliker-services', compact('services', 'recentOrders'));
    }

    public function update(Request $request)
    {
        $input = $request->validate([
            'services' => 'required|array',
            'services.*.status' => 'required|in:active,inactive',
            'services.*.mode' => 'required|in:websocket,order',
            'services.*.cost' => 'required|integer|min:0|max:100000',
            'services.*.min' => 'required|integer|min:1|max:100000',
            'services.*.max' => 'required|integer|min:1|max:100000',
            'services.*.quantity' => 'nullable|integer|min:1|max:100000',
            'services.*.provider_id' => 'nullable|string|max:100',
            'services.*.provider_api' => 'nullable|string|max:255',
            'services.*.provider_key' => 'nullable|string|max:255',
            'services.*.comment_field' => 'nullable|string|max:50',
        ]);

        $errors = [];

        foreach ($input['services'] as $id => $row) {
            $min = (int) $row['min'];
            $max = (int) $row['max'];

            if ($max < $min) {
                $errors["services.$id.max"] = 'Maximum quantity must be greater than or equal to minimum quantity.';
            }

            if (($row['mode'] ?? '') === 'order' && trim((string) ($row['provider_id'] ?? '')) === '') {
                $errors["services.$id.provider_id"] = 'Provider service ID is required for an order service.';
            }
        }

        if ($errors !== []) {
            return back()->withInput()->withErrors($errors);
        }

        AutolikerServiceConfig::updateMany($input['services']);

        return redirect()
            ->route('admin.autoliker-services.index')
            ->with('success', 'AutoLiker services updated. The app picks up changes immediately.');
    }

    public function toggle($id)
    {
        $service = AutolikerService::query()->findOrFail($id);
        $config = $service->orderConfig();

        $service->status = $service->status === 'active' ? 'inactive' : 'active';
        $config['active'] = $service->status === 'active';
        $service->orderData = json_encode($config, JSON_UNESCAPED_SLASHES);
        $service->save();

        return back()->with('success', "{$service->name} is now {$service->status}.");
    }
}
