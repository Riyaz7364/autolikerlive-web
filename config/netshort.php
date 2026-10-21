<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Upstream NetShort host
    |--------------------------------------------------------------------------
    */
    'host' => env('NETSHORT_HOST', 'https://appsecapi.netshort.com'),

    'user_agent' => env(
        'NETSHORT_UA',
        'Mozilla/5.0 (Linux; Android 16; TECNO LK7k Build/BP2A.250605.031.A3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/140.0.7339.207 Mobile Safari/537.36'
    ),

    // App fingerprint headers (mirrors wrc.java / api_client.py build()).
    'version' => env('NETSHORT_VERSION', '2.3.3'),
    'version_code' => env('NETSHORT_VERSION_CODE', '245'),
    'os_ver' => env('NETSHORT_OS_VER', '16'),
    'model' => env('NETSHORT_MODEL', 'TECNO LK7k'),
    'start_type' => env('NETSHORT_START_TYPE', 'hot'),
    'network' => env('NETSHORT_NETWORK', 'wifi,hot,false'),
    'content_language' => env('NETSHORT_CONTENT_LANGUAGE', 'en_US'),
    'device_code' => env('NETSHORT_DEVICE_CODE', '0e702dd52acbdf0c'),

    'timeout' => (int) env('NETSHORT_TIMEOUT', 25),

    /*
    |--------------------------------------------------------------------------
    | NetShort server RSA public key (DER base64, X.509).
    | Requests seal their AES key to this key (wrc.java:110-142).
    |--------------------------------------------------------------------------
    */
    'server_pub' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2poXMstZ8NCWE7915MXzDWC5/t+oB2waGfskPqSZwLqxd4ZBR'
        .'0H1cb1tAZRZcV7P+LmOd6SYNxhnELaWuKTD+D3xkz8Tt1L5j/ynGqVt1MDbiQIEzXQKUkNDSH6T0A+Xzo/67/8QOQXlVJ'
        .'fW06resbaeNvibfx6Qc78j96bCIPlxPrtieilVTBHUFOXjirxK/ki/mO8P2smRbpt73fsQWdGmTGMfYGvfPApGyxbxL'
        .'kL/qrBjU25XpM8a0MBqzFWUAchHmqSBJ6Mbfam1SSgf3b2U28s67nOW+JiOrhd6iVLcsLFxXA54HX+Zbej3AbOB6jKaE'
        .'mp/bz1amneE1NYXwwIDAQAB',

    /*
    |--------------------------------------------------------------------------
    | App RSA private key (DER base64, PKCS#8).
    | Responses seal their AES key to OUR public key, so only this key opens
    | them (tr2.java:253-291). Same keypair as api_client.py APP_PRIV.
    |--------------------------------------------------------------------------
    */
    'app_priv' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCK0Tl1pd7bjTRU93bWoHW1hLCDj2+9bg1MgY8j5C7xXaw'
        .'6bJfToXhWbH1fXNbnFFVqxyYNErcuOUwJZxyDgcxUXM4yWnRseb2GF97GOicAQ2keDzVYmwky4lrSRwvcXutJRLPUCRQNf'
        .'c6upfk2G5TKh6/CcP4TV1eXTF7+vdEw2SHxAOITKbSfcaZXr/hVs6a1aRHsBF+7RG99ebwZIP6/AgIyqX9RbDVN6ixi1v2G'
        .'3/bwAULHLSqGdSaqij/ca17fbFGITaeCeEaZ6d/P4ZuOK+PEPdbPQt6SbY4lZaYwRvdrpH73kigPITgDzIDONFybJ1m7wR'
        .'Klq1wxWHwbimptAgMBAAECggEAPz3cYJXFtt5YphDrahJGLgEabYVOUc2ub1li/eX54OpdCWzpqneYnD7myyg/m5zu4SuD'
        .'UVdibsOZuXrpSZw7m3+ATP5apgS8bDe5vTNHC16qqBAjrI9NHIp09/F4HNh9dq6/Am10XkUfgP+KTrU4DyDL2NijV+pltD8'
        .'N1B5kDE1igokVcsavhnu2INoMRXYE78Wq6urNECuFWw9hldv81M9m2w56t1CQOUukpo4mfmLjZRe2s+kwtcBVefGHP8Cj0'
        .'OeH2dGltjl2YSQMRBFUCVoixYpOrcjIHoqzWri8IfUZ2tW+nUvHl5IZ9RVxefnFaLGnxiXd2sk6Sn4aD/l9YQKBgQDVv3Ha'
        .'OZxHRqlNSPrNGqplGhE066HnDsq6MlPukiovxE43CRBmpTnk9zDCqrDh9t2HbJuao7nSq5WlBERWgwqXU/qDpH43W7Y/lJ'
        .'fHkDv6A2m0viJa0a9x8+CJpNnCDu1ATo4/IQKwoXYice6JKnUyXgkGKn+HipiN6tO0EtWHlQKBgQCmQfklKFtXtm/FZ6NI'
        .'Ms+d+EyvaE5xNLKGYQxmiCR10WGYd8ZV+K0Q6qXHS+a32TirWB9F3TqPOklTytMrfPZB3BCXj4weEldb8W716G8FYf7LL'
        .'haT+MdpF7KDcruObwoQAvKV3N4eX6tUEMmdrx9hpCmmIU5EeXUkhGdmwk7BeQKBgAIXMkThJV8pGMTRvuo8pYgBnkN3Pok'
        .'lAuSZU2rU8Sawc9dj9k4atZtAs7BjvQEoyffmHwt/KHUgCoGnrgdulq7uOlgJRtbBxeGPUYC5L2z9lY4YAfwDawThTsPp'
        .'4dtdDAMCAbAqYX1axu4FUUD0MltAwjPWPJMVzvIsZs+vE3mVAoGAJPja3OaCmZjadj2709xoyypic0dw2j/ry3JdfZec9A'
        .'5h87P/CTNJ2U81GoLIhe3qakAohDLUSPGfSOD74NnjMXYswmeLs0xE3Q9tq4XK2pmWPby8DJ/wSHCapByplN0gkbr2E1mQ'
        .'k5SW1xT8oPJGukH1eRpC+3s/D6XaEMH5HZECgYEAigoX5l39LDsCgeaUcI4S9grkaas/WsKv37eqo3oD9Qk6VFiMM5L5Z'
        .'ig6aXJxuAPLVjb38caJRPmPmOXLT2kEP1E1h6OJOhEhETwVIUtcBzsK25ju9LqL89bC+W0uS7BPvk6Tcws/tXHCkQCTgb'
        .'9jVXceZ2ox+6axvlW/5WgHt5Q=',

    /*
    |--------------------------------------------------------------------------
    | Device session storage: file (default, no DB needed) or database.
    | Database mode uses the `netshort_sessions` table (see migration).
    |--------------------------------------------------------------------------
    */
    'session_driver' => env('NETSHORT_SESSION_DRIVER', 'file'),

    // Curated upstream paths (mirrors decoder_web.py ENDPOINTS + login/share).
    'endpoints' => [
        '/prod-app-api/auth/login',
        '/prod-app-api/auth/app_link_startV2',
        '/prod-app-api/user/clock_task/today',
        '/prod-app-api/user/clock_task/list',
        '/prod-app-api/user/member_config',
        '/prod-app-api/user/activity',
        '/prod-app-api/user/app_reviews/find',
        '/prod-app-api/user/loop-task/list',
        '/prod-app-api/user/loop-task/getTask',
        '/prod-app-api/base/online/service/ext/msgCountHint',
        '/prod-app-api/base/charge/template/topVipDisCount',
        '/prod-app-api/base/checkstand/memberEquityV2',
        '/prod-app-api/base/im/pullUnreadMsg',
        '/prod-app-api/order/subscription/get-subscription',
        '/prod-app-api/video/recommend/list',
        '/prod-app-api/video/shortPlay/search/realtime',
        '/prod-app-api/video/shortPlay/base/detail_info/V2',
        '/prod-app-api/video/shortPlay/base/episode/detail_info',
        '/prod-app-api/video/shortPlay/base/reserve_list',
        '/prod-app-api/video/shortPlay/seriesRecommend/query',
        '/prod-app-api/video/shortPlay/recommend/loadRelatedHotDrama',
        '/prod-app-api/video/video/load_video_definition_config',
        '/prod-app-api/strategy/activity/position/find',
    ],
];
