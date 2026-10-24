<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A service exposed by the AutoLiker app.
 *
 * The records live in the backend database (connection: mysql2) because the
 * Node/Bun backend reads the same table through `getServices` and the Android
 * app uses it for the service list. `orderData` holds the per-service order
 * configuration (delivery mode, min/max quantity, provider service id, ...).
 */
class AutolikerService extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'services';

    protected $guarded = [];

    public $timestamps = true;

    protected $casts = [
        'cost' => 'integer',
    ];

    /**
     * Decoded `orderData` JSON for this service.
     */
    public function orderConfig(): array
    {
        $raw = $this->getAttribute('orderData');

        // Some legacy rows only have the snake_case column populated.
        if (!$raw) {
            $raw = $this->getAttribute('order_data');
        }

        if (is_array($raw)) {
            return $raw;
        }

        $decoded = json_decode((string) $raw, true);

        return is_array($decoded) ? $decoded : [];
    }
}
