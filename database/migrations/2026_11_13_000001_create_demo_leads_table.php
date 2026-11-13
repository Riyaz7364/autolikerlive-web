<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('demo_leads')) {
            return;
        }

        Schema::create('demo_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 190);
            $table->string('phone', 40)->nullable();
            $table->string('company', 190)->nullable();
            $table->string('project_type', 80)->nullable();
            $table->string('budget', 80)->nullable();
            $table->text('message');
            $table->string('source', 120)->default('website');
            $table->string('status', 20)->default('new');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_leads');
    }
};
