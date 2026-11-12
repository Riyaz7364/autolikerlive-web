<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('meta_images')) {
            Schema::create('meta_images', function (Blueprint $table): void {
                $table->id();
                $table->string('key')->unique();
                $table->string('label');
                $table->string('image')->nullable();
                $table->boolean('is_dynamic')->default(false);
                $table->timestamps();
            });
        }

        $directory = storage_path('app/public/meta-images');

        if (! is_dir($directory)) {
            return;
        }

        foreach (glob($directory . '/*') as $file) {
            if (! is_file($file)) {
                continue;
            }

            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (! in_array($extension, ['webp', 'png', 'jpg', 'jpeg'], true)) {
                continue;
            }

            $key = pathinfo($file, PATHINFO_FILENAME);

            DB::table('meta_images')->updateOrInsert(
                ['key' => $key],
                [
                    'label' => Str::headline($key),
                    'image' => 'meta-images/' . basename($file),
                    'is_dynamic' => false,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        // Keep uploaded meta images if the table is rolled back.
    }
};
