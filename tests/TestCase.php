<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        if (app()->runningUnitTests()) {
            if (
                config('database.default') !== 'sqlite'
                || config('database.connections.sqlite.database') !== ':memory:'
            ) {
                throw new \RuntimeException('Tests must use the in-memory SQLite database.');
            }

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
