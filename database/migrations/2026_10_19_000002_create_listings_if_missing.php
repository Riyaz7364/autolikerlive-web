<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Backfill: create the listings table if it does not exist (live MySQL
     * deployments already have it outside of migrations; the sqlite test DB
     * needs it to render the homepage).
     */
    public function up(): void
    {
        if (Schema::hasTable('listings')) {
            return;
        }

        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('post_id')->nullable()->index();
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Guarded: never drop a table we may not have created.
        if (! Schema::hasTable('listings_foo_check')) {
            Schema::dropIfExists('listings');
        }
    }
};
