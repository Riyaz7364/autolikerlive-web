<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Backfill for tables that exist in the live MySQL database but never had
     * migrations. Every create is guarded by hasTable(), so on live MySQL this
     * migration is a no-op; on a fresh sqlite test database it builds the
     * missing schema so the app (homepage, games, temp-mail fixtures…) and
     * the test suite are fully hermetic.
     */
    public function up(): void
    {
        if (! Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->text('link')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('games')) {
            Schema::create('games', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('thumbnail')->nullable();
                $table->string('og_title')->nullable();
                $table->text('og_description')->nullable();
                $table->string('bg_image')->nullable();
                $table->integer('canvas_w')->default(800);
                $table->integer('canvas_h')->default(600);
                $table->string('bg_color', 20)->nullable();
                $table->string('status', 20)->default('draft');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 50);
                $table->string('gender', 50);
                $table->string('country', 50);
                $table->integer('age');
                $table->string('username', 100);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title', 100);
                $table->string('description', 160);
                $table->string('subtitle', 500);
                $table->text('content');
                $table->string('slug', 100);
                $table->text('tags');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('premium_accounts')) {
            Schema::create('premium_accounts', function (Blueprint $table) {
                $table->integer('id')->primary();
                $table->string('ip')->nullable();
                $table->string('code')->default('0');
                $table->boolean('used')->default(false);
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->string('id')->primary(); // UUID
                $table->string('link');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('statistics')) {
            Schema::create('statistics', function (Blueprint $table) {
                $table->id();
                $table->string('key');
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('sends')) {
            Schema::create('sends', function (Blueprint $table) {
                $table->increments('id');
                $table->string('user_id');
                $table->string('other_id');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('s_name', 50)->nullable();
                $table->integer('cost');
                $table->string('loginType')->default('IG');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('ref_users')) {
            Schema::create('ref_users', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('oid');
                $table->string('name');
                $table->integer('target')->default(30);
                $table->integer('redeem');
                $table->string('did');
                $table->tinyInteger('ststus')->default(1); // (sic) legacy column name
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('online_users')) {
            Schema::create('online_users', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('facebook_posts')) {
            Schema::create('facebook_posts', function (Blueprint $table) {
                $table->id();
                $table->string('original_url');
                $table->string('post_id');
                $table->string('feedback_id');
                $table->string('story_id')->nullable();
                $table->string('name')->default('No Title');
                $table->string('post_type')->default('post'); // post|video|photo|reel
                $table->string('link_type')->default('1');
                $table->string('image_url')->nullable();
                $table->integer('total_reactions')->default(0);
                $table->integer('total_likes')->default(0);
                $table->integer('total_comments')->default(0);
                $table->timestamps();

                $table->unique(['original_url', 'post_id']);
                $table->index('post_id');
                $table->index('created_at');
            });
        }

        if (! Schema::hasTable('tiktok_timers')) {
            Schema::create('tiktok_timers', function (Blueprint $table) {
                $table->string('id', 100)->primary();
                $table->integer('timer');
                $table->string('link', 200);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('daily_checks')) {
            Schema::create('daily_checks', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('daily_rewards')) {
            Schema::create('daily_rewards', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('FB');
                $table->integer('IG');
                $table->integer('day');
                $table->string('text', 20);
                $table->string('css', 10);
            });
        }
    }

    /**
     * Guarded: never drop tables that may exist outside migrations.
     */
    public function down(): void
    {
        //
    }
};
