<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\Process;

class GoogleSearchConsoleKeywordResearch
{
    protected const SCOPE = 'https://www.googleapis.com/auth/webmasters';

    protected Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'connect_timeout' => 20,
            'timeout' => 90,
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => 'Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion',
            ],
        ]);
    }

    public function isReady(): bool
    {
        return (bool) config('services.daily_blog.gsc_enabled')
            && is_file($this->tokenPath());
    }


    public function authorizationUrl(string $redirectUri, string $state): string
    {
        if ($this->clientId() === '') {
            throw new RuntimeException('GOOGLE_CLIENT_ID is missing.');
        }

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id' => $this->clientId(),
            'redirect_uri' => $redirectUri,
            'response_type' => 'token',
            'scope' => self::SCOPE,
            'state' => $state,
        ]);
    }

    public function storeAccessToken(string $accessToken, ?int $expiresIn = null): array
    {
        $accessToken = trim($accessToken);
        if ($accessToken === '') {
            throw new RuntimeException('Google access token is missing.');
        }

        $token = [
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => $expiresIn ?: 3600,
            'created_at' => time(),
        ];

        $this->storeToken($token);

        return $token;
    }

    public function exchangeAuthorizationCode(string $code, string $redirectUri): array
    {
        if ($this->clientId() === '') {
            throw new RuntimeException('GOOGLE_CLIENT_ID is missing.');
        }

        $secret = $this->clientSecret();
        if (empty($secret)) {
            throw new RuntimeException('GOOGLE_CLIENT_SECRET is missing.');
        }

        $data = [
            'http_errors' => false,
            'form_params' => [
                'client_id' => $this->clientId(),
                'client_secret' => $secret,
                'code' => $code,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
            ],
        ];

        \Log::debug('google_oauth_token_request', [
            'client_id' => $this->clientId(),
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ]);

        $response = $this->http->post('https://oauth2.googleapis.com/token', $data);

        \Log::debug([
            'google_oauth_token_response_status' => $response->getStatusCode(),
            'google_oauth_token_response_body' => (string) $response->getBody(),
        ]);

        $payload = json_decode((string) $response->getBody(), true);
        if (! is_array($payload)) {
            throw new RuntimeException('Google token response was not valid JSON.');
        }

        if ($response->getStatusCode() !== 200 || empty($payload['access_token'])) {
            $error = (string) ($payload['error'] ?? 'unknown_error');
            $description = (string) ($payload['error_description'] ?? 'No error description returned.');

            throw new RuntimeException(sprintf(
                'Google OAuth failed [%s, HTTP %d]: %s',
                $error,
                $response->getStatusCode(),
                $description
            ));
        }

        $payload['created_at'] = time();
        $this->storeToken($payload);

        return $payload;
    }

    public function beginDeviceAuthorization(): array
    {
        if ($this->clientId() === '') {
            throw new RuntimeException('GOOGLE_CLIENT_ID is missing.');
        }

        $response = $this->http->post('https://oauth2.googleapis.com/device/code', [
            'form_params' => [
                'client_id' => $this->clientId(),
                'scope' => self::SCOPE,
            ],
        ]);

        $payload = json_decode((string) $response->getBody(), true);
        if (! is_array($payload) || empty($payload['device_code'])) {
            throw new RuntimeException('Google did not return a device authorization code.');
        }

        return $payload;
    }

    public function pollDeviceToken(string $deviceCode): ?array
    {
        try {
            $response = $this->http->post('https://oauth2.googleapis.com/token', [
                'http_errors' => false,
                'form_params' => array_filter([
                    'client_id' => $this->clientId(),
                    'client_secret' => $this->clientSecret(),
                    'device_code' => $deviceCode,
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:device_code',
                ]),
            ]);
        } catch (\Throwable $e) {
            throw new RuntimeException('Google token request failed: ' . $e->getMessage(), previous: $e);
        }

        $payload = json_decode((string) $response->getBody(), true);
        if (! is_array($payload)) {
            throw new RuntimeException('Google token response was not valid JSON.');
        }

        if ($response->getStatusCode() === 200 && ! empty($payload['access_token'])) {
            $payload['created_at'] = time();
            $this->storeToken($payload);

            return $payload;
        }

        $error = (string) ($payload['error'] ?? 'unknown_error');
        if (in_array($error, ['authorization_pending', 'slow_down'], true)) {
            return null;
        }

        throw new RuntimeException('Google OAuth failed: ' . $error);
    }


    public function sites(): array
    {
        if (! $this->isReady()) {
            throw new RuntimeException('Google Search Console is not connected. Run php artisan gsc:connect first.');
        }

        $response = $this->http->get('https://www.googleapis.com/webmasters/v3/sites', [
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken(),
                'Content-Type' => 'application/json',
            ],
        ]);

        $payload = $this->decodeSearchConsoleResponse($response->getStatusCode(), (string) $response->getBody(), 'sites list');
        $sites = (array) ($payload['siteEntry'] ?? []);

        return array_values(array_map(fn (array $site): array => [
            'site_url' => (string) ($site['siteUrl'] ?? ''),
            'permission_level' => (string) ($site['permissionLevel'] ?? ''),
        ], $sites));
    }

    public function accessibleSiteUrl(): string
    {
        $configured = $this->siteUrl();
        foreach ($this->sites() as $site) {
            if ($this->sameSiteProperty($configured, (string) ($site['site_url'] ?? ''))) {
                return (string) $site['site_url'];
            }
        }

        foreach ($this->sites() as $site) {
            $siteUrl = (string) ($site['site_url'] ?? '');
            if ($siteUrl !== '') {
                return $siteUrl;
            }
        }

        return $configured;
    }

    public function keywordOpportunities(int $limit = 10): array
    {
        if (! $this->isReady()) {
            return [];
        }

        $accessToken = $this->accessToken();
        $siteUrl = $this->accessibleSiteUrl();
        $end = now()->subDays((int) config('services.daily_blog.gsc_data_lag_days', 3));
        $start = $end->copy()->subDays((int) config('services.daily_blog.gsc_lookback_days', 90));

        $response = $this->http->post(
            'https://www.googleapis.com/webmasters/v3/sites/' . rawurlencode($siteUrl) . '/searchAnalytics/query',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'http_errors' => false,
                'json' => [
                    'startDate' => $start->toDateString(),
                    'endDate' => $end->toDateString(),
                    'dimensions' => ['query'],
                    'rowLimit' => 250,
                ],
            ]
        );

        $payload = $this->decodeSearchConsoleResponse($response->getStatusCode(), (string) $response->getBody(), $siteUrl);
        $rows = (array) ($payload['rows'] ?? []);
        $used = $this->usedPhrases();
        $minImpressions = (int) config('services.daily_blog.gsc_min_impressions', 20);
        $maxPosition = (float) config('services.daily_blog.gsc_max_position', 35);

        $countryRows = $this->queryCountryRows($start->toDateString(), $end->toDateString(), 500);
        $countryByQuery = [];
        foreach ($countryRows as $countryRow) {
            $countryQuery = $this->cleanQuery((string) ($countryRow['query'] ?? ''));
            if ($countryQuery !== '' && ! isset($countryByQuery[$countryQuery])) {
                $countryByQuery[$countryQuery] = $countryRow;
            }
        }

        $keywords = [];
        foreach ($rows as $row) {
            $query = $this->cleanQuery((string) Arr::get($row, 'keys.0', ''));
            if ($query === '' || $this->isRepeated($query, $used)) {
                continue;
            }

            $impressions = (float) ($row['impressions'] ?? 0);
            $clicks = (float) ($row['clicks'] ?? 0);
            $ctr = (float) ($row['ctr'] ?? 0);
            $position = (float) ($row['position'] ?? 99);

            if ($impressions < $minImpressions || $position > $maxPosition) {
                continue;
            }

            $score = ($impressions * max(0.15, 1 - $ctr)) / max(1, abs($position - 9));
            if ($position >= 8 && $position <= 25) {
                $score *= 1.4;
            }
            if ($clicks <= 1) {
                $score *= 1.15;
            }

            $keywords[] = [
                'query' => $query,
                'clicks' => $clicks,
                'impressions' => $impressions,
                'ctr' => $ctr,
                'position' => $position,
                'score' => round($score, 3),
                'country' => (string) ($countryByQuery[$query]['country'] ?? ''),
                'country_label' => (string) ($countryByQuery[$query]['country_label'] ?? ''),
                'date_range' => $start->toDateString() . ' to ' . $end->toDateString(),
            ];
        }

        usort($keywords, fn (array $a, array $b): int => $b['score'] <=> $a['score']);

        return array_slice($keywords, 0, $limit);
    }


    public function generateReport(int $rowLimit = 100): array
    {
        if (! $this->isReady()) {
            throw new RuntimeException('Google Search Console is not connected. Run php artisan gsc:connect first.');
        }

        $rowLimit = max(10, min($rowLimit, 500));
        $end = now()->subDays((int) config('services.daily_blog.gsc_data_lag_days', 3));
        $start = $end->copy()->subDays((int) config('services.daily_blog.gsc_lookback_days', 90));

        $totals = $this->searchAnalyticsRows([], 1, $start->toDateString(), $end->toDateString())[0] ?? [];
        $queries = $this->searchAnalyticsRows(['query'], $rowLimit, $start->toDateString(), $end->toDateString());
        $pages = $this->searchAnalyticsRows(['page'], $rowLimit, $start->toDateString(), $end->toDateString());
        $queryPages = $this->searchAnalyticsRows(['query', 'page'], $rowLimit, $start->toDateString(), $end->toDateString());
        $countries = $this->searchAnalyticsRows(['country'], 50, $start->toDateString(), $end->toDateString());
        $devices = $this->searchAnalyticsRows(['device'], 10, $start->toDateString(), $end->toDateString());
        $dates = $this->searchAnalyticsRows(['date'], 120, $start->toDateString(), $end->toDateString());
        $recentEnd = $end->copy();
        $recentStart = $recentEnd->copy()->subDays((int) config('services.daily_blog.gsc_recent_days', 14));
        $recentKeywordCountries = $this->queryCountryRows($recentStart->toDateString(), $recentEnd->toDateString(), $rowLimit);
        $articlePerformance = $this->articlePerformance(
            $pages,
            $queryPages,
            $this->searchAnalyticsRows(['page', 'country'], $rowLimit, $start->toDateString(), $end->toDateString()),
            $rowLimit
        );

        $countrySummaries = array_map(function (array $row): array {
            $row['country_label'] = $this->countryLabel((string) ($row['country'] ?? Arr::get($row, 'keys.0', '')));

            return $row;
        }, $this->formatDimensionRows($countries, ['country']));

        return [
            'generated_at' => now()->toDateTimeString(),
            'site_url' => $this->accessibleSiteUrl(),
            'date_range' => [
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
            ],
            'totals' => $this->metricsOnly($totals),
            'opportunities' => $this->keywordOpportunities(25),
            'top_queries' => $this->formatDimensionRows($queries, ['query']),
            'top_pages' => $this->formatDimensionRows($pages, ['page']),
            'top_query_pages' => $this->formatDimensionRows($queryPages, ['query', 'page']),
            'countries' => $countrySummaries,
            'recent_keyword_countries' => $recentKeywordCountries,
            'article_performance' => $articlePerformance,
            'devices' => $this->formatDimensionRows($devices, ['device']),
            'date_trend' => $this->formatDimensionRows($dates, ['date']),
        ];
    }

    public function saveReport(?array $report = null): string
    {
        $report ??= $this->generateReport();
        $path = $this->latestReportPath();
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($path, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        @chmod($path, 0600);

        $archive = $dir . '/gsc-report-' . now()->format('Ymd-His') . '.json';
        file_put_contents($archive, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        @chmod($archive, 0600);

        return $path;
    }

    public function latestReport(?int $maxAgeHours = null): ?array
    {
        $path = $this->latestReportPath();
        if (! is_file($path)) {
            return null;
        }

        if ($maxAgeHours !== null && filemtime($path) < now()->subHours($maxAgeHours)->getTimestamp()) {
            return null;
        }

        $report = json_decode((string) file_get_contents($path), true);

        return is_array($report) ? $report : null;
    }

    public function latestReportBrief(int $maxItems = 8): string
    {
        $report = $this->latestReport();
        if (! $report) {
            return '';
        }

        $maxItems = max(3, min($maxItems, 15));
        $totals = $report['totals'] ?? [];
        $range = $report['date_range'] ?? [];

        $lines = [
            sprintf(
                'Saved Google Search Console report for %s to %s: %.0f impressions, %.0f clicks, %.2f%% CTR, average position %.1f.',
                (string) ($range['start'] ?? 'unknown'),
                (string) ($range['end'] ?? 'unknown'),
                (float) ($totals['impressions'] ?? 0),
                (float) ($totals['clicks'] ?? 0),
                ((float) ($totals['ctr'] ?? 0)) * 100,
                (float) ($totals['position'] ?? 0)
            ),
            'Use this report to select a niche angle with existing impressions, weak CTR, positions near page one, and a relevant landing page.',
            'Keyword opportunities: ' . $this->briefRows((array) ($report['opportunities'] ?? []), ['query'], $maxItems),
            'Top query/page pairs: ' . $this->briefRows((array) ($report['top_query_pages'] ?? []), ['query', 'page'], $maxItems),
            'Top pages: ' . $this->briefRows((array) ($report['top_pages'] ?? []), ['page'], min(5, $maxItems)),
            'Countries: ' . $this->briefRows((array) ($report['countries'] ?? []), ['country_label'], min(5, $maxItems)),
            'Recent keyword countries: ' . $this->briefRows((array) ($report['recent_keyword_countries'] ?? []), ['query', 'country_label'], $maxItems),
            'Article performance: ' . $this->briefRows((array) ($report['article_performance'] ?? []), ['title'], min(6, $maxItems)),
            'Bounce-rate note: Search Console does not provide bounce rate. Use local article views plus Search Console CTR, position, country, and query data here; connect GA4 later for true bounce or engagement-rate diagnosis.',
            'Devices: ' . $this->briefRows((array) ($report['devices'] ?? []), ['device'], min(5, $maxItems)),
        ];

        return implode(' ', array_filter($lines));
    }

    public function chooseTopic(): ?array
    {
        try {
            $keyword = $this->keywordOpportunities(1)[0] ?? null;
        } catch (\Throwable) {
            $keyword = null;
        }

        if (! $keyword) {
            $report = $this->latestReport();
            $keyword = ((array) ($report['opportunities'] ?? []))[0]
                ?? ((array) ($report['top_queries'] ?? []))[0]
                ?? null;
        }

        if (! is_array($keyword) || empty($keyword['query'])) {
            return null;
        }

        $query = $keyword['query'];
        $countryLabel = (string) ($keyword['country_label'] ?? $keyword['country'] ?? '');
        $countryText = $countryLabel !== '' ? ' Country angle: ' . $countryLabel . '.' : '';

        return [
            'topic' => $this->topicFromKeyword($query, $countryLabel),
            'keyword' => $query,
            'brief' => sprintf(
                'Reader search intent: "%s".%s Build an investigative, obscure-source article using public web archives, forums, and international-language references where sources support it. Do not mention analytics, Search Console, CTR, impressions, clicks, rankings, or keyword performance in the article.',
                $query,
                $countryText
            ),
            'metrics' => $keyword,
        ];
    }

    public function markUsed(string $keyword, string $topic, ?string $title = null, array $metrics = []): void
    {
        $path = storage_path('app/daily-blog/used-keywords.json');
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $items = is_file($path) ? json_decode((string) file_get_contents($path), true) : [];
        $items = is_array($items) ? $items : [];
        array_unshift($items, [
            'keyword' => $keyword,
            'topic' => $topic,
            'title' => $title,
            'metrics' => $metrics,
            'used_at' => now()->toDateTimeString(),
        ]);

        file_put_contents($path, json_encode(array_slice($items, 0, 500), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function recentUsedContent(int $limit = 80): array
    {
        $items = array_merge($this->localUsedItems(), $this->publishedBlogTitles());
        $items = array_values(array_filter(array_unique(array_map('trim', array_map('strval', $items)))));

        return array_slice($items, 0, max(1, $limit));
    }

    protected function accessToken(): string
    {
        $token = $this->storedToken();
        $expiresAt = (int) ($token['created_at'] ?? 0) + (int) ($token['expires_in'] ?? 0) - 120;

        if (! empty($token['access_token']) && time() < $expiresAt) {
            return (string) $token['access_token'];
        }

        $refreshToken = (string) ($token['refresh_token'] ?? '');
        if ($refreshToken === '') {
            throw new RuntimeException('Google access token expired. Run php artisan gsc:connect again and paste the new redirect URL containing access_token.');
        }

        $response = $this->http->post('https://oauth2.googleapis.com/token', [
            'form_params' => array_filter([
                'client_id' => $this->clientId(),
                'client_secret' => $this->clientSecret() ?: null,
                'refresh_token' => $refreshToken,
                'grant_type' => 'refresh_token',
            ]),
        ]);

        $fresh = json_decode((string) $response->getBody(), true);
        if (! is_array($fresh) || empty($fresh['access_token'])) {
            throw new RuntimeException('Unable to refresh Google Search Console token.');
        }

        $fresh['refresh_token'] = $refreshToken;
        $fresh['created_at'] = time();
        $this->storeToken($fresh);

        return (string) $fresh['access_token'];
    }

    protected function storedToken(): array
    {
        $path = $this->tokenPath();
        if (! is_file($path)) {
            throw new RuntimeException('Google Search Console token is missing. Run php artisan gsc:connect.');
        }

        $token = json_decode((string) file_get_contents($path), true);
        if (! is_array($token)) {
            throw new RuntimeException('Google Search Console token file is invalid.');
        }

        return $token;
    }

    protected function storeToken(array $token): void
    {
        $path = $this->tokenPath();
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($path, json_encode($token, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        @chmod($path, 0600);
    }

    protected function usedPhrases(): array
    {
        $phrases = [];
        foreach ($this->localUsedItems() as $value) {
            $phrases[] = $this->fingerprint($value);
        }

        foreach ($this->publishedBlogTitles() as $title) {
            $phrases[] = $this->fingerprint($title);
        }

        return array_values(array_filter(array_unique($phrases)));
    }

    protected function localUsedItems(): array
    {
        $items = [];
        $usedPath = storage_path('app/daily-blog/used-keywords.json');
        $used = is_file($usedPath) ? json_decode((string) file_get_contents($usedPath), true) : [];
        foreach (is_array($used) ? $used : [] as $entry) {
            $items[] = (string) ($entry['keyword'] ?? '');
            $items[] = (string) ($entry['topic'] ?? '');
            $items[] = (string) ($entry['title'] ?? '');
        }

        foreach (glob(storage_path('app/daily-blog/payloads/*.json')) ?: [] as $payloadPath) {
            $payload = json_decode((string) file_get_contents($payloadPath), true);
            if (! is_array($payload)) {
                continue;
            }
            $items[] = (string) ($payload['topic'] ?? '');
            $items[] = (string) Arr::get($payload, 'article.title', '');
            $items[] = (string) Arr::get($payload, 'article.focus_keyphrase', '');
        }

        return $items;
    }

    protected function publishedBlogTitles(): array
    {
        $blogPath = base_path(config('services.daily_blog.laravel_blog_path', '../public_html/blog'));
        $script = base_path('scripts/laravel_blog_titles.php');
        if (! is_file($script) || ! is_file($blogPath . DIRECTORY_SEPARATOR . 'artisan')) {
            return [];
        }

        $process = new Process([PHP_BINARY, $script, $blogPath, '250'], base_path());
        $process->setTimeout(60);
        $process->run();
        if (! $process->isSuccessful()) {
            return [];
        }

        $titles = json_decode(trim($process->getOutput()), true);

        return is_array($titles) ? array_map('strval', $titles) : [];
    }

    protected function queryCountryRows(string $startDate, string $endDate, int $rowLimit): array
    {
        $rows = $this->searchAnalyticsRows(['query', 'country'], $rowLimit, $startDate, $endDate);
        $formatted = $this->formatDimensionRows($rows, ['query', 'country']);

        $items = array_values(array_map(function (array $row): array {
            $row['query'] = $this->cleanQuery((string) ($row['query'] ?? ''));
            $row['country_label'] = $this->countryLabel((string) ($row['country'] ?? ''));

            return $row;
        }, array_filter($formatted, fn (array $row): bool => $this->cleanQuery((string) ($row['query'] ?? '')) !== '')));

        usort($items, fn (array $a, array $b): int => ((float) ($b['impressions'] ?? 0)) <=> ((float) ($a['impressions'] ?? 0)));

        return $items;
    }

    protected function articlePerformance(array $pageRows, array $queryPageRows, array $countryPageRows, int $limit): array
    {
        $posts = $this->publishedBlogPerformance($limit);
        if ($posts === []) {
            return [];
        }

        $pages = $this->formatDimensionRows($pageRows, ['page']);
        $queryPages = $this->formatDimensionRows($queryPageRows, ['query', 'page']);
        $countryPages = $this->formatDimensionRows($countryPageRows, ['page', 'country']);

        return array_values(array_map(function (array $post) use ($pages, $queryPages, $countryPages): array {
            $url = (string) ($post['url'] ?? '');
            $pageMetrics = $this->matchingPageMetrics($url, $pages);
            $topQueries = array_slice(array_values(array_filter($queryPages, fn (array $row): bool => $this->sameUrlPath($url, (string) ($row['page'] ?? '')))), 0, 5);
            $topCountries = array_slice(array_values(array_map(function (array $row): array {
                $row['country_label'] = $this->countryLabel((string) ($row['country'] ?? ''));

                return $row;
            }, array_filter($countryPages, fn (array $row): bool => $this->sameUrlPath($url, (string) ($row['page'] ?? ''))))), 0, 5);

            return array_merge($post, [
                'clicks' => (float) ($pageMetrics['clicks'] ?? 0),
                'impressions' => (float) ($pageMetrics['impressions'] ?? 0),
                'ctr' => (float) ($pageMetrics['ctr'] ?? 0),
                'position' => (float) ($pageMetrics['position'] ?? 0),
                'top_queries' => $topQueries,
                'top_countries' => $topCountries,
            ]);
        }, $posts));
    }

    protected function publishedBlogPerformance(int $limit): array
    {
        $blogPath = base_path(config('services.daily_blog.laravel_blog_path', '../public_html/blog'));
        $script = base_path('scripts/laravel_blog_performance.php');
        if (! is_file($script) || ! is_file($blogPath . DIRECTORY_SEPARATOR . 'artisan')) {
            return [];
        }

        $process = new Process([PHP_BINARY, $script, $blogPath, (string) max(1, min($limit, 500))], base_path());
        $process->setTimeout(60);
        $process->run();
        if (! $process->isSuccessful()) {
            return [];
        }

        $items = json_decode(trim($process->getOutput()), true);

        return is_array($items) ? $items : [];
    }

    protected function matchingPageMetrics(string $url, array $pages): array
    {
        foreach ($pages as $page) {
            if ($this->sameUrlPath($url, (string) ($page['page'] ?? ''))) {
                return $page;
            }
        }

        return [];
    }

    protected function sameUrlPath(string $a, string $b): bool
    {
        $pathA = trim((string) parse_url($a, PHP_URL_PATH), '/');
        $pathB = trim((string) parse_url($b, PHP_URL_PATH), '/');

        return $pathA !== '' && $pathA === $pathB;
    }

    protected function topicFromKeyword(string $query, string $countryLabel = ''): string
    {
        $headline = Str::headline($query);
        $angles = [
            'Hidden Source Notes',
            'Obscure Forum Trail',
            'Public Archive Clues',
            'Regional Forum Notes',
            'Creator Safety Workflow',
        ];
        $angle = $angles[abs(crc32($query . now()->toDateString())) % count($angles)];

        return trim($headline . ' ' . ($countryLabel !== '' ? $countryLabel . ' ' : '') . $angle);
    }

    protected function countryLabel(string $country): string
    {
        $code = Str::lower(trim($country));
        $names = [
            'usa' => 'United States',
            'ind' => 'India',
            'pak' => 'Pakistan',
            'bgd' => 'Bangladesh',
            'phl' => 'Philippines',
            'idn' => 'Indonesia',
            'gbr' => 'United Kingdom',
            'can' => 'Canada',
            'aus' => 'Australia',
        ];

        return $names[$code] ?? Str::upper($country);
    }

    protected function isRepeated(string $query, array $used): bool
    {
        $fingerprint = $this->fingerprint($query);
        if ($fingerprint === '') {
            return true;
        }

        foreach ($used as $existing) {
            if ($existing === '' || $fingerprint === $existing) {
                return true;
            }

            similar_text($fingerprint, $existing, $percent);
            if ($percent >= 82) {
                return true;
            }
        }

        return false;
    }

    protected function cleanQuery(string $query): string
    {
        $query = html_entity_decode(trim(strip_tags($query)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $query = preg_replace('/\s+/', ' ', $query) ?? '';
        $query = trim($query, " \t\n\r\0\x0B\"'`");

        if ($query === '' || mb_strlen($query) < 3 || mb_strlen($query) > 90) {
            return '';
        }

        if (preg_match('/\b(login|password|token|hack|crack|apk mod|porn)\b/i', $query)) {
            return '';
        }

        return Str::lower($query);
    }

    protected function fingerprint(string $value): string
    {
        $value = Str::lower(strip_tags($value));
        $value = preg_replace('/[^\pL\pN\s]+/u', ' ', $value) ?? '';
        $words = preg_split('/\s+/', trim($value), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $stop = ['a', 'an', 'and', 'creator', 'creators', 'for', 'from', 'guide', 'how', 'in', 'maximise', 'maximize', 'maximizing', 'of', 'on', 'or', 'the', 'to', 'with', 'your'];
        $words = array_values(array_map(function (string $word): string {
            return preg_replace('/(ing|ed|es|s)$/', '', $word) ?: $word;
        }, array_filter($words, fn (string $word): bool => ! in_array($word, $stop, true))));
        sort($words);

        return implode(' ', array_unique($words));
    }



    protected function decodeSearchConsoleResponse(int $statusCode, string $body, string $siteUrl): array
    {
        $payload = json_decode($body, true);
        if (! is_array($payload)) {
            throw new RuntimeException('Google Search Console returned invalid JSON.');
        }

        if ($statusCode >= 200 && $statusCode < 300) {
            return $payload;
        }

        $message = (string) Arr::get($payload, 'error.message', 'Unknown Search Console API error.');
        if ($statusCode === 403) {
            throw new RuntimeException(
                'Google Search Console permission denied for "' . $siteUrl . '". ' .
                'Run php artisan gsc:sites and set DAILY_BLOG_GSC_SITE_URL exactly to one returned Site URL, or reconnect using a Google account that has access. Google said: ' . $message
            );
        }

        if ($statusCode === 401) {
            throw new RuntimeException('Google Search Console token is invalid or expired. Run php artisan gsc:connect again. Google said: ' . $message);
        }

        throw new RuntimeException('Google Search Console API failed with HTTP ' . $statusCode . ': ' . $message);
    }

    protected function searchAnalyticsRows(array $dimensions, int $rowLimit, string $startDate, string $endDate): array
    {
        $siteUrl = $this->accessibleSiteUrl();
        $body = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'rowLimit' => $rowLimit,
        ];

        if ($dimensions !== []) {
            $body['dimensions'] = $dimensions;
        }

        $response = $this->http->post(
            'https://www.googleapis.com/webmasters/v3/sites/' . rawurlencode($siteUrl) . '/searchAnalytics/query',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken(),
                    'Content-Type' => 'application/json',
                ],
                'http_errors' => false,
                'json' => $body,
            ]
        );

        $payload = $this->decodeSearchConsoleResponse($response->getStatusCode(), (string) $response->getBody(), $siteUrl);

        return (array) ($payload['rows'] ?? []);
    }

    protected function formatDimensionRows(array $rows, array $dimensions): array
    {
        return array_map(function (array $row) use ($dimensions): array {
            $item = [];
            foreach ($dimensions as $index => $dimension) {
                $item[$dimension] = (string) Arr::get($row, 'keys.' . $index, '');
            }

            return array_merge($item, $this->metricsOnly($row));
        }, $rows);
    }

    protected function metricsOnly(array $row): array
    {
        return [
            'clicks' => round((float) ($row['clicks'] ?? 0), 3),
            'impressions' => round((float) ($row['impressions'] ?? 0), 3),
            'ctr' => round((float) ($row['ctr'] ?? 0), 6),
            'position' => round((float) ($row['position'] ?? 0), 3),
        ];
    }

    protected function briefRows(array $rows, array $labels, int $limit): string
    {
        $items = [];
        foreach (array_slice($rows, 0, $limit) as $row) {
            if (! is_array($row)) {
                continue;
            }

            $name = implode(' -> ', array_filter(array_map(
                fn (string $label): string => trim((string) ($row[$label] ?? '')),
                $labels
            )));

            if ($name === '') {
                continue;
            }

            $views = array_key_exists('views', $row) ? sprintf(', %d local views', (int) $row['views']) : '';
            $items[] = sprintf(
                '%s (%.0f impressions, %.0f clicks, %.2f%% CTR, %.1f position%s)',
                $name,
                (float) ($row['impressions'] ?? 0),
                (float) ($row['clicks'] ?? 0),
                ((float) ($row['ctr'] ?? 0)) * 100,
                (float) ($row['position'] ?? 0),
                $views
            );
        }

        return $items === [] ? 'none' : implode('; ', $items);
    }


    protected function sameSiteProperty(string $configured, string $siteUrl): bool
    {
        $configured = trim($configured);
        $siteUrl = trim($siteUrl);
        if ($configured === '' || $siteUrl === '') {
            return false;
        }

        if (rtrim($configured, '/') . '/' === rtrim($siteUrl, '/') . '/') {
            return true;
        }

        $configuredHost = parse_url($configured, PHP_URL_HOST) ?: preg_replace('/^sc-domain:/', '', $configured);
        $siteHost = parse_url($siteUrl, PHP_URL_HOST) ?: preg_replace('/^sc-domain:/', '', $siteUrl);

        return $this->rootDomain((string) $configuredHost) === $this->rootDomain((string) $siteHost);
    }

    protected function rootDomain(string $host): string
    {
        $host = Str::lower(trim($host));
        $host = preg_replace('/^www\./', '', $host) ?? $host;

        return trim($host, '/');
    }

    protected function latestReportPath(): string
    {
        return storage_path('app/daily-blog/gsc-reports/latest.json');
    }

    protected function clientId(): string
    {
        return trim((string) config('services.google.client_id'));
    }

    protected function clientSecret(): string
    {
        return trim((string) config('services.google.client_secret'));
    }

    protected function siteUrl(): string
    {
        return trim((string) config('services.daily_blog.gsc_site_url', config('app.url')));
    }

    protected function tokenPath(): string
    {
        return (string) config('services.daily_blog.gsc_token_path', storage_path('app/google-search-console-token.json'));
    }
}
