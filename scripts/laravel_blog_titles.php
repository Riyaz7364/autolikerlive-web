<?php

if (($argv[1] ?? '') === '') {
    fwrite(STDERR, "Missing Laravel blog path.\n");
    exit(1);
}

$blogPath = rtrim((string) $argv[1], DIRECTORY_SEPARATOR);
$limit = max(1, min(1000, (int) ($argv[2] ?? 250)));

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

    $titles = App\Models\Post::query()
        ->latest('created_at')
        ->limit($limit)
        ->pluck('title')
        ->values()
        ->all();

    echo json_encode($titles, JSON_UNESCAPED_SLASHES) . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
