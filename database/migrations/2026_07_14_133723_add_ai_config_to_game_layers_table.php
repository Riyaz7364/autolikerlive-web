<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->text('ai_role')->nullable()->after('wrap_width');
            $table->text('ai_prompt')->nullable()->after('ai_role');
        });
    }

    public function down(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->dropColumn(['ai_role', 'ai_prompt']);
        });
    }
};
