<?php

namespace App\Console\Commands;

use App\Services\DailyBlogResearchPublisher;
use Illuminate\Console\Command;
use Throwable;

class PublishDailyBlogPost extends Command
{
    protected $signature = 'blog:publish-daily
        {--topic= : Specific topic to research and publish}
        {--brief= : Extra research instructions for the article}
        {--dry-run : Generate the article payload without posting to WordPress}
        {--force : Publish even if a daily AI post already exists today}';

    protected $description = 'Research, generate, and publish a daily SEO blog post to WordPress.';

    public function handle(DailyBlogResearchPublisher $publisher): int
    {
        try {
            $result = $publisher->publish(
                $this->option('topic'),
                (bool) $this->option('dry-run'),
                (bool) $this->option('force'),
                $this->option('brief')
            );
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        if (($result['status'] ?? null) === 'skipped') {
            $this->warn($result['message']);
            return self::SUCCESS;
        }

        if (($result['status'] ?? null) === 'drafted') {
            $this->info('Draft generated successfully.');
            $this->line('Title: ' . $result['title']);
            $this->line('Topic: ' . $result['topic']);
            $this->line('article: ' . $result['article']);
            $this->line('Sources: ' . count($result['sources']));
            return self::SUCCESS;
        }

        if (($result['post_status'] ?? null) === 'draft') {
            $this->info('WordPress draft created successfully.');
            $this->line('Title: ' . $result['title']);
            $this->line('Post ID: ' . $result['post_id']);
            return self::SUCCESS;
        }

        $this->info('WordPress post published successfully.');
        $this->line('Title: ' . $result['title']);
        $this->line('Post ID: ' . $result['post_id']);
        $this->line('URL: ' . $result['url']);

        return self::SUCCESS;
    }
}
