<?php

namespace App\Console\Commands;

use App\Services\GoogleSearchConsoleKeywordResearch;
use Illuminate\Console\Command;
use Throwable;

class GoogleSearchConsoleKeywords extends Command
{
    protected $signature = 'gsc:keywords {--limit=10 : Number of keyword opportunities to show}';

    protected $description = 'Preview non-repeated Google Search Console keyword opportunities for the daily blog.';

    public function handle(GoogleSearchConsoleKeywordResearch $research): int
    {
        try {
            $keywords = $research->keywordOpportunities((int) $this->option('limit'));
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        if ($keywords === []) {
            $this->warn('No usable GSC keyword opportunities found. Check auth, site URL, or filters.');
            return self::SUCCESS;
        }

        $this->table(
            ['Query', 'Clicks', 'Impressions', 'CTR %', 'Position', 'Score'],
            array_map(fn (array $row): array => [
                $row['query'],
                (int) $row['clicks'],
                (int) $row['impressions'],
                round($row['ctr'] * 100, 2),
                round($row['position'], 1),
                $row['score'],
            ], $keywords)
        );

        return self::SUCCESS;
    }
}
