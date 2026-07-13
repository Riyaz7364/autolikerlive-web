<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->string('shape_filter', 20)->nullable()->after('source_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->dropColumn('shape_filter');
        });
    }
};
