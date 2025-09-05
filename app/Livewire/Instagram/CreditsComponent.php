<?php

namespace App\Livewire\Instagram;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class CreditsComponent extends Component
{

    public $credits;

    protected $listeners = ['updateCredits' => 'refreshCredits'];

    public function mount()
    {
        $this->refreshCredits();
    }

    public function refreshCredits()
    {
        $this->credits = Auth::user()->fresh()->credits;
    }

    public function render()
    {
        return view('livewire.instagram.credits-component');
    }
}
