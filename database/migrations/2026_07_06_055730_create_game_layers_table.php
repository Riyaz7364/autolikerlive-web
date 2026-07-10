<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_layers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20); // text, image, dynamic
            $table->text('content')->nullable();
            $table->integer('x')->default(0);
            $table->integer('y')->default(0);
            $table->integer('w')->nullable();
            $table->integer('h')->nullable();
            $table->integer('rotation')->default(0);
            $table->string('font_family')->nullable();
            $table->integer('font_size')->nullable();
            $table->string('font_color', 20)->nullable();
            $table->string('text_align', 20)->nullable();
            $table->string('method_name')->nullable();
            $table->string('method_label')->nullable();
            $table->text('fallback_text')->nullable();
            $table->string('fail_behavior', 20)->default('show_error');
            $table->integer('sort_order')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_layers');
    }
};
