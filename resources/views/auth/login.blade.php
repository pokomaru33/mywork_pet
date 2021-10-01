<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('自動ログイン') }}</span>
                </label>
            </div>

            <div class="flex items-center mt-4">
                <x-jet-button class="w-full py-3 ">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
            <div class="flex items-center mt-4">
                <a href="{{ route('social_login.redirect', 'line') }}" class="inline-flex items-center px-2 py-2 disabled:opacity-25 transition w-48">
                    <img style="width:50px" src="/storage/images/common/icon_line.png">
                </a>
                <p class="underline text-sm text-gray-500 ml-1">本ウェブサービスでは、LINEによる承認を得た場合のみメールアドレスを取得します。そして、取得されたメールアドレスにつきましては本サービスのログイン以外の目的では一切使用しません。
                </p>
            </div>
            <div class="flex items-center mt-4">
                {{-- 登録ボタン --}}
                <a href="{{ route('register') }}" class="mr-4 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">メンバー登録</a>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('パスワードをお忘れですか?') }}
                    </a>
                @endif
            </div>
        </form>
    </x-jet-authentication-card>

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <p class="text-3xl">初めての方へ</p>
        </div>

        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-6">
                    <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <div class="ml-4 text-lg leading-7 font-semibold">はじめに</div>
                    </div>
                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            こちらのサイトはペットの健康管理webアプリケーションです。無料メンバー登録で使用することができます。使用する際はこのページをブックマーク若しくはスマホのホーム画面に追加してください。
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <div class="ml-4 text-lg leading-7 font-semibold">できること</div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            <ul>
                                <li>ペットの登録</li>
                                <li>ペットの体重の入力・グラフで比較</li>
                                <li>ペットについてメモの入力・病院からのメモ入力</li>
                                <li>カレンダーメモ機能</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-guest-layout>
