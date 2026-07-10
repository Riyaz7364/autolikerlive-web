<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DailyReward;

class DailyCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function getRewardAttribute(){
        $totalEntries = $this->where('user_id', $this->user_id)->count();
        return DailyReward::where('day', $totalEntries-1)->first();

    }
}
