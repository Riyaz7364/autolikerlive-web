<?php

if (($argv[1] ?? '') === '') {
    fwrite(STDERR, "Missing Laravel blog path.\n");
    exit(1);
}

$blogPath = realpath(rtrim((string) $argv[1], DIRECTORY_SEPARATOR)) ?: rtrim((string) $argv[1], DIRECTORY_SEPARATOR);
$limit = max(1, min(500, (int) ($argv[2] ?? 100)));

if (! is_file($blogPath . DIRECTORY_SEPARATOR . 'artisan')) {
    fwrite(STDERR, "Laravel blog app not found: {$blogPath}\n");
    exit(1);
}

try {
    chdir($blogPath);

    require_once $blogPath . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
    Dotenv\Dotenv::createMutable($blogPath)->safeLoad();
    $app = require $blogPath . DIRECTORY_SEPARATOR . 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $posts = App\Models\Post::query()
        ->latest('created_at')
        ->limit($limit)
        ->get(['id', 'title', 'slug', 'views', 'created_at', 'updated_at'])
        ->map(function (App\Models\Post $post): array {
            return [
                'post_id' => $post->id,
                'title' => (string) $post->title,
                'slug' => (string) $post->slug,
                'url' => $post->permalink(),
                'views' => (int) $post->views,
                'created_at' => optional($post->created_at)->toDateTimeString(),
            ];
        })
        ->values()
        ->all();

    echo json_encode($posts, JSON_UNESCAPED_SLASHES) . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
