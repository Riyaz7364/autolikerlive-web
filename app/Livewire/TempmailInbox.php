<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;


class TempmailInbox extends Component
{
    protected Collection $messages;

    protected $listeners = [
        'refreshInbox'  => 'checkInbox',
    ];


    public function mount($prefill = null)
    {
        if (is_array($prefill) && isset($prefill['messages'])) {
            $this->messages = collect($prefill);
        } else {
            $this->messages = collect();
        }
    }

    public function checkInbox(){
        // dd(Session::get('email'));
        $request = new Request([
            'email' => Session::get('email'),
        ]);

         $data = app('App\Http\Controllers\TempMailController')->messages($request);

        $this->messages = collect($data);
        $this->dispatch('show-loader');

        // Lightweight payload so the page can detect *new* arrivals
        // (sound + toast + highlight). First poll just seeds the ids.
        $msgs = [];
        if (is_array($data) && ($data['status'] ?? false) === true
            && isset($data['messages']) && is_array($data['messages'])) {
            foreach ($data['messages'] as $m) {
                if (is_array($m) && isset($m['id'])) {
                    $msgs[] = [
                        'id' => $m['id'],
                        'subject' => mb_substr((string) ($m['subject'] ?? '(no subject)'), 0, 80),
                        'from' => mb_substr((string) ($m['from'] ?? ($m['from_email'] ?? 'Unknown')), 0, 60),
                    ];
                }
            }
        }
        $this->dispatch('inbox-updated', messages: $msgs);
    }

    public function render()
    {
        return view('livewire.tempmail-inbox');
    }
}
