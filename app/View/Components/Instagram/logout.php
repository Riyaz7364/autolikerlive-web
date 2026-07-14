<?php

namespace App\View\Components\Instagram;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Game;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\GameSession;
use App\Models\GameLayer;
class logout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.instagram.logout');
    }
}
