<?php

namespace Database\Seeders;

use App\Models\Tempmail;
use Illuminate\Database\Seeder;

/**
 * Minimal fixtures for hermetic (sqlite in-memory) feature tests.
 */
class TestFixturesSeeder extends Seeder
{
    public function run(): void
    {
        // One active temp-mail domain so /tempmail/create has something valid.
        Tempmail::create([
            'name' => 'test.mail',
            'status' => 1,
        ]);
    }
}
