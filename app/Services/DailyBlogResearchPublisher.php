<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use RuntimeException;
use SimpleXMLElement;
use Illuminate\Support\Facades\Http;

use Symfony\Component\Process\Process;

class DailyBlogResearchPublisher
{
    protected Client $http;


    public function __construct()
    {
        $this->http = new Client([
            'connect_timeout' => 20,
            'timeout' => 120,
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.aicredit.key'),
                'Content-Type' => 'application/json',
                'User-Agent' => 'Mozilla/5.0 (compatible; AutolikerLiveResearchBot/1.0)',
            ],
        ]);
    }

    public function publish(?string $topic = null, bool $dryRun = false, bool $force = false, ?string $brief = null): array
    {
        $topic = $topic ?: $this->chooseTopic();
        $brief = trim((string) $brief);
        $wpPath = base_path(config('services.daily_blog.wordpress_path', '../public_html/blog'));

        $sources = $this->research($topic, $brief);
        if (count($sources) < 3) {
            throw new RuntimeException('Research returned fewer than three usable sources.');
        }

        $article = $this->writeArticle($topic, $sources, $brief);
        $article = $this->optimizeArticleForYoast($article, $topic, $sources);
        $article['html'] = $this->normalizeLinks($article['html']);

        if ($dryRun) {
            return [
                'status' => 'drafted',
                'topic' => $topic,
                'title' => $article['title'],
                'sources' => $sources,
                'article' => $article['html'],
            ];
        }

        return $this->publishWithWordPressScript($wpPath, $article, $topic, $sources, $force);
    }

    protected function chooseTopic(): string
    {
        $aiTopic = $this->chooseTrendingTopicWithAi();
        if ($aiTopic !== null) {
            return $aiTopic;
        }

        $topics = array_values(array_filter(array_map(
            'trim',
            explode('|', (string) config('services.daily_blog.topics'))
        )));

        if ($topics === []) {
            $topics = [
                'Instagram engagement safety checklist for creators',
                'TikTok account growth mistakes advanced users still make',
                'Temporary email privacy tricks for social media signups',
                'Facebook page engagement diagnostics for small brands',
                'Social media automation risk controls for 2026',
            ];
        }

        return $topics[(int) now()->format('z') % count($topics)];
    }

    protected function chooseTrendingTopicWithAi(): ?string
    {
        if (! config('services.aicredit.key')) {
            return null;
        }

        try {
            $text = $this->chatText([
                [
                    'role' => 'system',
                    'content' => 'You choose safe, SEO-friendly blog topics for Autoliker Live.',
                ],
                [
                    'role' => 'user',
                    'content' => 'Return one unique, currently trending blog topic for social media creators, privacy tools, account safety, engagement diagnostics, or automation risk controls in 2026. Make it specific, useful, and safe. Return only the topic text, no numbering.',
                ],
            ], 120);
        } catch (\Throwable) {
            return null;
        }

        $topic = trim(preg_replace('/\s+/', ' ', strip_tags($text)) ?? '');
        $topic = trim($topic, " \t\n\r\0\x0B\"'`*-0123456789.");

        if ($topic === '' || str_word_count($topic) < 4) {
            return null;
        }

        $topic = Str::limit($topic, 120, '');
        $topic = preg_replace('/\s+(a|an|and|for|from|in|of|or|the|to|with)$/i', '', $topic) ?? $topic;

        return trim($topic);
    }

    protected function research(string $topic, string $brief = ''): array
    {
        $researchTopic = trim($topic . ' ' . $brief);
        $queries = [
            ['q' => $researchTopic . ' advanced research sources history list', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' archive forum review examples', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' скрытые приемы руководство', 'lang' => 'ru-RU'],
            ['q' => $researchTopic . ' 案例 列表 教程', 'lang' => 'zh-CN'],
            ['q' => $researchTopic . ' case study audit checklist', 'lang' => 'en-US'],
        ];

        $sources = [];
        foreach ($queries as $query) {
            foreach ($this->searchBingRss($query['q'], $query['lang']) as $item) {
                $host = parse_url($item['url'], PHP_URL_HOST);
                if (! $host || isset($sources[$item['url']])) {
                    continue;
                }

                $sources[$item['url']] = [
                    'title' => $item['title'],
                    'url' => $item['url'],
                    'snippet' => $item['snippet'],
                    'language' => Str::before($query['lang'], '-'),
                    'host' => $host,
                ];

                if (count($sources) >= 10) {
                    break 2;
                }
            }
        }

        return array_values($sources);
    }

    protected function searchBingRss(string $query, string $language): array
    {
        $url = 'https://www.bing.com/search?' . http_build_query([
            'q' => $query,
            'format' => 'rss',
            'setlang' => $language,
        ]);

        try {
            $response = $this->http->get($url);
            $xml = new SimpleXMLElement((string) $response->getBody());
        } catch (\Throwable) {
            return [];
        }

        $items = [];
        foreach ($xml->channel->item ?? [] as $item) {
            $link = trim((string) $item->link);
            if (! filter_var($link, FILTER_VALIDATE_URL)) {
                continue;
            }

            $items[] = [
                'title' => $this->cleanSourceTitle((string) $item->title, $link),
                'url' => $link,
                'snippet' => trim(strip_tags((string) $item->description)),
            ];
        }

        return $items;
    }

    protected function cleanSourceTitle(string $title, string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST) ?: 'source';
        $title = html_entity_decode(trim(strip_tags($title)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $title = preg_replace('/\s+/', ' ', $title) ?? $title;
        $title = trim($title, " \t\n\r\0\x0B-|");

        if ($title === '' || mb_strlen($title) < 18) {
            return $host;
        }

        if (! str_contains(mb_strtolower($title), mb_strtolower($host))) {
            return $title . ' (' . $host . ')';
        }

        return $title;
    }

    protected function writeArticle(string $topic, array $sources, string $brief = ''): array
    {
        $apiKey = config('services.aicredit.key');
        if (! $apiKey) {
            throw new RuntimeException('AICREDIT_API_KEY is missing.');
        }

        $internalLinks = array_values(array_filter(array_map(
            'trim',
            explode('|', (string) config('services.daily_blog.internal_links'))
        )));

        $json = $this->chatText([
            [
                'role' => 'system',
                'content' => 'You are an expert SEO editor. Return valid JSON only.',
            ],
            [
                'role' => 'user',
                'content' => $this->articlePrompt($topic, $sources, $internalLinks, $brief),
            ],
        ], 3000);

        $article = $this->decodeArticlePayload((string) $json);

        if (! is_array($article) || empty($article['title']) || empty($article['html'])) {
            throw new RuntimeException('AI Credits did not return a valid article payload.');
        }

        return $article;
    }

    protected function chatText(array $messages, int $maxTokens = 1500): string
    {
        $model = config('services.aicredit.model', 'gemini-2.0-flash');
        $baseUrl = rtrim((string) config('services.aicredit.base_url'), '/');

        $response = $this->http->post("{$baseUrl}/chat/completions", [
            'json' => [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.7,
            ],
        ]);

        $payload = json_decode((string) $response->getBody(), true);
        if (! is_array($payload)) {
            throw new RuntimeException('AI Credits response was not valid JSON.');
        }

        return $this->extractResponseText($payload);
    }

    protected function decodeArticlePayload(string $json): ?array
    {
        $article = json_decode($json, true);
        if (is_array($article)) {
            return $article;
        }

        $cleaned = trim($json);
        $cleaned = preg_replace('/^```(?:json)?\s*/i', '', $cleaned) ?? $cleaned;
        $cleaned = preg_replace('/\s*```$/', '', $cleaned) ?? $cleaned;

        $article = json_decode($cleaned, true);
        if (is_array($article)) {
            return $article;
        }

        $start = strpos($cleaned, '{');
        $end = strrpos($cleaned, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $article = json_decode(substr($cleaned, $start, $end - $start + 1), true);
            if (is_array($article)) {
                return $article;
            }
        }

        return null;
    }

    protected function articlePrompt(string $topic, array $sources, array $internalLinks, string $brief = ''): string
    {
        $sourceText = collect($sources)->map(function (array $source, int $index): string {
            return sprintf(
                "%d. [%s] %s\nURL: %s\nSnippet: %s",
                $index + 1,
                $source['language'],
                $source['title'],
                $source['url'],
                $source['snippet']
            );
        })->implode("\n\n");

        $links = $internalLinks === []
            ? config('app.url') . '/'
            : implode("\n", $internalLinks);
        $briefText = $brief === '' ? 'No extra brief provided.' : $brief;

        return <<<PROMPT
Write a detailed SEO tutorial for the topic: {$topic}

Extra research brief from the site owner:
{$briefText}

Research sources gathered from English, Russian, and Chinese searches:
{$sourceText}

Internal links available:
{$links}

Requirements:
- 900 to 1400 words.
- Choose one natural focus_keyphrase with 2 to 4 content words. Do not use a long sentence as the focus keyphrase.
- Put the exact focus_keyphrase at the beginning of the title.
- Put the exact focus_keyphrase in the slug.
- Put the exact focus_keyphrase in the first paragraph.
- Put the exact focus_keyphrase in the meta_description.
- Keep the SEO title under 58 characters and meta_description under 150 characters.
- Use the exact focus_keyphrase 3 to 6 times in the article body, naturally. Do not use it more than 6 times.
- Include the focus_keyphrase or a close synonym in at least one h2 or h3 subheading.
- Focus on non-obvious tactics, hidden checks, diagnostic workflows, and expert mistakes.
- Do not write generic beginner content.
- If the brief asks for old tools, websites, or services, cover them as historical research and risk analysis only. Do not provide working abuse instructions, credential-theft steps, fake engagement methods, or bypass tactics.
- Use the extra brief to decide what facts, lists, comparisons, and examples the article should include, but only cite details that are supported by the research sources.
- Include a clear H1-free HTML article body using h2/h3/p/ul/ol/table elements.
- Include at least 3 outbound source links from the provided sources. All outbound links must be useful citations.
- Include at least 2 internal links from the available internal links.
- Add image placeholders exactly as {{IN_POST_IMAGE_1}} and {{IN_POST_IMAGE_2}} in natural positions.
- Use practical step-by-step tutorial language.
- Vary sentence openings. Do not write 3 consecutive sentences that start with the same word.
- Avoid unsafe, spammy, deceptive, credential-theft, or platform-abuse instructions.
- Return JSON only with keys: focus_keyphrase, title, slug, meta_description, excerpt, html, tags, feature_image_prompt, in_post_image_prompts.
- tags must be an array of 4 to 7 short SEO tags.
- in_post_image_prompts must be an array of exactly 2 image prompts.
PROMPT;
    }

    protected function optimizeArticleForYoast(array $article, string $topic, array $sources): array
    {
        $keyphrase = $this->shortFocusKeyphrase((string) ($article['focus_keyphrase'] ?? ''), $topic);
        $article['focus_keyphrase'] = $keyphrase;

        $title = trim((string) ($article['title'] ?? $topic));
        if (stripos($title, $keyphrase) !== 0) {
            $title = $keyphrase . ': ' . ltrim($title, ":- \t\n\r\0\x0B");
        }
        $title = $this->shortenSeoTitle($title, $keyphrase);
        $article['title'] = $title;
        $article['seo_title'] = $title;

        $slugKeyphrase = Str::slug($keyphrase);
        $slug = Str::slug((string) ($article['slug'] ?? $title));
        if (! str_contains($slug, $slugKeyphrase)) {
            $slug = trim($slugKeyphrase . '-' . $slug, '-');
        }
        $article['slug'] = Str::limit($slug, 80, '');

        $meta = trim((string) ($article['meta_description'] ?? $article['excerpt'] ?? ''));
        if ($meta === '' || stripos($meta, $keyphrase) === false) {
            $meta = $keyphrase . ': ' . ltrim($meta ?: 'A practical SEO tutorial with safe checks, expert workflows, and creator-friendly steps.', ":- \t\n\r\0\x0B");
        }
        $article['meta_description'] = $this->shortenMetaDescription($meta, $keyphrase);

        $html = (string) ($article['html'] ?? '');
        $html = $this->ensureKeyphraseInFirstParagraph($html, $keyphrase);
        $html = $this->ensureKeyphraseInSubheading($html, $keyphrase);
        $html = $this->ensureKeyphraseDensity($html, $keyphrase, 3);
        $html = $this->limitKeyphraseDensity($html, $keyphrase, 6);
        $html = $this->ensureOutboundLinks($html, $sources);
        $html = $this->varyConsecutiveSentenceStarts($html);
        $article['html'] = $html;

        $article['feature_image_alt'] = $article['feature_image_alt'] ?? $keyphrase . ' tutorial image';
        $article['in_post_image_alts'] = $article['in_post_image_alts'] ?? [
            $keyphrase . ' visual example',
            $keyphrase . ' workflow example',
        ];

        return $article;
    }

    protected function shortFocusKeyphrase(string $candidate, string $topic): string
    {
        $candidate = trim(strip_tags($candidate)) ?: $topic;
        $words = preg_split('/\s+/', preg_replace('/[^\pL\pN\s-]+/u', ' ', $candidate) ?: '', -1, PREG_SPLIT_NO_EMPTY);
        $stopWords = ['a', 'an', 'and', 'are', 'as', 'at', 'by', 'for', 'from', 'in', 'into', 'of', 'on', 'or', 'the', 'to', 'with', 'your'];

        $contentWords = [];
        foreach ($words ?: [] as $word) {
            if (in_array(strtolower($word), $stopWords, true)) {
                continue;
            }

            $contentWords[] = $word;
            if (count($contentWords) === 4) {
                break;
            }
        }

        if ($contentWords === []) {
            return Str::headline(Str::limit($topic, 40, ''));
        }

        return implode(' ', $contentWords);
    }

    protected function shortenSeoTitle(string $title, string $keyphrase): string
    {
        $title = trim(preg_replace('/\s+/', ' ', strip_tags($title)) ?? $title);
        $maxLength = 58;

        if (mb_strlen($title) <= $maxLength) {
            return $title;
        }

        $separator = str_contains($title, ':') ? ':' : (str_contains($title, '-') ? '-' : '');
        $suffix = $separator !== '' ? trim(Str::after($title, $separator)) : trim(Str::after($title, $keyphrase));
        $available = $maxLength - mb_strlen($keyphrase) - 2;
        $suffix = $available > 10 ? trim(Str::limit($suffix, $available, '')) : '';

        return trim($keyphrase . ($suffix !== '' ? ': ' . $suffix : ''));
    }

    protected function shortenMetaDescription(string $meta, string $keyphrase): string
    {
        $meta = trim(preg_replace('/\s+/', ' ', strip_tags($meta)) ?? $meta);
        if (stripos($meta, $keyphrase) === false) {
            $meta = $keyphrase . ': ' . ltrim($meta, ":- \t\n\r\0\x0B");
        }

        return Str::limit($meta, 150, '');
    }

    protected function ensureKeyphraseInFirstParagraph(string $html, string $keyphrase): string
    {
        if (! preg_match('/<p\b[^>]*>(.*?)<\/p>/is', $html, $match)) {
            return '<p>' . e($keyphrase) . ' is the core topic of this practical guide.</p>' . $html;
        }

        if (stripos(strip_tags($match[1]), $keyphrase) !== false) {
            return $html;
        }

        return preg_replace(
            '/<p\b([^>]*)>/i',
            '<p$1>' . e($keyphrase) . ' is the focus of this guide: ',
            $html,
            1
        ) ?? $html;
    }

    protected function ensureKeyphraseInSubheading(string $html, string $keyphrase): string
    {
        if (preg_match('/<h[23]\b[^>]*>.*?' . preg_quote($keyphrase, '/') . '.*?<\/h[23]>/is', $html)) {
            return $html;
        }

        if (preg_match('/<h[23]\b/i', $html)) {
            return preg_replace_callback('/<(h[23])([^>]*)>(.*?)<\/\1>/is', function (array $match) use ($keyphrase): string {
                return '<' . $match[1] . $match[2] . '>' . e($keyphrase) . ': ' . $match[3] . '</' . $match[1] . '>';
            }, $html, 1) ?? $html;
        }

        return '<h2>' . e($keyphrase) . ' Checklist</h2>' . $html;
    }

    protected function ensureKeyphraseDensity(string $html, string $keyphrase, int $minimum): string
    {
        $count = preg_match_all('/' . preg_quote($keyphrase, '/') . '/i', strip_tags($html));
        if ($count >= $minimum) {
            return $html;
        }

        $needed = $minimum - $count;
        $sentences = [];
        for ($i = 0; $i < $needed; $i++) {
            $sentences[] = $keyphrase . ' should stay visible in the plan so every audit, image, and checklist section supports the same search intent.';
        }

        return $html . '<h2>' . e($keyphrase) . ' Final Review</h2><p>' . e(implode(' ', $sentences)) . '</p>';
    }

    protected function limitKeyphraseDensity(string $html, string $keyphrase, int $maximum): string
    {
        $seen = 0;
        $replacements = ['this workflow', 'the checklist', 'the process', 'the audit', 'the strategy'];

        return preg_replace_callback('/' . preg_quote($keyphrase, '/') . '/i', function (array $match) use (&$seen, $maximum, $replacements): string {
            $seen++;
            if ($seen <= $maximum) {
                return $match[0];
            }

            return $replacements[($seen - $maximum - 1) % count($replacements)];
        }, $html) ?? $html;
    }

    protected function ensureOutboundLinks(string $html, array $sources): string
    {
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $outboundCount = 0;

        if (preg_match_all('/<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>/i', $html, $matches)) {
            foreach ($matches[1] as $href) {
                $host = parse_url($href, PHP_URL_HOST);
                if ($host && $host !== $appHost) {
                    $outboundCount++;
                }
            }
        }

        if ($outboundCount >= 3) {
            return $html;
        }

        $links = [];
        $fallbackLinks = [];
        foreach ($sources as $source) {
            $url = (string) ($source['url'] ?? '');
            $title = trim((string) ($source['title'] ?? ''));
            $host = parse_url($url, PHP_URL_HOST);

            if (! filter_var($url, FILTER_VALIDATE_URL) || ! $host || $host === $appHost) {
                continue;
            }

            if ($this->isWeakSourceTitle($title)) {
                $link = '<li><a href="' . e($url) . '">' . e('Research source from ' . $host) . '</a></li>';
                $fallbackLinks[$url] = $link;
                continue;
            }

            $label = $this->sourceLinkLabel($title, $host);
            $link = '<li><a href="' . e($url) . '">' . e($label) . '</a></li>';
            $links[$url] = $link;
            if (count($links) >= 3 - $outboundCount) {
                break;
            }
        }

        foreach ($fallbackLinks as $url => $link) {
            if (count($links) >= 3 - $outboundCount) {
                break;
            }

            $links[$url] = $link;
        }

        if ($links === []) {
            return $html;
        }

        return $html . '<h2>Useful Source Links</h2><ul>' . implode('', $links) . '</ul>';
    }

    protected function sourceLinkLabel(string $title, string $host): string
    {
        $title = trim(preg_replace('/\s+/', ' ', strip_tags($title)) ?? $title);
        $title = trim($title, " \t\n\r\0\x0B-|");

        if ($title === '') {
            return 'Source from ' . $host;
        }

        if (! str_contains(mb_strtolower($title), mb_strtolower($host))) {
            return $title . ' (' . $host . ')';
        }

        return $title;
    }

    protected function isWeakSourceTitle(string $title): bool
    {
        $title = trim($title);

        return $title === ''
            || mb_strlen($title) < 28
            || preg_match('/\b(autolik|autoliker|auto liker|free likes?)\b/i', $title);
    }

    protected function varyConsecutiveSentenceStarts(string $html): string
    {
        $starters = ['Also, ', 'Next, ', 'Finally, ', 'Instead, '];
        $index = 0;

        return preg_replace_callback('/<p\b([^>]*)>(.*?)<\/p>/is', function (array $match) use ($starters, &$index): string {
            $text = $match[2];
            $parts = preg_split('/(?<=[.!?])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
            if (! $parts || count($parts) < 3) {
                return $match[0];
            }

            $lastWord = null;
            $run = 0;
            foreach ($parts as $partIndex => $sentence) {
                if (! preg_match('/^\s*(?:<[^>]+>\s*)*([\pL\pN]+)/u', strip_tags($sentence), $wordMatch)) {
                    $lastWord = null;
                    $run = 0;
                    continue;
                }

                $word = mb_strtolower($wordMatch[1]);
                $run = $word === $lastWord ? $run + 1 : 1;
                $lastWord = $word;

                if ($run >= 3) {
                    $parts[$partIndex] = $starters[$index % count($starters)] . ltrim($sentence);
                    $index++;
                    $run = 1;
                }
            }

            return '<p' . $match[1] . '>' . implode(' ', $parts) . '</p>';
        }, $html) ?? $html;
    }

    protected function normalizeLinks(string $html): string
    {
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);

        return preg_replace_callback('/<a\s+([^>]*href=["\']([^"\']+)["\'][^>]*)>/i', function (array $match) use ($appHost) {
            $attributes = $match[1];
            $href = $match[2];
            $host = parse_url($href, PHP_URL_HOST);

            if ($host && $host !== $appHost) {
                if (! preg_match('/\srel=/i', $attributes)) {
                    $attributes .= ' rel="nofollow noopener"';
                }

                if (! preg_match('/\starget=/i', $attributes)) {
                    $attributes .= ' target="_blank"';
                }
            }

            return '<a ' . $attributes . '>';
        }, $html);
    }

    protected function publishWithWordPressScript(string $wpPath, array $article, string $topic, array $sources, bool $force): array
    {
        $featureImage = $this->createImageFile(
            "{$topic}, no text on the image",
            Str::slug($article['slug'] ?? $article['title']) . '-feature',
            "780", "470"
        );

        $inPostImages = [];
        foreach (($article['in_post_image_prompts'] ?? []) as $index => $prompt) {
            $number = $index + 1;
            $inPostImages[] = [
                'placeholder' => '{{IN_POST_IMAGE_' . $number . '}}',
                'prompt' => $prompt,
                'path' => $this->createImageFile($prompt, Str::slug($article['slug'] ?? $article['title']) . "-in-post-{$number}", "512","512"),
            ];
        }

        $payloadPath = $this->writePublisherPayload($wpPath, $article, $topic, $sources, $featureImage, $inPostImages, $force);
        $script = base_path('scripts/wp_publish_daily_blog.php');

        $process = new Process([PHP_BINARY, $script, $payloadPath], base_path());
        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException(trim($process->getErrorOutput() ?: $process->getOutput()));
        }

        $result = json_decode(trim($process->getOutput()), true);
        if (! is_array($result)) {
            throw new RuntimeException('WordPress publisher did not return JSON: ' . $process->getOutput());
        }

        return $result;
    }

    protected function createImageFile(string $prompt, string $name, string $width, string $height): string
    {
        $dir = storage_path('app/daily-blog/images');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $path = $dir . DIRECTORY_SEPARATOR . $name . '-' . now()->format('YmdHis') . '.jpg';
        $http = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.cloudflare.key'),
        ])->post(config('services.cloudflare.base_url'), [
            'prompt' => $prompt,
            'width' => $width,
            "height" => $height
        ]);
        if($http->successful()){
            file_put_contents($path, $http->body());
        }else{
            file_put_contents($path, $this->placeholderPngBinary());
        }

        return $path;
    }

    protected function extractResponseText(array $payload): string
    {
        $content = $payload['choices'][0]['message']['content'] ?? null;
        if (is_string($content) && trim($content) !== '') {
            return trim($content);
        }

        $candidates = $payload['data'] ?? [];
        foreach ($candidates as $candidate) {
            foreach (($candidate['output_modalities'] ?? []) as $part) {
                if (! empty($part['text'])) {
                    return (string) $part['text'];
                }
            }
        }

        throw new RuntimeException('AI Credits response did not include text content.');
    }

    protected function placeholderPngBinary(): string
    {
        return base64_decode(
            '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxAQEBAQEBAVFRUVFRUVFRUVFRUVFRUVFRUWFhUVFRUYHSggGBolHRUVITEhJSkrLi4uFx8zODMsNygtLisBCgoKDg0OGxAQGy0lICYtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAAEAAgMBIgACEQEDEQH/xAAXAAADAQAAAAAAAAAAAAAAAAAAAQID/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEAMQAAAB6AAAAP/EABQQAQAAAAAAAAAAAAAAAAAAACD/2gAIAQEAAT8Af//EABQRAQAAAAAAAAAAAAAAAAAAACD/2gAIAQIBAT8Af//EABQRAQAAAAAAAAAAAAAAAAAAACD/2gAIAQMBAT8Af//Z',
            true
        ) ?: '';
    }

    protected function writePublisherPayload(
        string $wpPath,
        array $article,
        string $topic,
        array $sources,
        string $featureImage,
        array $inPostImages,
        bool $force
    ): string
    {
        $dir = storage_path('app/daily-blog/payloads');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $path = $dir . DIRECTORY_SEPARATOR . Str::slug($article['slug'] ?? $article['title']) . '-' . now()->format('YmdHis') . '.json';

        file_put_contents($path, json_encode([
            'wp_path' => $wpPath,
            'site_url' => config('app.url'),
            'mysql_socket' => config('services.daily_blog.mysql_socket'),
            'force' => $force,
            'post_status' => config('services.daily_blog.post_status', 'publish'),
            'author_id' => (int) config('services.daily_blog.author_id', 1),
            'category' => config('services.daily_blog.category', 'Guides'),
            'topic' => $topic,
            'sources' => $sources,
            'article' => $article,
            'feature_image' => $featureImage,
            'in_post_images' => $inPostImages,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $path;
    }
}
