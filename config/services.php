<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI', 'https://www.autolikerlive.com/app/rajeliker/callback'),
        'graph_api_version' => 'v19.0',
    ],

    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],


    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'iphub' => [
        'key' => env('IPHUB_KEY'),
    ],

    'aicredit' => [
        'key' => env('AICREDIT_API_KEY'),
        'base_url' => env('AICREDIT_BASE_URL', 'https://api.aicredits.in/v1'),
        'model' => env('AICREDIT_TEXT_MODEL', env('TEXT_MODEL', 'gemini-2.0-flash')),
    ],

    'cloudflare' => [
        'base_url' => "https://free-image-generation-api.rseifi-a73.workers.dev/",
        'key' => env('CLOUDFLARE_WORKER_API_KEY'),
    ],

    'gemini' => [
        'key' => env(
            'GEMINI_API_KEY',
            env(
                'GEMINI_KEY',
                env(
                    'GOOGLE_API_KEY',
                    env(
                        'GOOGLE_AI_API_KEY',
                        env('OPENAI_KEY')
                    )
                )
            )
        ),
        'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
        'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),
        'image_model' => env('GEMINI_IMAGE_MODEL', 'gemini-2.5-flash-image'),
    ],

    'daily_blog' => [
        'wordpress_path' => env('DAILY_BLOG_WORDPRESS_PATH', '../public_html/blog'),
        'mysql_socket' => env('DAILY_BLOG_MYSQL_SOCKET', '/run/mysqld/mysqld.sock'),
        'post_status' => env('DAILY_BLOG_POST_STATUS', 'publish'),
        'author_id' => env('DAILY_BLOG_AUTHOR_ID', 1),
        'category' => env('DAILY_BLOG_CATEGORY', 'Guides'),
        'topics' => env('DAILY_BLOG_TOPICS', ''),
        'internal_links' => env('DAILY_BLOG_INTERNAL_LINKS', implode('|', [
            'https://www.autolikerlive.com/',
            'https://www.autolikerlive.com/blog/',
            'https://www.autolikerlive.com/web-tools',
        ])),
    ],

];
