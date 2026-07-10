<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FacebookService;
class testAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-a-p-i';

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
        // $fbService = new FacebookService();
        // $fburl = 'https://www.facebook.com/mohd.mustakim.52035/followers'; // Replace with the actual Facebook URL
        // try {
        //     $path = $fbService->getPathFromFBURL($fburl);
        //     $pathData = $fbService->getPathData($path);
        //     $this->info("Path: " . $path);
        //     $this->info("Path Data: " . $pathData);
        // } catch (\Exception $e) {
        //     $this->error("Error: " . $e->getMessage());
        // }
    }
}
