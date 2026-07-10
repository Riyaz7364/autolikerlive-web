<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WebAppNavbar extends Component
{
    /**
     * Create a new component instance.
     */
    public $like;
    public $follow;
    public $title;

    public function __construct($title = "",$like=0, $follow=0)
    {
        $this->like = $like;
        $this->follow = $follow;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.web-app-navbar');
    }
}
