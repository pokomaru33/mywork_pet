<?php

namespace App\Http\Livewire;

use Livewire\Component;


class Input extends Component
{
    public $posts; // ユーザが入力する値

    public function mount()
    {
        // 確認画面から入力に戻ったときのため、sessionに保存した入力値を取得
        $this->posts = session()->get('posts');
    }

    protected $rules = [
        // name を必須
        'posts.name' => 'required',
        // email を必須 かつ メールアドレス形式
        'posts.mail' => 'required|email',
        // request（チェックボックスの選択）を必須 かつ 配列形式
        'posts.title' => 'required',
    ];

    // エラーメッセージの設定
    protected $messages = [
        'posts.*.required' => '必須項目です',
        'posts.mail.email' => '正しいメールアドレスを入力ください',
    ];

    public function confirm()
    {
        // バリデーションの実行
        $this->validate();

        // 入力されたpostプロパティを、セッション名'posts'で
        // セッションに保存
        session()->put('posts', $this->posts);

        // 確認画面へリダイレクト
        return redirect()->route('contact_confirm');
    }

    public function render()
    {
        return view('livewire.input');
    }
}
