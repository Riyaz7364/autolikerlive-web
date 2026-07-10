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

$loader = rtrim($payload['wp_path'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'wp-load.php';
if (! is_file($loader)) {
    fwrite(STDERR, "WordPress loader not found: {$loader}\n");
    exit(1);
}

$_SERVER['HTTP_HOST'] = parse_url($payload['site_url'] ?? 'https://www.autolikerlive.com', PHP_URL_HOST) ?: 'www.autolikerlive.com';
$_SERVER['REQUEST_URI'] = '/blog/';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

$socket = $payload['mysql_socket'] ?? null;
$hasTemporaryErrorHandler = false;
if ($socket && file_exists($socket) && ! defined('DB_HOST')) {
    define('DB_HOST', 'localhost:' . $socket);
    set_error_handler(function (int $severity, string $message): bool {
        if (str_contains($message, 'Constant DB_HOST already defined')) {
            return true;
        }

        return false;
    });
    $hasTemporaryErrorHandler = true;
}

define('WP_USE_THEMES', false);
ob_start();
require_once $loader;
ob_end_clean();

if ($hasTemporaryErrorHandler) {
    restore_error_handler();
}

try {
    if (empty($payload['force']) && already_published_today()) {
        emit_json([
            'status' => 'skipped',
            'message' => 'A daily AI blog post has already been published today.',
        ]);
    }

    $article = $payload['article'];
    $keyphrase = trim((string) ($article['focus_keyphrase'] ?? $payload['topic'] ?? $article['title'] ?? ''));
    $seoTitle = $article['seo_title'] ?? $article['title'];
    $featureAlt = $article['feature_image_alt'] ?? ($keyphrase ? $keyphrase . ' tutorial image' : $article['title']);
    $featureId = create_attachment_from_file($payload['feature_image'], ($article['slug'] ?? $article['title']) . '-feature', $featureAlt);

    $html = $article['html'] ?? '';
    foreach ($payload['in_post_images'] ?? [] as $image) {
        $imageNumber = (int) preg_replace('/\D+/', '', $image['placeholder'] ?? '0');
        $alt = $article['in_post_image_alts'][$imageNumber - 1] ?? ($keyphrase ? $keyphrase . ' example image' : $article['title']);
        $attachmentId = create_attachment_from_file($image['path'], ($article['slug'] ?? $article['title']) . '-in-post', $alt);
        $imageHtml = image_block($attachmentId, $alt, (string) ($image['prompt'] ?? ''));
        $html = str_replace($image['placeholder'], $imageHtml, $html);
    }
    $html = preg_replace('/\{\{IN_POST_IMAGE_\d+\}\}/', '', $html);
    $html = content_to_blocks($html);

    $postId = wp_insert_post([
        'post_title' => sanitize_text_field($article['title']),
        'post_name' => sanitize_title($article['slug'] ?? $article['title']),
        'post_excerpt' => sanitize_text_field($article['excerpt'] ?? $article['meta_description'] ?? ''),
        'post_content' => $html,
        'post_status' => $payload['post_status'] ?? 'publish',
        'post_author' => (int) ($payload['author_id'] ?? 1),
        'post_category' => category_ids($payload['category'] ?? 'Guides'),
        'meta_input' => [
            '_daily_ai_blog' => '1',
            '_daily_ai_blog_topic' => $payload['topic'] ?? '',
            '_daily_ai_blog_sources' => wp_json_encode($payload['sources'] ?? []),
            '_yoast_wpseo_focuskw' => $keyphrase,
            '_yoast_wpseo_title' => $seoTitle,
            '_yoast_wpseo_metadesc' => $article['meta_description'] ?? '',
            'rank_math_focus_keyword' => $keyphrase,
            'rank_math_title' => $seoTitle,
            'rank_math_description' => $article['meta_description'] ?? '',
        ],
    ], true);

    if (is_wp_error($postId)) {
        throw new RuntimeException($postId->get_error_message());
    }

    set_post_thumbnail($postId, $featureId);
    wp_set_post_tags($postId, $article['tags'] ?? [], true);

    emit_json([
        'status' => 'published',
        'post_status' => $payload['post_status'] ?? 'publish',
        'post_id' => $postId,
        'url' => get_permalink($postId),
        'title' => $article['title'],
    ]);
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}

function already_published_today(): bool
{
    $posts = get_posts([
        'post_type' => 'post',
        'post_status' => ['publish', 'future', 'draft'],
        'date_query' => [[
            'after' => gmdate('Y-m-d 00:00:00'),
            'before' => gmdate('Y-m-d 23:59:59'),
            'inclusive' => true,
        ]],
        'meta_query' => [[
            'key' => '_daily_ai_blog',
            'value' => '1',
        ]],
        'fields' => 'ids',
        'posts_per_page' => 1,
    ]);

    return $posts !== [];
}

function create_attachment_from_file(string $path, string $name, string $alt = ''): int
{
    if (! is_file($path)) {
        throw new RuntimeException("Image file not found: {$path}");
    }

    $filename = sanitize_file_name($name . '-' . gmdate('YmdHis') . '.png');
    $upload = wp_upload_bits($filename, null, (string) file_get_contents($path));
    if (! empty($upload['error'])) {
        throw new RuntimeException($upload['error']);
    }

    $attachmentId = wp_insert_attachment([
        'post_mime_type' => 'image/png',
        'post_title' => sanitize_text_field(ucwords(str_replace(['-', '_'], ' ', $name))),
        'post_content' => '',
        'post_status' => 'inherit',
    ], $upload['file']);

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $metadata = wp_generate_attachment_metadata($attachmentId, $upload['file']);
    wp_update_attachment_metadata($attachmentId, $metadata);
    if ($alt !== '') {
        update_post_meta($attachmentId, '_wp_attachment_image_alt', sanitize_text_field($alt));
    }

    return (int) $attachmentId;
}

function image_block(int $attachmentId, string $alt, string $prompt = ''): string
{
    $image = wp_get_attachment_image($attachmentId, 'large', false, [
        'alt' => $alt,
        'class' => 'wp-image-' . $attachmentId,
        'loading' => 'lazy',
    ]);
    $caption = trim($prompt) !== ''
        ? '<figcaption class="wp-element-caption">Image prompt: ' . esc_html($prompt) . '</figcaption>'
        : '';

    return '<figure class="wp-block-image size-large">' . $image . $caption . '</figure>';
}

function content_to_blocks(string $html): string
{
    if (str_contains($html, '<!-- wp:')) {
        return $html;
    }

    $html = trim($html);
    preg_match_all('/<(h2|h3|p|ul|ol|table|figure)\b[^>]*>.*?<\/\1>/is', $html, $matches);
    if (empty($matches[0])) {
        return '<!-- wp:paragraph -->' . $html . '<!-- /wp:paragraph -->';
    }

    return implode("\n\n", array_map('html_to_block', $matches[0]));
}

function html_to_block(string $chunk): string
{
    if (preg_match('/^<h2\b/i', $chunk)) {
        return "<!-- wp:heading -->\n{$chunk}\n<!-- /wp:heading -->";
    }

    if (preg_match('/^<h3\b/i', $chunk)) {
        return "<!-- wp:heading {\"level\":3} -->\n{$chunk}\n<!-- /wp:heading -->";
    }

    if (preg_match('/^<p\b/i', $chunk)) {
        return "<!-- wp:paragraph -->\n{$chunk}\n<!-- /wp:paragraph -->";
    }

    if (preg_match('/^<ul\b/i', $chunk)) {
        return "<!-- wp:list -->\n{$chunk}\n<!-- /wp:list -->";
    }

    if (preg_match('/^<ol\b/i', $chunk)) {
        return "<!-- wp:list {\"ordered\":true} -->\n{$chunk}\n<!-- /wp:list -->";
    }

    if (preg_match('/^<table\b/i', $chunk)) {
        return "<!-- wp:table -->\n<figure class=\"wp-block-table\">{$chunk}</figure>\n<!-- /wp:table -->";
    }

    if (preg_match('/^<figure\b[^>]*wp-block-image/i', $chunk)) {
        return "<!-- wp:image -->\n{$chunk}\n<!-- /wp:image -->";
    }

    return "<!-- wp:html -->\n{$chunk}\n<!-- /wp:html -->";
}

function category_ids(string $category): array
{
    $term = term_exists($category, 'category');
    if (! $term) {
        $term = wp_insert_term($category, 'category');
    }

    if (is_wp_error($term)) {
        return [1];
    }

    return [(int) (is_array($term) ? $term['term_id'] : $term)];
}

function emit_json(array $payload): void
{
    echo wp_json_encode($payload, JSON_UNESCAPED_SLASHES) . PHP_EOL;
    exit(0);
}
