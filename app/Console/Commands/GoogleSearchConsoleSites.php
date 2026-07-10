<?php

namespace App\Console\Commands;

use App\Services\GoogleSearchConsoleKeywordResearch;
use Illuminate\Console\Command;
use Throwable;

class GoogleSearchConsoleSites extends Command
{
    protected $signature = 'gsc:sites';

    protected $description = 'List Google Search Console properties available to the stored access token.';

    public function handle(GoogleSearchConsoleKeywordResearch $research): int
    {
        try {
            $sites = $research->sites();
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        if ($sites === []) {
            $this->warn('No Search Console sites returned for this Google account/token.');
            return self::SUCCESS;
        }

        $this->table(
            ['Site URL', 'Permission'],
            array_map(fn (array $site): array => [
                $site['site_url'] ?? '',
                $site['permission_level'] ?? '',
            ], $sites)
        );

        $this->newLine();
        $this->line('Set DAILY_BLOG_GSC_SITE_URL exactly to one Site URL above, then run php artisan config:clear.');

        return self::SUCCESS;
    }
}
