<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // WebView (in-app) users can't follow external redirects or download
        // files, so the 'app' placement is retired. Move its promos to the
        // 'tools' placement (browser tool pages) where links work.
        DB::table('promotions')->where('show_on_app', true)->update([
            'show_on_tools' => true,
            'show_on_app' => false,
        ]);

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['show_on_app']);
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->boolean('show_on_app')->default(false)->after('show_on_homepage');
        });
    }
};
