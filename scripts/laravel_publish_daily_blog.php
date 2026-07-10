<?php

if (($argv[1] ?? '') === '') {
    fwrite(STDERR, "Missing payload path.\n");
    exit(1);
}

$payload = json_decode((string) file_get_contents($argv[1]), true);
if (! is_array($payload)) {
    fwrite(STDERR, "Invalid publisher payload.\n");
    exit(1);
}

$blogPath = rtrim((string) ($payload['blog_path'] ?? ''), DIRECTORY_SEPARATOR);
if ($blogPath === '' || ! is_file($blogPath . DIRECTORY_SEPARATOR . 'artisan')) {
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

    if (empty($payload['force']) && already_published_today()) {
        emit_json([
            'status' => 'skipped',
            'message' => 'A daily AI blog post has already been published today.',
        ]);
    }

    $article = $payload['article'] ?? [];
    if (! is_array($article) || empty($article['title']) || empty($article['html'])) {
        throw new RuntimeException('Publisher payload is missing article title or HTML.');
    }

    $user = resolve_author((int) ($payload['author_id'] ?? 1));
    $category = resolve_category((string) ($payload['category'] ?? 'Guides'));
    $slug = unique_slug((string) ($article['slug'] ?? $article['title']));
    $title = trim((string) $article['title']);
    $keyphrase = trim((string) ($article['focus_keyphrase'] ?? $payload['topic'] ?? $title));

    $thumbnail = store_blog_image((string) ($payload['feature_image'] ?? ''), $slug . '-feature');

    $html = (string) $article['html'];
    foreach (($payload['in_post_images'] ?? []) as $image) {
        $placeholder = (string) ($image['placeholder'] ?? '');
        if ($placeholder === '') {
            continue;
        }

        $relativePath = store_blog_image((string) ($image['path'] ?? ''), $slug . '-in-post');
        $html = str_replace($placeholder, image_html($relativePath, $keyphrase ?: $title), $html);
    }
    $html = preg_replace('/\{\{IN_POST_IMAGE_\d+\}\}/', '', $html) ?? $html;
    $html = trim($html) . "\n<!-- daily-ai-blog -->";

    $post = App\Models\Post::create([
        'user_id' => $user->id,
        'title' => $title,
        'slug' => $slug,
        'category_id' => $category->id,
        'content' => $html,
        'thumbnail' => $thumbnail,
        'views' => 0,
        'is_featured' => false,
        'enable_comment' => true,
        'status' => post_status_to_bool((string) ($payload['post_status'] ?? 'publish')),
    ]);

    $tagIds = [];
    foreach ((array) ($article['tags'] ?? []) as $tagName) {
        $tagName = trim((string) $tagName);
        if ($tagName === '') {
            continue;
        }

        $tagIds[] = App\Models\Tag::firstOrCreate(['name' => Illuminate\Support\Str::lower($tagName)])->id;
    }
    if ($tagIds !== []) {
        $post->tags()->sync(array_values(array_unique($tagIds)));
    }

    emit_json([
        'status' => 'published',
        'post_status' => $post->status ? 'publish' : 'draft',
        'post_id' => $post->id,
        'url' => $post->permalink(),
        'title' => $post->title,
    ]);
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}

function already_published_today(): bool
{
    return App\Models\Post::query()
        ->whereDate('created_at', Illuminate\Support\Carbon::today()->toDateString())
        ->where('content', 'like', '%<!-- daily-ai-blog -->%')
        ->exists();
}

function resolve_author(int $authorId): App\Models\User
{
    $user = App\Models\User::find($authorId) ?: App\Models\User::first();
    if ($user) {
        return $user;
    }

    return App\Models\User::create([
        'name' => 'Daily Blog Publisher',
        'username' => 'daily-blog-publisher',
        'email' => 'daily-blog-publisher@example.com',
        'password' => Illuminate\Support\Str::random(32),
        'role' => App\Models\User::IS_AUTHOR,
        'status' => true,
    ]);
}

function resolve_category(string $categoryName): App\Models\Category
{
    $categoryName = trim($categoryName) ?: 'Guides';
    $slug = Illuminate\Support\Str::slug($categoryName) ?: 'guides';

    return App\Models\Category::firstOrCreate(
        ['slug' => $slug],
        ['title' => $categoryName, 'description' => 'Daily AI blog posts', 'status' => true]
    );
}

function unique_slug(string $value): string
{
    $base = Illuminate\Support\Str::slug($value) ?: 'daily-blog-post';
    $slug = Illuminate\Support\Str::limit($base, 80, '');
    $candidate = $slug;
    $counter = 2;

    while (App\Models\Post::where('slug', $candidate)->exists()) {
        $suffix = '-' . $counter++;
        $candidate = Illuminate\Support\Str::limit($slug, 80 - strlen($suffix), '') . $suffix;
    }

    return $candidate;
}

function store_blog_image(string $sourcePath, string $name): string
{
    if ($sourcePath === '' || ! is_file($sourcePath)) {
        throw new RuntimeException("Image file not found: {$sourcePath}");
    }

    $bytes = (string) file_get_contents($sourcePath);
    $info = @getimagesizefromstring($bytes);
    $extension = $info && isset($info[2]) ? image_type_to_extension($info[2], false) : pathinfo($sourcePath, PATHINFO_EXTENSION);
    $extension = strtolower($extension ?: 'jpg');
    if ($extension === 'jpeg') {
        $extension = 'jpg';
    }

    $uploadSubdir = date('Y') . '/' . date('m');
    $storageDir = storage_path('app/public/uploads/' . $uploadSubdir);
    if (! is_dir($storageDir) && ! mkdir($storageDir, 0755, true) && ! is_dir($storageDir)) {
        throw new RuntimeException("Unable to create upload directory: {$storageDir}");
    }

    $filename = Illuminate\Support\Str::slug($name) . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(3)) . '.' . $extension;
    $relativePath = $uploadSubdir . '/' . $filename;
    file_put_contents(storage_path('app/public/uploads/' . $relativePath), $bytes);

    $publicPostDir = public_path('uploads/post/' . $uploadSubdir);
    if (! is_dir($publicPostDir)) {
        mkdir($publicPostDir, 0755, true);
    }
    file_put_contents($publicPostDir . DIRECTORY_SEPARATOR . $filename, $bytes);

    return $relativePath;
}

function image_html(string $relativePath, string $alt): string
{
    $url = rtrim((string) config('app.url'), '/') . '/storage/uploads/' . ltrim($relativePath, '/');
    $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    $safeAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');

    return '<figure><img src="' . $safeUrl . '" alt="' . $safeAlt . '" loading="lazy"></figure>';
}

function post_status_to_bool(string $status): bool
{
    return in_array(strtolower($status), ['1', 'true', 'publish', 'published'], true);
}

function emit_json(array $payload): void
{
    echo json_encode($payload, JSON_UNESCAPED_SLASHES) . PHP_EOL;
    exit(0);
}
