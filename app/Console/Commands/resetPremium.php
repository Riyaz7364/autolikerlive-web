<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PremiumAccount;
use Carbon\Carbon;
class resetPremium extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-premium';

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
         $data = PremiumAccount::where('created_at','<',Carbon::now()->subHours(12))->delete();
    }
}
