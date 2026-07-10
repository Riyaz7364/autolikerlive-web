<?php

namespace App\Console\Commands;

use App\Services\GoogleSearchConsoleKeywordResearch;
use Illuminate\Console\Command;
use Throwable;

class GoogleSearchConsoleReport extends Command
{
    protected $signature = 'gsc:report
        {--limit=100 : Rows to fetch for query, page, and query-page reports}
        {--print : Print the saved JSON report path and summary}';

    protected $description = 'Generate and save a Google Search Console report for AI blog research.';

    public function handle(GoogleSearchConsoleKeywordResearch $research): int
    {
        try {
            $report = $research->generateReport((int) $this->option('limit'));
            $path = $research->saveReport($report);
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $this->info('Google Search Console report saved.');
        $this->line('Path: ' . $path);
        $this->line('Range: ' . ($report['date_range']['start'] ?? '?') . ' to ' . ($report['date_range']['end'] ?? '?'));
        $this->line(sprintf(
            'Totals: %.0f impressions, %.0f clicks, %.2f%% CTR, %.1f average position',
            (float) ($report['totals']['impressions'] ?? 0),
            (float) ($report['totals']['clicks'] ?? 0),
            ((float) ($report['totals']['ctr'] ?? 0)) * 100,
            (float) ($report['totals']['position'] ?? 0)
        ));
        $this->line('Opportunities: ' . count($report['opportunities'] ?? []));
        $this->line('Top query/page rows: ' . count($report['top_query_pages'] ?? []));

        if ($this->option('print')) {
            $this->newLine();
            $this->line(json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        return self::SUCCESS;
    }
}
