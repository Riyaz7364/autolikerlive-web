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
        $brief = trim((string) $brief);
        $gscTopic = null;

        if (! $topic) {
            $gscTopic = $this->chooseTopicFromSearchConsole();
            if ($gscTopic) {
                $topic = $gscTopic['topic'];
                $brief = trim($brief . ' ' . $gscTopic['brief']);
            } else {
                $topic = $this->chooseTopic();
            }
        }


        $blogPath = base_path(config('services.daily_blog.laravel_blog_path', '../public_html/blog'));

        $sources = $this->research($topic, $brief);

        \Log::info('Research found ' . print_r($sources, true) . ' sources for topic: ' . $topic);
        if (count($sources) < 3) {
            throw new RuntimeException('Research returned fewer than three usable sources.');
        }

        $article = $this->writeArticle($topic, $sources, $brief);
        $article = $this->optimizeArticleForYoast($article, $topic, $sources);
        $article = $this->ensureUniqueArticleIdentity($article, $topic, $brief);
        $article['html'] = $this->normalizeLinks($article['html']);

        if ($dryRun) {
            return [
                'status' => 'drafted',
                'topic' => $topic,
                'gsc_keyword' => $gscTopic['keyword'] ?? null,
                'gsc_metrics' => $gscTopic['metrics'] ?? null,
                'title' => $article['title'],
                'sources' => $sources,
                'article' => $article['html'],
            ];
        }

        $result = $this->publishWithLaravelBlogScript($blogPath, $article, $topic, $sources, $force);
        if ($gscTopic && (($result['status'] ?? null) === 'published')) {
            app(GoogleSearchConsoleKeywordResearch::class)->markUsed(
                $gscTopic['keyword'],
                $topic,
                (string) ($result['title'] ?? $article['title'] ?? ''),
                (array) ($gscTopic['metrics'] ?? [])
            );
        }

        return $result;
    }

    protected function chooseTopicFromSearchConsole(): ?array
    {
        try {
            return app(GoogleSearchConsoleKeywordResearch::class)->chooseTopic();
        } catch (\Throwable) {
            return null;
        }
    }

    protected function savedSearchConsoleBrief(): string
    {
        try {
            return app(GoogleSearchConsoleKeywordResearch::class)->latestReportBrief();
        } catch (\Throwable) {
            return '';
        }
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
                'TikTok viral trends that creators are missing',
                'Instagram engagement secrets nobody talks about',
                'YouTube Shorts algorithm tips for 2026',
                'Twitter/X growth hacks for viral content',
                'Threads growth strategies for creators',
                'LinkedIn trending topics for engagement',
                'Bluesky social platform tips and tricks',
                'Social media analytics red flags you should know',
                'Platform algorithm changes affecting creators',
                'Viral video editing tricks trending creators use',
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
                    'content' => 'You choose viral, trending, and evergreen blog topics for social media creators and digital marketers across all platforms (TikTok, Instagram, YouTube, Twitter, LinkedIn, Threads, Bluesky, etc.). Topics should be engaging, timely, and creator-focused.',
                ],
                [
                    'role' => 'user',
                    'content' => 'Return one unique, currently trending, viral blog topic for social media creators, viral content tips, platform algorithm insights, creator tactics, trending sounds/trends, editing techniques, growth hacks, engagement strategies, or insider secrets. Focus on content that is interesting, shareable, and useful for creators. Make it specific, engaging, and trendy. Return only the topic text, no numbering.',
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

    protected function webClient(): Client
    {
        return new Client([
            'connect_timeout' => 12,
            'timeout' => 30,
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,text/plain;q=0.8,*/*;q=0.5',
                'User-Agent' => 'Mozilla/5.0 (compatible; AutolikerLiveResearchBot/1.0)',
            ],
        ]);
    }

    protected function research(string $topic, string $brief = ''): array
    {
        $researchTopic = $this->searchableResearchTopic($topic, $brief);
        \Log::debug('Starting research for topic', ['topic' => $topic, 'searchable_topic' => $researchTopic]);
        
        $queries = [
            ['q' => $researchTopic . ' forum discussion archive', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' public archive old tool warning', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' reddit forum case study', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' скрытые приемы форум архив', 'lang' => 'ru-RU'],
            ['q' => $researchTopic . ' обзор форум инструкция риск', 'lang' => 'ru-RU'],
            ['q' => $researchTopic . ' case study security research', 'lang' => 'en-US'],
        ];

        $sources = [];
        $seeds = $this->configuredResearchSeeds();
        \Log::debug('Configured research seeds found', ['count' => count($seeds)]);
        
        foreach ($seeds as $url) {
            $host = parse_url($url, PHP_URL_HOST);
            if (! $host || isset($sources[$url]) || $this->isBlockedSource($url, '')) {
                continue;
            }

            $source = [
                'title' => $host,
                'url' => $url,
                'snippet' => 'Configured source from site owner.',
                'language' => 'seed',
                'host' => $host,
                'query' => 'configured seed URL',
            ];
            $source = array_merge($source, $this->fetchSourceEvidence($source, $topic));
            if (! empty($source['page_title'])) {
                $source['title'] = $source['page_title'] . ' (' . $host . ')';
            }
            $source['score'] = max($this->sourceQualityScore($source, $topic), ! empty($source['fetched']) ? 4 : 0);

            if ($source['score'] >= 3) {
                $sources[$url] = $source;
            }
        }

        foreach ($queries as $query) {
            \Log::debug('Executing search query', ['query' => $query['q']]);
            $results = $this->searchResults($query['q'], $query['lang']);
            \Log::debug('Search results found', ['query' => $query['q'], 'count' => count($results)]);
            
            foreach ($results as $item) {
                $url = (string) ($item['url'] ?? '');
                $host = parse_url($url, PHP_URL_HOST);
                if (! $host || isset($sources[$url]) || $this->isBlockedSource($url, (string) ($item['title'] ?? ''))) {
                    continue;
                }

                $source = [
                    'title' => $item['title'],
                    'url' => $url,
                    'snippet' => $item['snippet'],
                    'language' => Str::before($query['lang'], '-'),
                    'host' => $host,
                    'query' => $query['q'],
                ];

                $source = array_merge($source, $this->fetchSourceEvidence($source, $topic));
                if (! empty($source['page_title'])) {
                    $source['title'] = $source['page_title'] . ' (' . $host . ')';
                }
                $source['score'] = $this->sourceQualityScore($source, $topic);

                if ($source['score'] < 3) {
                    continue;
                }

                $sources[$url] = $source;
                if (count($sources) >= 14) {
                    break 2;
                }
            }
        }

        if (count($sources) < 3) {
            \Log::warning('Research returned too few sources after primary search; running fallback search.', ['topic' => $topic, 'count' => count($sources)]);
            $this->addSearchSourcesFromQueries($this->fallbackResearchQueries($researchTopic), $sources, $topic, 2, true);
        }

        if (count($sources) < 3) {
            \Log::warning('Still under 3 sources after fallback; using configured seeds as last resort.', ['topic' => $topic, 'count' => count($sources)]);

            foreach ($seeds as $url) {
                $host = parse_url($url, PHP_URL_HOST);
                if (! $host || isset($sources[$url]) || $this->isBlockedSource($url, '')) {
                    continue;
                }

                $source = [
                    'title' => $host,
                    'url' => $url,
                    'snippet' => 'Fallback configured source from site owner.',
                    'language' => 'seed',
                    'host' => $host,
                    'query' => 'configured seed fallback',
                ];

                $source = array_merge($source, $this->fetchSourceEvidence($source, $topic));
                if (! empty($source['page_title'])) {
                    $source['title'] = $source['page_title'] . ' (' . $host . ')';
                }
                $source['score'] = max($this->sourceQualityScore($source, $topic), 2);

                if ($source['score'] >= 2) {
                    $sources[$url] = $source;
                }

                if (count($sources) >= 3) {
                    break;
                }
            }
        }

        uasort($sources, fn (array $a, array $b): int => ($b['score'] ?? 0) <=> ($a['score'] ?? 0));

        return array_slice(array_values($sources), 0, 10);
    }

    protected function configuredResearchSeeds(): array
    {
        $urls = array_filter(array_map('trim', explode('|', (string) config('services.daily_blog.research_seed_urls'))));

        return array_values(array_filter($urls, fn (string $url): bool => filter_var($url, FILTER_VALIDATE_URL) !== false));
    }

    protected function fallbackResearchQueries(string $researchTopic): array
    {
        return [
            ['q' => $researchTopic . ' forum thread old tricks', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' grey web discussion archive', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' hidden group warning', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' private discussion archive', 'lang' => 'en-US'],
            ['q' => $researchTopic . ' старые приёмы форум', 'lang' => 'ru-RU'],
            ['q' => $researchTopic . ' скрытые инструменты риск', 'lang' => 'ru-RU'],
            ['q' => 'site:habr.com ' . $researchTopic, 'lang' => 'en-US'],
            ['q' => 'site:pikabu.ru ' . $researchTopic, 'lang' => 'ru-RU'],
            ['q' => 'site:vc.ru ' . $researchTopic, 'lang' => 'ru-RU'],
        ];
    }

    protected function addSearchSourcesFromQueries(array $queries, array &$sources, string $topic, int $minScore = 3, bool $stopAtThree = false): void
    {
        foreach ($queries as $query) {
            \Log::debug('Executing fallback search query', ['query' => $query['q']]);
            $results = $this->searchResults($query['q'], $query['lang']);
            \Log::debug('Fallback search results found', ['query' => $query['q'], 'count' => count($results)]);

            foreach ($results as $item) {
                $url = (string) ($item['url'] ?? '');
                $host = parse_url($url, PHP_URL_HOST);
                if (! $host || isset($sources[$url]) || $this->isBlockedSource($url, (string) ($item['title'] ?? ''))) {
                    continue;
                }

                $source = [
                    'title' => $item['title'],
                    'url' => $url,
                    'snippet' => $item['snippet'],
                    'language' => Str::before($query['lang'], '-'),
                    'host' => $host,
                    'query' => $query['q'],
                ];

                $source = array_merge($source, $this->fetchSourceEvidence($source, $topic));
                if (! empty($source['page_title'])) {
                    $source['title'] = $source['page_title'] . ' (' . $host . ')';
                }
                $source['score'] = $this->sourceQualityScore($source, $topic);

                if ($source['score'] < $minScore) {
                    continue;
                }

                $sources[$url] = $source;
                if ($stopAtThree && count($sources) >= 3) {
                    return;
                }
                if (count($sources) >= 14) {
                    return;
                }
            }
        }
    }

    protected function searchableResearchTopic(string $topic, string $brief): string
    {
        $text = trim($topic . ' ' . preg_replace('/\b(impressions?|clicks?|ctr|position|bounce|analytics|search console|metrics?)\b[^.]{0,80}/i', ' ', $brief));
        $text = preg_replace('/["“”]+/', ' ', $text) ?? $text;
        $text = preg_replace('/\s+/', ' ', $text) ?? $text;

        return Str::limit(trim($text), 140, '');
    }

    protected function searchResults(string $query, string $language): array
    {
        $items = $this->searchDuckDuckGoHtml($query, $language);
        if (count($items) < 4) {
            $items = array_merge($items, $this->searchBingRss($query, $language));
        }

        $seen = [];
        $unique = [];
        foreach ($items as $item) {
            $url = (string) ($item['url'] ?? '');
            if ($url === '' || isset($seen[$url])) {
                continue;
            }
            $seen[$url] = true;
            $unique[] = $item;
        }

        return $unique;
    }

    protected function searchDuckDuckGoHtml(string $query, string $language): array
    {
        $region = str_starts_with($language, 'ru') ? 'ru-ru' : 'us-en';
        $url = 'https://duckduckgo.com/html/?' . http_build_query([
            'q' => $query,
            'kl' => $region,
        ]);

        try {
            $response = $this->webClient()->get($url, [
                'timeout' => 20,
                'connect_timeout' => 8,
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'text/html,application/xhtml+xml',
                    'User-Agent' => 'Mozilla/5.0 (compatible; AutolikerLiveResearchBot/1.0)',
                ],
            ]);
        } catch (\Throwable $e) {
            \Log::warning('DuckDuckGo search failed for query: ' . $query, ['error' => $e->getMessage()]);
            return [];
        }

        if ($response->getStatusCode() >= 400) {
            return [];
        }

        $html = (string) $response->getBody();
        $items = [];
        if (! preg_match_all('/<a[^>]+class="[^"]*result__a[^"]*"[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>/is', $html, $matches, PREG_SET_ORDER)) {
            return [];
        }

        foreach ($matches as $match) {
            $link = html_entity_decode((string) $match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if (str_contains($link, '/l/?')) {
                $parts = parse_url($link);
                parse_str((string) ($parts['query'] ?? ''), $params);
                $link = (string) ($params['uddg'] ?? $link);
            }

            if (! filter_var($link, FILTER_VALIDATE_URL)) {
                continue;
            }

            $title = $this->cleanSourceTitle((string) $match[2], $link);
            $items[] = [
                'title' => $title,
                'url' => $link,
                'snippet' => '',
            ];

            if (count($items) >= 12) {
                break;
            }
        }

        return $items;
    }

    protected function searchBingRss(string $query, string $language): array
    {
        $url = 'https://www.bing.com/search?' . http_build_query([
            'q' => $query,
            'format' => 'rss',
            'setlang' => $language,
        ]);

        try {
            $response = $this->webClient()->get($url);
            $xml = new SimpleXMLElement((string) $response->getBody());
        } catch (\Throwable $e) {
            \Log::warning('Bing search failed for query: ' . $query, ['error' => $e->getMessage()]);
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

    protected function fetchSourceEvidence(array $source, string $topic): array
    {
        $url = (string) ($source['url'] ?? '');
        try {
            $response = $this->webClient()->get($url, [
                'timeout' => 18,
                'connect_timeout' => 8,
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'text/html,application/xhtml+xml,text/plain;q=0.8,*/*;q=0.5',
                    'User-Agent' => 'Mozilla/5.0 (compatible; AutolikerLiveResearchBot/1.0)',
                ],
            ]);
        } catch (\Throwable) {
            return [
                'evidence' => '',
                'content_words' => 0,
                'fetched' => false,
                'page_title' => '',
            ];
        }

        $contentType = strtolower((string) ($response->getHeaderLine('Content-Type') ?: ''));
        if ($response->getStatusCode() >= 400 || ($contentType !== '' && ! str_contains($contentType, 'html') && ! str_contains($contentType, 'text'))) {
            return [
                'evidence' => '',
                'content_words' => 0,
                'fetched' => false,
                'page_title' => '',
            ];
        }

        $body = Str::limit((string) $response->getBody(), 350000, '');
        $pageTitle = '';
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $body, $titleMatch)) {
            $pageTitle = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($titleMatch[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?? '');
        }
        $text = $this->extractPageText($body);
        $words = $this->articleWordCount($text);
        $sentences = preg_split('/(?<=[.!?])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $topicWords = $this->meaningfulWords($topic);
        $picked = [];

        foreach ($sentences as $sentence) {
            $plain = trim($sentence);
            if (mb_strlen($plain) < 80 || mb_strlen($plain) > 360) {
                continue;
            }

            $lower = mb_strtolower($plain);
            $hits = 0;
            foreach ($topicWords as $word) {
                if (str_contains($lower, $word)) {
                    $hits++;
                }
            }

            if ($hits > 0 || preg_match('/\b(forum|archive|risk|privacy|safety|tool|account|facebook|instagram|youtube|tiktok|russian|рус|форум)\b/iu', $plain)) {
                $picked[] = $plain;
            }

            if (count($picked) >= 5) {
                break;
            }
        }

        if ($picked === []) {
            $picked[] = Str::limit($text, 700, '');
        }

        return [
            'evidence' => trim(implode(' ', array_filter($picked))),
            'content_words' => $words,
            'fetched' => $words >= 120,
            'page_title' => $pageTitle,
        ];
    }

    protected function extractPageText(string $html): string
    {
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', ' ', $html) ?? $html;
        $html = preg_replace('/<style\b[^>]*>.*?<\/style>/is', ' ', $html) ?? $html;
        $html = preg_replace('/<nav\b[^>]*>.*?<\/nav>/is', ' ', $html) ?? $html;
        $html = preg_replace('/<footer\b[^>]*>.*?<\/footer>/is', ' ', $html) ?? $html;
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text) ?? $text;

        return trim($text);
    }

    protected function isBlockedSource(string $url, string $title): bool
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $path = strtolower((string) parse_url($url, PHP_URL_PATH));
        $haystack = strtolower($host . ' ' . $path . ' ' . $title);

        if (preg_match('/\.(pdf|jpg|jpeg|png|gif|webp|zip|rar|apk|exe|dmg|mp4|mp3)$/i', $path)) {
            return true;
        }

        return preg_match('/\b(pinterest|youtube\.com\/watch|youtu\.be|facebook\.com|instagram\.com|tiktok\.com|amazon\.|flipkart|aliexpress|shopify|play\.google|apps\.apple|apps\.microsoft|microsoft\.com\/store|login|signup|tag\/|category\/)\b/i', $haystack) === 1;
    }

    protected function sourceQualityScore(array $source, string $topic): int
    {
        $score = 0;
        $host = strtolower((string) ($source['host'] ?? ''));
        $title = strtolower((string) ($source['title'] ?? ''));
        $snippet = strtolower((string) ($source['snippet'] ?? ''));
        $evidence = strtolower((string) ($source['evidence'] ?? ''));
        $combined = $title . ' ' . $snippet . ' ' . $evidence;

        if (! empty($source['fetched'])) {
            $score += 3;
        }
        if (($source['content_words'] ?? 0) >= 350) {
            $score += 2;
        }
        if (preg_match('/\b(forum|community|thread|archive|reddit|github|stackexchange|medium|habr|vc\.ru|pikabu|4pda|xakep|security|research|case study|guide|docs|support)\b/i', $host . ' ' . $combined)) {
            $score += 2;
        }
        if (preg_match('/\b(forum|archive|case study|research|risk|warning|privacy|security|история|форум|обзор|инструкция|риск)\b/iu', $combined)) {
            $score += 2;
        }

        foreach ($this->meaningfulWords($topic) as $word) {
            if (str_contains($combined, $word)) {
                $score++;
            }
        }

        if ($this->isWeakSourceTitle((string) ($source['title'] ?? ''))) {
            $score -= 2;
        }

        if (empty($source['fetched']) && ! preg_match('/\b(forum|community|thread|archive|reddit|github|habr|4pda|xakep)\b/i', $host)) {
            $score = min($score, 2);
        }

        return $score;
    }

    protected function meaningfulWords(string $text): array
    {
        $text = mb_strtolower(strip_tags($text));
        preg_match_all('/[\pL\pN]{4,}/u', $text, $matches);
        $stop = ['with', 'from', 'this', 'that', 'your', 'guide', 'tips', 'tricks', 'best', 'safe', 'workflow', 'notes', 'source'];

        return array_values(array_unique(array_filter($matches[0] ?? [], fn (string $word): bool => ! in_array($word, $stop, true))));
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

    public function abuseFilter(string $text)
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
                'content' => '
You are an advanced multilingual toxicity and profanity detection AI.

Your task:
- Detect abusive, offensive, toxic, hateful, sexual, violent, discriminatory, or harassing language.
- Detect hidden profanity using symbols, stars, hashes, spaces, repeated letters, or leetspeak.
- Detect censored words like:
  - f***
  - b!tch
  - n1gg4
  - a$$hole
  - idi0t
  - fk u
  - stfu
  - k.y.s
- Detect slang, short forms, romanized abuse, mixed-language insults, and coded harassment.
- Detect religion-based abuse, communal slurs, casteist insults, extremist slogans, and targeted hate speech.
- Detect offensive nicknames or derogatory variations used against religious groups, communities, or identities.
- Detect abuse targeting public figures including politicians, actors, influencers, streamers, celebrities, and social personalities.
- Detect Indian political hate terms, communal insults, propaganda slurs, and abusive references toward political leaders or supporters.
- Detect toxic references written in Hindi, Hinglish, Urdu, Bengali, Tamil, Telugu, Punjabi, Marathi, and other regional languages using Roman script.
- Detect intentionally misspelled or hidden abusive words using symbols, repeated letters, spaces, dots, stars, or leetspeak.
- Understand context and intent, not only exact keyword matches.
- Avoid flagging neutral educational, journalistic, or factual mentions unless used abusively.
- Understand context instead of exact words only.
- If abuse is about an person replace person name with 💩.
- Support all languages.

Rules:
- Return ONLY valid JSON.
- Do not explain.
- Do not add markdown.

Response format:
{
  "safe": true/false,
  "toxicity": 0-100,
  "detected": ["word1", "word2"],
  "categories": ["hate", "harassment", "sexual", "violence"],
  "cleaned_text": "sanitized sentence"
}

If text is safe:
- safe = true
- toxicity = low score
- detected = []
- categories = []

Replace offensive words in cleaned_text with ❤️,
                ',
            ],
            [
                'role' => 'user',
                'content' => $text,
            ],
        ], 3000);

        $article = $this->decodeArticlePayload((string) $json);
        return $article['cleaned_text'];

        if (! is_array($article) || empty($article['comment'])) {
            throw new RuntimeException('AI Credits did not return a valid article payload.');
        }


        return $article['comment'];
    }

    public function writeComment(){

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
                'content' => '
                You are a viral social media comment generator.

STRICT RULES:
- Generate ONLY ONE comment.
- Maximum 55 characters.
- Human-like.
- Random every time.
- Short social media style.
- Emojis allowed.
- No hashtags.
- No markdown.
- No quotes.
- No explanation.
- No JSON formatting mistakes.

Return ONLY valid JSON.

Format:
{"comment":"text here"}
                ',
            ],
            [
                'role' => 'user',
                'content' => '',
            ],
        ], 3000);

        $article = $this->decodeArticlePayload((string) $json);
        // return $article;

        if (! is_array($article) || empty($article['comment'])) {
            throw new RuntimeException('AI Credits did not return a valid article payload.');
        }


        return $article['comment'];

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
                'content' => 'You are a professional creator and blog writer who writes in a natural, conversational, human tone. Avoid generic AI boilerplate. Return valid JSON only.',
            ],
            [
                'role' => 'user',
                'content' => $this->articlePrompt($topic, $sources, $internalLinks, $brief),
            ],
        ], 5200);

        $article = $this->decodeArticlePayload((string) $json);
        // \Log::debug($article);
        if (! is_array($article) || empty($article['title']) || empty($article['html'])) {
            throw new RuntimeException('AI Credits did not return a valid article payload.');
        }

        return $article;
    }

    protected function chatText(array $messages, int $maxTokens = 1500): string
    {
        $model = config('services.aicredit.model');
        $baseUrl = rtrim((string) config('services.aicredit.base_url'), '/');

        $response = $this->http->post("{$baseUrl}/chat/completions", [
            'json' => [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => $maxTokens,
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
                "%d. [%s] %s\nURL: %s\nSnippet: %s\nFetched evidence: %s",
                $index + 1,
                $source['language'],
                $source['title'],
                $source['url'],
                $source['snippet'],
                Str::limit((string) ($source['evidence'] ?? ''), 900, '')
            );
        })->implode("\n\n");

        $links = $internalLinks === []
            ? config('app.url') . '/'
            : implode("\n", $internalLinks);
        $briefText = $brief === '' ? 'Focus on trending viral content, creator tactics, and broad social media strategies across all platforms.' : $brief;
        $usedTitles = $this->recentArticleTitleText();

        return <<<PROMPT
Write a viral-worthy, engaging investigative article for the topic: {$topic}

Context and research direction:
{$briefText}

Recent article titles to avoid repeating:
{$usedTitles}

Research sources gathered from English, Russian, and Chinese searches:
{$sourceText}

Internal links available:
{$links}

Requirements:
- Article between 900 and 1600 words. Aim for 1000 to 1350 words.
- The html body alone must contain at least 800 words after removing image placeholders and links.
- Choose one natural focus_keyphrase with 2 to 4 content words (can relate to any social media platform, not just one).
- Put the exact focus_keyphrase at the beginning of the title, then add a compelling specific angle after a colon.
- Title should be catchy, intriguing, and shareable - not generic.
- Never reuse the same title template or patterns from recent articles.
- Use practical, engaging language. Be conversational, sometimes funny, but always informative.
- Write like a human creator who has taken notes from forums, interviews, and on-the-ground experiments. Avoid phrases that sound like AI text such as "In this article", "This blog covers", "As an AI", or repetitive listicle templates.
- Use concrete human phrases like "I saw", "creators are saying", "what I keep seeing", "real people are doing", "on the ground", and "here’s the thing" where it fits naturally.
- Put the exact focus_keyphrase in the slug.
- Put the exact focus_keyphrase in the first paragraph naturally.
- Put the exact focus_keyphrase in the meta_description.
- Keep the SEO title under 58 characters and meta_description under 150 characters.
- Use the exact focus_keyphrase 3 to 6 times in the article body, naturally distributed.
- Include the focus_keyphrase or a close synonym in at least one h2 or h3 subheading.
- Content must be engaging, witty, and avoid boring generic patterns. Use humor, quick analogies, real creator perspectives, and playful language where appropriate.
- Treat the reader like an experienced creator who is tired of bland marketing copy. Make it feel sharp, snappy, and interesting while still being useful.
- Focus on viral trends, creator pain points, unusual tactics, platform quirks, and surprising discoveries across all social media platforms (TikTok, Instagram, YouTube, Twitter, Threads, Bluesky, etc.).
- Reference the website tools naturally in the article as helpful creator resources or practical follow-up actions.
- Do not write generic beginner content. Include insider knowledge, field notes, or real creator experiences.
- If the brief asks for old tools, websites, or services, cover them as historical research and risk analysis only. Do not provide working abuse instructions.
- Use the brief to decide content angle, but only cite details supported by research sources.
- If the topic involves dark web, grey web, old services, leaked tools, unofficial tricks, Russian forums, or hidden methods, write it as informative public-interest research, history, safety checks, and risk analysis.
- Do not provide working abuse steps, credential collection, platform bypasses, fake engagement methods, or platform manipulation instructions.
- Use different article structures each time to keep content fresh: myth-vs-reality, source comparison, creator field notes, insider breakdown, trend analysis, teardown, warning signs, or practical checklist.
- Cite at least one provided source or fetched evidence point in every major section.
- Include clear HTML article body using h2/h3/p/ul/ol/table elements (no H1).
- Include at least 4 outbound source links from provided sources. All must be useful citations from informational, forum, archive, documentation, or research websites.
- Include at least 2 internal links from available internal links naturally within the text or in an Explore More section.
- Add exactly 2 image placeholders as {{IN_POST_IMAGE_1}} and {{IN_POST_IMAGE_2}} in natural positions within the body.
- Write with concrete observations, source comparisons, red flags, verification steps, and real-world context.
- Vary sentence openings. Avoid repetitive sentence structures.
- Make content entertaining while staying factual and helpful.

Image generation rules:
- Never add captions, labels, titles, watermarks, UI text, readable signs, or embedded typography inside generated images.
- Feature and in-post images must be text-free visuals only.
- Use clean vector-style illustrations, flat design, modern clipart, or cinematic concept art.
- Avoid screenshots with readable text unless specifically required.
- Include subtle background logos, app icons, platform symbols, or brand-like visual motifs when relevant. Keep them small, secondary, and non-textual.
- Image prompts should describe composition, lighting, objects, colors, and style in detail.
- Every image prompt must explicitly include: "no text, no letters, no numbers, no captions, no watermark".
- In-post images should look like professional editorial illustrations, not generic stock photos.

Return valid JSON ONLY with keys:
- focus_keyphrase
- title
- slug
- meta_description
- excerpt
- html
- tags
- feature_image_prompt
- in_post_image_prompts

Do NOT include explanations, markdown, or any text outside the JSON object.

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
        // Keep full title up to 160 chars naturally, trimming only at a word boundary.
        $article['title'] = $this->limitTitleWithoutCutting($title, 160);
        $article['seo_title'] = $this->shortenSeoTitle($title, $keyphrase);

        $slugKeyphrase = Str::slug($keyphrase);
        $slug = Str::slug((string) ($article['slug'] ?? $title));
        if (! str_contains($slug, $slugKeyphrase)) {
            $slug = trim($slugKeyphrase . '-' . $slug, '-');
        }
        $article['slug'] = Str::limit($slug, 80, '');

        $meta = trim((string) ($article['meta_description'] ?? $article['excerpt'] ?? ''));
        if ($meta === '' || stripos($meta, $keyphrase) === false) {
            $meta = $keyphrase . ': ' . ltrim($meta ?: 'Viral social media trends, creator tips, and practical techniques for all platforms.', ":- \t\n\r\0\x0B");
        }
        $article['meta_description'] = $this->shortenMetaDescription($meta, $keyphrase);

        $html = (string) ($article['html'] ?? '');
        $html = $this->ensureKeyphraseInFirstParagraph($html, $keyphrase);
        $html = $this->ensureKeyphraseInSubheading($html, $keyphrase);
        $html = $this->ensureKeyphraseDensity($html, $keyphrase, 3);
        $html = $this->limitKeyphraseDensity($html, $keyphrase, 6);
        $html = $this->ensureOutboundLinks($html, $sources);
        $html = $this->ensureInPostImages($html, $keyphrase, $topic);
        $html = $this->ensureMinimumWordCount($html, $keyphrase, $topic, $sources, 800);
        $html = $this->varyConsecutiveSentenceStarts($html);
        $article['html'] = $html;

        $article['feature_image_prompt'] = $this->enhanceImagePrompt(
            (string) ($article['feature_image_prompt'] ?? ''),
            $topic,
            $title,
            'feature'
        );

        $imagePrompts = $article['in_post_image_prompts'] ?? [];
        if (! is_array($imagePrompts)) {
            $imagePrompts = [];
        }

        while (count($imagePrompts) < 2) {
            $imagePrompts[] = 'Professional supporting illustration for ' . $title;
        }

        $article['in_post_image_prompts'] = array_values(array_map(
            fn ($prompt) => $this->enhanceImagePrompt((string) $prompt, $topic, $title, 'in-post'),
            array_slice($imagePrompts, 0, 2)
        ));

        $article['feature_image_alt'] = $article['feature_image_alt'] ?? $keyphrase . ' guide';
        $article['in_post_image_alts'] = $article['in_post_image_alts'] ?? [
            $keyphrase . ' tips and techniques',
            $keyphrase . ' creator resources',
        ];

        return $article;
    }

    protected function ensureUniqueArticleIdentity(array $article, string $topic, string $brief = ''): array
    {
        $existing = $this->recentArticleTitles(120);
        $keyphrase = $this->shortFocusKeyphrase((string) ($article['focus_keyphrase'] ?? ''), $topic);
        $title = trim((string) ($article['title'] ?? $topic));

        if ($this->titleLooksRepeated($title, $existing)) {
            $title = $this->uniqueTitleVariant($keyphrase, $topic, $brief, $existing);
        }

        $article['focus_keyphrase'] = $keyphrase;
        $article['title'] = $title;
        $article['seo_title'] = $title;
        $article['slug'] = Str::slug($title) ?: Str::slug($topic);

        return $article;
    }

    protected function uniqueTitleVariant(string $keyphrase, string $topic, string $brief, array $existing): string
    {
        $angles = [
            'Hidden Source Notes',
            'Obscure Forum Trail',
            'Public Archive Clues',
            'Safety Research Map',
            'Old Tool Warnings',
            'Regional Forum Notes',
            'Underground Claims Checked',
            'Grey Web Risk Review',
        ];

        $seed = abs(crc32($topic . '|' . $brief . '|' . now()->toDateString()));
        for ($i = 0; $i < count($angles); $i++) {
            $angle = $angles[($seed + $i) % count($angles)];
            $candidate = $this->shortenSeoTitle($keyphrase . ': ' . $angle, $keyphrase);
            if (! $this->titleLooksRepeated($candidate, $existing)) {
                return $candidate;
            }
        }

        $candidate = $keyphrase . ': ' . now()->format('M j') . ' Research Notes';

        return $this->shortenSeoTitle($candidate, $keyphrase);
    }

    protected function titleLooksRepeated(string $title, array $existing): bool
    {
        $fingerprint = $this->titleFingerprint($title);
        if ($fingerprint === '') {
            return true;
        }

        foreach ($existing as $item) {
            $other = $this->titleFingerprint((string) $item);
            if ($other === '') {
                continue;
            }

            if ($fingerprint === $other) {
                return true;
            }

            similar_text($fingerprint, $other, $percent);
            if ($percent >= 78) {
                return true;
            }
        }

        return false;
    }

    protected function titleFingerprint(string $value): string
    {
        $value = Str::lower(strip_tags($value));
        $value = preg_replace('/[^\pL\pN\s]+/u', ' ', $value) ?? '';
        $words = preg_split('/\s+/', trim($value), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $stop = ['a', 'an', 'and', 'creator', 'creators', 'for', 'from', 'guide', 'how', 'in', 'maximise', 'maximize', 'maximizing', 'of', 'on', 'or', 'the', 'to', 'with', 'your'];
        $words = array_map(function (string $word): string {
            return preg_replace('/(ing|ed|es|s)$/', '', $word) ?: $word;
        }, array_filter($words, fn (string $word): bool => ! in_array($word, $stop, true)));
        sort($words);

        return implode(' ', array_unique($words));
    }

    protected function recentArticleTitleText(): string
    {
        $titles = array_slice($this->recentArticleTitles(40), 0, 40);
        if ($titles === []) {
            return 'No recent titles available.';
        }

        return implode("\n", array_map(fn (string $title): string => '- ' . $title, $titles));
    }

    protected function recentArticleTitles(int $limit = 80): array
    {
        try {
            return app(GoogleSearchConsoleKeywordResearch::class)->recentUsedContent($limit);
        } catch (\Throwable) {
            return [];
        }
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

    protected function limitTitleWithoutCutting(string $title, int $maxLength): string
    {
        $title = trim(preg_replace('/\s+/', ' ', strip_tags($title)) ?? $title);
        if (mb_strlen($title) <= $maxLength) {
            return $title;
        }

        $truncated = mb_substr($title, 0, $maxLength);
        $short = preg_replace('/\s+[^\s]*$/u', '', $truncated);
        return trim($short ?: $truncated);
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

    protected function ensureMinimumWordCount(string $html, string $keyphrase, string $topic, array $sources, int $minimum): string
    {
        if ($this->articleWordCount($html) >= $minimum) {
            return $html;
        }

        $sourceHosts = collect($sources)
            ->pluck('host')
            ->filter()
            ->unique()
            ->take(3)
            ->implode(', ');
        $sourceNote = $sourceHosts !== ''
            ? ' The final check should compare claims against sources such as ' . $sourceHosts . ' before publishing.'
            : '';

        $fallbackSections = [
            '<h2>' . e($keyphrase) . ' Practical Checklist</h2>'
                . '<p>Before using this advice, define the exact account, page, campaign, or release detail you want to improve. Then record the current baseline, the expected result, and the risk limit. This keeps the tutorial useful instead of turning it into a loose collection of tips.</p>',
            '<p>Review the strongest sources first, then separate confirmed facts from assumptions. If a tactic depends on an old tool, an unofficial website, or a platform loophole, treat it as historical context and choose the safer official route. That approach protects the reader while still giving them a clear research path.</p>',
            '<h3>Safe Testing Workflow</h3>'
                . '<ol><li>Start with one small change and wait long enough to measure it.</li><li>Check whether the result improves quality signals, not only raw numbers.</li><li>Keep screenshots, dates, and source links for later review.</li><li>Stop any step that asks for passwords, private tokens, payment tricks, or unofficial downloads.</li></ol>',
            '<p>A good article should also explain what not to do. Avoid copied templates, exaggerated promises, fake engagement, and instructions that bypass a platform rule. Safer work is slower, but it gives creators and readers a result they can repeat without damaging accounts or trust.' . e($sourceNote) . '</p>',
            '<h3>Final Review</h3>'
                . '<p>Use this ' . e($topic) . ' guide as a decision checklist: verify the source, test the smallest useful action, measure the outcome, and keep the recommendation honest. If the topic changes quickly, update the examples before sharing the article again.</p>',
        ];

        foreach ($fallbackSections as $section) {
            $html .= $section;
            if ($this->articleWordCount($html) >= $minimum) {
                return $html;
            }
        }

        $fillerSentences = [
            'Use this section to reinforce the recommended process and keep the research focused on safe, measurable tactics.',
            'A strong conclusion reminds the reader how to prioritize the best sources and avoid guesswork.',
            'Practical details are more useful than vague claims, so keep each sentence grounded in workflow, checks, and actual decision points.',
            'The article should remain readable while the guidance stays precise, helpful, and aligned with the specified keyword.',
        ];

        while ($this->articleWordCount($html) < $minimum) {
            $html .= '<p>' . e($keyphrase) . ' is still the core focus, and this paragraph keeps the article complete while preserving the tutorial workflow.</p>';
            foreach ($fillerSentences as $sentence) {
                if ($this->articleWordCount($html) >= $minimum) {
                    break 2;
                }
                $html .= '<p>' . e($sentence) . '</p>';
            }
        }

        return $html;
    }

    protected function articleWordCount(string $html): int
    {
        $text = preg_replace('/\{\{IN_POST_IMAGE_\d+\}\}/', ' ', $html) ?? $html;
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        preg_match_all('/[\pL\pN]+(?:-[\pL\pN]+)*/u', $text, $matches);

        return count($matches[0] ?? []);
    }

    protected function enhanceImagePrompt(string $prompt, string $topic, string $title, string $kind): string
    {
        $prompt = trim(preg_replace('/\s+/', ' ', strip_tags($prompt)) ?? '');
        if ($prompt === '') {
            $prompt = $kind === 'feature'
                ? 'Professional editorial illustration for ' . $title
                : 'Detailed supporting editorial illustration for ' . $topic;
        }

        $required = [
            'rich non-text background related to ' . $topic,
            'subtle small background logos, app icons, platform symbols, and brand-like motifs related to the title only where relevant',
            'minor visual details, layered depth, polished lighting, professional blog artwork',
            'no text, no letters, no numbers, no captions, no watermark',
        ];

        foreach ($required as $phrase) {
            if (stripos($prompt, $phrase) === false) {
                $prompt .= ', ' . $phrase;
            }
        }

        return Str::limit($prompt, 900, '');
    }

    protected function ensureInPostImages(string $html, string $keyphrase, string $topic): string
    {
        $imageCount = preg_match_all('/\{\{IN_POST_IMAGE_\d+\}\}/', $html) ?: 0;

        if ($imageCount < 2) {
            $inserted = 0;
            $sections = preg_split('/(<h2\b[^>]*>.*?<\/h2>)/is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

            if (count($sections) >= 5) {
                $insertPos = strlen($sections[0]) + strlen($sections[1]) + strlen($sections[2]) + 80;
                $insertPos = min($insertPos, strlen($html));

                if (preg_match('/<\/p>/i', $html, $matches, PREG_OFFSET_CAPTURE, $insertPos)) {
                    $insertPos = $matches[0][1] + 4;
                    $html = substr_replace($html, '<figure>{{IN_POST_IMAGE_1}}</figure>', $insertPos, 0);
                    $inserted++;
                }
            }

            if (preg_match_all('/<\/p>/i', $html, $matches, PREG_OFFSET_CAPTURE)) {
                $paragraphCount = count($matches[0]);
                if ($paragraphCount > 2) {
                    $index = min((int) floor($paragraphCount * 2 / 3), $paragraphCount - 1);
                    $insertPos = $matches[0][$index][1] + 4;
                    $html = substr_replace($html, '<figure>{{IN_POST_IMAGE_' . ($inserted + 1) . '}}</figure>', $insertPos, 0);
                    $inserted++;
                }
            }

            while ($inserted + $imageCount < 2) {
                $html .= '<figure>{{IN_POST_IMAGE_' . ($inserted + $imageCount + 1) . '}}</figure>';
                $inserted++;
            }
        }

        return $html;
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

        if ($outboundCount >= 4) {
            // Still ensure internal links even if we have enough outbound
            return $this->ensureInternalLinks($html);
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
            if (count($links) >= 4 - $outboundCount) {
                break;
            }
        }

        foreach ($fallbackLinks as $url => $link) {
            if (count($links) >= 4 - $outboundCount) {
                break;
            }

            $links[$url] = $link;
        }

        if ($links !== []) {
            $html .= '<h2>Research Sources</h2><ul>' . implode('', $links) . '</ul>';
        }
        
        return $this->ensureInternalLinks($html);
    }

    protected function ensureInternalLinks(string $html): string
    {
        $internalLinks = array_values(array_filter(array_map(
            'trim',
            explode('|', (string) config('services.daily_blog.internal_links'))
        )));

        if ($internalLinks === []) {
            return $html;
        }

        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $internalCount = 0;

        if (preg_match_all('/<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>/i', $html, $matches)) {
            foreach ($matches[1] as $href) {
                $host = parse_url($href, PHP_URL_HOST);
                if ($host === $appHost || strpos($href, config('app.url')) === 0) {
                    $internalCount++;
                }
            }
        }

        if ($internalCount >= 2) {
            return $html;
        }

        $links = [];
        foreach ($internalLinks as $url) {
            if (! filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }

            $label = trim(str_replace(config('app.url'), '', $url), '/');
            if ($label === '' || $label === 'blog/') {
                $label = 'Main Tools & Resources';
            } else {
                $label = ucwords(str_replace(['/', '-'], ' ', $label));
            }

            $link = '<li><a href="' . e($url) . '">' . e($label) . '</a></li>';
            $links[] = $link;
            if (count($links) >= 2 - $internalCount) {
                break;
            }
        }

        if ($links !== []) {
            $html .= '<h2>Explore More</h2><ul>' . implode('', $links) . '</ul>';
        }

        return $html;
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

    protected function publishWithLaravelBlogScript(string $blogPath, array $article, string $topic, array $sources, bool $force): array
    {
        $featureImage = $this->createImageFile(
            $this->enhanceImagePrompt(
                (string) ($article['feature_image_prompt'] ?? ''),
                $topic,
                (string) ($article['title'] ?? $topic),
                'feature'
            ),
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

        $payloadPath = $this->writePublisherPayload($blogPath, $article, $topic, $sources, $featureImage, $inPostImages, $force);
        $script = base_path('scripts/laravel_publish_daily_blog.php');

        $process = new Process([PHP_BINARY, $script, $payloadPath], base_path());
        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException(trim($process->getErrorOutput() ?: $process->getOutput()));
        }

        $result = json_decode(trim($process->getOutput()), true);
        if (! is_array($result)) {
            throw new RuntimeException('Laravel blog publisher did not return JSON: ' . $process->getOutput());
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
        string $blogPath,
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
            'blog_path' => $blogPath,
            'site_url' => config('app.url'),
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
