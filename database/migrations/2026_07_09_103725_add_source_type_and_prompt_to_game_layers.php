<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->string('source_type', 20)->default('auto')->after('type');
            $table->string('prompt_label')->nullable()->after('source_type');
        });
    }

    public function down(): void
    {
        Schema::table('game_layers', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'prompt_label']);
        });
    }
};
