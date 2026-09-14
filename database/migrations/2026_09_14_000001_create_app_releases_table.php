<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_releases', function (Blueprint $table) {
            $table->id();
            // lookup key, e.g. "autolikerlive", "rajeliker" — used as /api/app-update/{app_name}
            $table->string('app_name')->unique();
            // display name, e.g. "AutoLiker Live"
            $table->string('name');
            // version label shown to users, e.g. "1.0.6"
            $table->string('version')->default('1.0.0');
            // integer release/build code the app compares, e.g. 7
            $table->unsignedInteger('release_code')->default(1);
            // optional notes shown in update dialog
            $table->text('changelog')->nullable();
            // stored apk location relative to local disk, e.g. "builds/autolikerLive_1.0.6.apk"
            $table->string('apk_path')->nullable();
            $table->string('apk_original_name')->nullable();
            $table->unsignedBigInteger('apk_size')->nullable();
            $table->boolean('is_active')->default(true);
            // when true the app should force the user to update
            $table->boolean('force_update')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_releases');
    }
};
