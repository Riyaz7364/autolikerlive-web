<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LikeIcon extends Component
{
    /**
     * Create a new component instance.
     */

    public $size;

    public function __construct($size)
    {
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.like-icon');
    }
}
