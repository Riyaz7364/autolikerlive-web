<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$proxies = array_slice(file('/home/autolikerlive/laravel/proxies.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), 0, 20);

$working = [];

foreach ($proxies as $proxy) {

    try {

        $response = Http::withOptions([

            'proxy' => 'http://'.$proxy,

            'timeout' => 5,

            'verify' => false

        ])->get('http://httpbin.org/ip');

        if ($response->successful()) {

            $data = $response->json();

            if (isset($data['origin'])) {

                $working[] = $proxy;

                echo "Working: $proxy\n";

            }

        }

    } catch (\Exception $e) {

        // not working

    }

}

echo "Working proxies:\n";

print_r($working);

file_put_contents('working_proxies.txt', implode("\n", $working));
