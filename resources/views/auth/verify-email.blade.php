<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            ご登録ありがとうございます！<br>
            ご入力いただいたメールアドレスへ認証リンクを送信しましたので、ご確認ください。メール内の「認証」をクリックし登録を完了させてください。<br>もし、認証メールが届かない場合は「承認メールを再送する」をクリックしてください。
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">新しい認証メールが送信されました。ご入力いただいたメールアドレスをご確認ください。</div>
        @endif

        <div class="mt-4 flex items-center justify-around">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit" class="px-2">
                        {{ __('認証メールを再送する') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">ログアウト</button>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
