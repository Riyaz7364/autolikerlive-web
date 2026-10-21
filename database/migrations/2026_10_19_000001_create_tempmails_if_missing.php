<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Backfill: create the tempmails table (temp-mail domain allow-list) if it
     * does not exist yet. In environments where the table already exists
     * (live MySQL) this is a no-op; it lets a fresh sqlite test database
     * build cleanly.
     */
    public function up(): void
    {
        if (Schema::hasTable('tempmails')) {
            return;
        }

        Schema::create('tempmails', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);          // e.g. maildomain.shop
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->unique('name');
        });
    }

    public function down(): void
    {
        // Guarded: never drop a table we may not have created.
        if (! Schema::hasTable('temp_inboxes')) {
            Schema::dropIfExists('tempmails');
        }
    }
};
