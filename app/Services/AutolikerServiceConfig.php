<?php

namespace App\Services;

use App\Models\AutolikerService;
use Illuminate\Support\Facades\Log;

/**
 * Reads and writes the AutoLiker service configuration.
 *
 * Services are stored in the backend `services` table (mysql2 connection):
 *
 *   id | name | cost | type | loginType | status | orderData
 *
 * `orderData` is JSON and is only used by the order-delivery mode:
 *
 *   {
 *     "mode": "order",
 *     "active": true,
 *     "id": 4825,                 // provider service id
 *     "quantity": 10,             // default/max quantity
 *     "min": 10,
 *     "max": 10,
 *     "key": "...",               // optional provider key override
 *     "api": "https://...",       // optional provider API override
 *     "comment_field": "comments" // optional, comments only
 *   }
 *
 * When `orderData` is empty/null the service uses the classic WebSocket flow.
 */
class AutolikerServiceConfig
{
    public const PROVIDER_API = 'https://smmsocialmedia.in/api/v2';
    public const PROVIDER_KEY = 'fef081d0d82d678f3d64c3a5cc190179';

    /** service key => backend `type` column */
    public const TYPE_MAP = [
        'like' => 'reaction',
        'follow' => 'follow',
        'comment' => 'comment',
    ];

    /** service key => UI label */
    public const LABELS = [
        'like' => 'Reactions',
        'follow' => 'Followers',
        'comment' => 'Comments',
    ];

    /**
     * Fallback configuration used when a row is missing or the backend DB is
     * temporarily unreachable. Followers default to the SMM order service
     * (10 followers for 2 credits each = 20 credits).
     */
    public const DEFAULTS = [
        'like' => [
            'name' => 'Auto Reaction',
            'type' => 'reaction',
            'label' => 'Reactions',
            'cost' => 1,
            'mode' => 'websocket',
            'min' => 1,
            'max' => 1,
            'provider_id' => null,
            'image' => 'like',
        ],
        'follow' => [
            'name' => 'Auto Followers',
            'type' => 'follow',
            'label' => 'Followers',
            'cost' => 2,
            'mode' => 'order',
            'min' => 10,
            'max' => 10,
            'provider_id' => 4825,
            'image' => 'follow',
        ],
        'comment' => [
            'name' => 'Auto Comments',
            'type' => 'comment',
            'label' => 'Comments',
            'cost' => 5,
            'mode' => 'websocket',
            'min' => 1,
            'max' => 1,
            'provider_id' => null,
            'image' => 'comment',
        ],
    ];

    /**
     * Full service map used by the AutoLiker dashboard and order endpoint.
     *
     * @return array<string, array>
     */
    public static function all(): array
    {
        $services = [];

        try {
            self::ensureRows();

            $rows = AutolikerService::query()
                ->where('loginType', 'fb')
                ->whereIn('type', array_values(self::TYPE_MAP))
                ->orderBy('id')
                ->get();

            foreach ($rows as $row) {
                $key = self::keyForType((string) $row->type);
                if ($key === null || isset($services[$key])) {
                    continue;
                }
                $services[$key] = self::fromRow($row);
            }
        } catch (\Throwable $e) {
            Log::warning('Unable to load AutoLiker services, using defaults: ' . $e->getMessage());
        }

        foreach (self::TYPE_MAP as $key => $type) {
            if (!isset($services[$key])) {
                $services[$key] = self::defaultsFor($key);
            }
        }

        // Keep the canonical order: Like, Follow, Comment.
        return [
            'like' => $services['like'],
            'follow' => $services['follow'],
            'comment' => $services['comment'],
        ];
    }

    /**
     * One service by key (`like`, `follow`, `comment`) or null.
     */
    public static function get(string $key): ?array
    {
        $all = self::all();

        return $all[$key] ?? null;
    }

    /**
     * Rows for the admin screen. Always returns exactly the three services.
     *
     * @return array<int, array>
     */
    public static function forAdmin(): array
    {
        $all = self::all();

        return array_values(array_map(function (array $service) {
            $service['order_data_raw'] = $service['order_data_raw'] ?? '';

            return $service;
        }, $all));
    }

    /**
     * Persist admin changes for one or more services.
     *
     * @param array<int, array> $rows keyed by database id
     */
    public static function updateMany(array $rows): void
    {
        foreach ($rows as $id => $data) {
            $service = AutolikerService::query()->find((int) $id);
            if (!$service) {
                continue;
            }

            $mode = ($data['mode'] ?? 'websocket') === 'order' ? 'order' : 'websocket';
            $status = ($data['status'] ?? 'active') === 'active' ? 'active' : 'inactive';
            $min = max(1, (int) ($data['min'] ?? 1));
            $max = max($min, (int) ($data['max'] ?? $min));
            $quantity = max($min, min($max, (int) ($data['quantity'] ?? $max)));

            $orderData = $service->orderConfig();

            // Keep the format understood by the existing services payload.
            $orderData['mode'] = $mode;
            $orderData['active'] = $status === 'active';
            $orderData['quantity'] = $quantity;
            $orderData['min'] = $min;
            $orderData['max'] = $max;

            $providerId = trim((string) ($data['provider_id'] ?? ''));
            if ($mode === 'order') {
                if ($providerId !== '') {
                    $orderData['id'] = is_numeric($providerId) ? (int) $providerId : $providerId;
                } else {
                    unset($orderData['id']);
                }
            } else {
                // A WebSocket service must not look like an SMM order service
                // to the other clients that read the same table.
                unset($orderData['id']);
            }

            $providerKey = trim((string) ($data['provider_key'] ?? ''));
            if ($providerKey !== '') {
                $orderData['key'] = $providerKey;
            } else {
                unset($orderData['key']);
            }

            $providerApi = trim((string) ($data['provider_api'] ?? ''));
            if ($providerApi !== '') {
                $orderData['api'] = $providerApi;
            } else {
                unset($orderData['api']);
            }

            $commentField = trim((string) ($data['comment_field'] ?? ''));
            if ($commentField !== '') {
                $orderData['comment_field'] = $commentField;
            } else {
                unset($orderData['comment_field']);
            }

            $service->cost = max(0, (int) ($data['cost'] ?? $service->cost));
            $service->status = $status;
            $service->orderData = json_encode($orderData, JSON_UNESCAPED_SLASHES);
            $service->save();
        }
    }

    public static function keyForType(string $type): ?string
    {
        $key = array_search($type, self::TYPE_MAP, true);

        return $key === false ? null : $key;
    }

    /**
     * Ensure the three Facebook rows exist so the admin screen always has
     * something to edit, even on a fresh backend database.
     */
    public static function ensureRows(): void
    {
        foreach (self::DEFAULTS as $key => $default) {
            $exists = AutolikerService::query()
                ->where('loginType', 'fb')
                ->where('type', $default['type'])
                ->exists();

            if ($exists) {
                continue;
            }

            $orderData = [
                'mode' => $default['mode'],
                'active' => true,
                'quantity' => $default['max'],
                'min' => $default['min'],
                'max' => $default['max'],
            ];

            if ($default['mode'] === 'order' && $default['provider_id']) {
                $orderData['id'] = $default['provider_id'];
            }

            AutolikerService::query()->create([
                'name' => $default['name'],
                'cost' => $default['cost'],
                'info' => 'Working',
                'image' => $default['image'],
                'type' => $default['type'],
                'loginType' => 'fb',
                'color' => 'ffffff',
                'status' => 'active',
                'orderData' => json_encode($orderData, JSON_UNESCAPED_SLASHES),
            ]);
        }
    }

    private static function fromRow(AutolikerService $row): array
    {
        $key = self::keyForType((string) $row->type);
        $default = $key ? self::DEFAULTS[$key] : null;
        $cfg = $row->orderConfig();

        $cost = max(0, (int) ($row->cost ?? $default['cost'] ?? 0));
        $mode = $cfg['mode'] ?? null;
        if ($mode !== 'order' && $mode !== 'websocket') {
            // Existing order rows (e.g. Auto Views) only carry an `id`.
            $mode = !empty($cfg['id']) ? 'order' : ($default['mode'] ?? 'websocket');
        }

        $min = (int) ($cfg['min'] ?? $default['min'] ?? 1);
        $min = max(1, $min);

        $quantity = (int) ($cfg['quantity'] ?? $cfg['max'] ?? $default['max'] ?? $min);
        $max = (int) ($cfg['max'] ?? $quantity);
        $max = max($min, $max);

        $defaultQuantity = (int) ($cfg['default'] ?? $quantity);
        $defaultQuantity = max($min, min($max, $defaultQuantity));

        $providerId = $cfg['id'] ?? $cfg['provider_service_id'] ?? $default['provider_id'] ?? null;

        return [
            'id' => (int) $row->id,
            'key' => $key,
            'type' => (string) $row->type,
            'name' => (string) ($row->name ?: ($default['name'] ?? $key)),
            'label' => self::LABELS[$key] ?? ($default['label'] ?? $key),
            'enabled' => (string) $row->status === 'active',
            'mode' => $mode,
            'cost' => $cost,
            'min' => $min,
            'max' => $max,
            'quantity' => $defaultQuantity,
            'provider' => [
                'id' => $providerId,
                'key' => $cfg['key'] ?? self::PROVIDER_KEY,
                'api' => $cfg['api'] ?? self::PROVIDER_API,
                'comment_field' => $cfg['comment_field'] ?? 'comments',
            ],
            'order_data' => $cfg,
            'order_data_raw' => (string) ($row->getAttribute('orderData') ?? ''),
        ];
    }

    private static function defaultsFor(string $key): array
    {
        $default = self::DEFAULTS[$key];

        return [
            'id' => null,
            'key' => $key,
            'type' => $default['type'],
            'name' => $default['name'],
            'label' => $default['label'],
            'enabled' => true,
            'mode' => $default['mode'],
            'cost' => $default['cost'],
            'min' => $default['min'],
            'max' => $default['max'],
            'quantity' => $default['max'],
            'provider' => [
                'id' => $default['provider_id'],
                'key' => self::PROVIDER_KEY,
                'api' => self::PROVIDER_API,
                'comment_field' => 'comments',
            ],
            'order_data' => [],
            'order_data_raw' => '',
        ];
    }
}
