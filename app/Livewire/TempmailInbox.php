<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;

class TempmailInbox extends Component
{
    protected Collection $messages;

    protected $listeners = [
        'refreshInbox'  => 'checkInbox',
    ];


    public function mount()
    {
        $this->messages = collect();
    }

    public function checkInbox(){

        $request = new Request([
            'email' => Session::get('email'),
        ]);

        $data = app('App\Http\Controllers\APIController')->messages($request);
        $this->messages = collect($data);
        $this->dispatch('show-loader');
    }

    public function render()
    {
        return view('livewire.tempmail-inbox');
    }
}
