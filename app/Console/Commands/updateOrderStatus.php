<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class updateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-order-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $activeLinks = Link::where('status', 'running')->whereNotNull('order_id')->limit(10)->inRandomOrder()->get();

        foreach ($activeLinks as $link) {

            $order_id = $link->order_id;

            $key = 'fef081d0d82d678f3d64c3a5cc190179';
            $api = 'https://smmsocialmedia.in/api/v2';

            $query = array(
                'key' => $key,
                'action' => 'status',
                'order' => $order_id,
            );

            $response = Http::post($api, $query);
            if($response->failed()){
                continue;
            }

            $responseData = $response->json();
            $status = $responseData['status'] ?? null;

            $link->status = $status;
            $link->save();

        }
    }
}
