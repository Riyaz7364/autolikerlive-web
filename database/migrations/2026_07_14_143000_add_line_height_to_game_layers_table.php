<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->integer('line_height')->nullable()->after('wrap_width');
        });
    }

    public function down(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->dropColumn('line_height');
        });
    }
};
