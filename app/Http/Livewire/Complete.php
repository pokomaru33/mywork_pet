<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Complete extends Component
{
    public function mount()
    {
        if (empty(session()->get('posts'))) {
            return redirect()->route('contact_input');
        }

        // セッションクリア
        session()->forget('posts');
    }
    public function render()
    {
        return view('livewire.complete');
    }
}
