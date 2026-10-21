<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * The sqlite test database lives in memory per connection. The default
     * connection is migrated by RefreshDatabase (where used); any OTHER
     * connection rebound to sqlite in AppServiceProvider gets its own
     * in-memory database and therefore needs the schema too.
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (app()->runningUnitTests() && config('database.default') === 'sqlite') {
            // Default connection: suites WITHOUT RefreshDatabase need a schema.
            if (! Schema::connection(config('database.default'))->hasTable('migrations')) {
                Artisan::call('migrate', ['--force' => true]);
            }

            foreach (config('database.connections') as $name => $settings) {
                if ($name === config('database.default') || ($settings['driver'] ?? null) !== 'sqlite') {
                    continue;
                }

                if (! Schema::connection($name)->hasTable('migrations')) {
                    Artisan::call('migrate', ['--database' => $name, '--force' => true]);
                }
            }
        }
    }
}
