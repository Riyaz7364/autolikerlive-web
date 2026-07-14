<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->integer('wrap_width')->nullable()->after('text_align');
        });
    }

    public function down(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->dropColumn('wrap_width');
        });
    }
};
