<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use App\Mail\ContactAdmin;
use Illuminate\Support\Arr;

class Confirm extends Component
{

    public $posts;

    public function mount()
    {
        $this->posts = session()->get('posts');
        if (empty($this->posts)) {
            return redirect()->route('contact_input');
        }
    }

    public function submit()
    {
        // メール送信
        $recipient_customer = Arr::get($this->posts, 'mail');
        $recipient_admin = config('app.admin_address');
        Mail::to($recipient_customer)->send(new Contact($this->posts));
        Mail::to($recipient_admin)->send(new ContactAdmin($this->posts));


        // 完了画面へ
        return redirect()->route('contact_complete');
    }

    public function back()
    {
        // 入力画面へ戻る
        return redirect()->route('contact_input');
    }

    public function render()
    {
        return view('livewire.confirm');
    }
}
