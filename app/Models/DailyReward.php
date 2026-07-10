<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
class DailyReward extends Model
{
    use HasFactory;


    // Accessor to determine CSS status
    public function getRewardStatusAttribute()
    {
        $user = loadUser(Session::get('my_json_data'));

        $entry = DailyCheck::where('user_id', $user->id)->latest()->first();
        $totalEntries = DailyCheck::where('user_id', $user->id)->count();
        // Logic to check if today's reward should be enabled

        if (!$entry && $this->day == 0 || $totalEntries == $this->day && $entry->created_at->day != now()->day) {
            return 'enabled'; // Enable the next day's reward
        } elseif($totalEntries > $this->day) {
            return 'completed'; // Today's reward is completed
        } else {
                return 'locked'; // Future reward, not unlocked yet
        }


    }

}
