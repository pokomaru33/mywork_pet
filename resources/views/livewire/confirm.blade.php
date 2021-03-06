<div class="px-4 pb-8">
    <div class="my-4">以下の内容を確認して、送信ボタンを押してください。送信後数秒でお問い合わせ完了画面へ移動します。</div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="border-t border-gray-200">
            <dl>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                お名前
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ @$posts['name'] }}
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                メールアドレス
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ @$posts['mail'] }}
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    件名
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ @$posts['title'] }}
                    </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                ご希望・ご質問
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {!! nl2br(e(@$posts['comment'])) !!}
                </dd>
            </div>
            </dl>
        </div>
        </div>
        <div class="mt-8">
            <button
            wire:click="submit"
            class="w-full p-3 text-sm font-bold tracking-wide text-gray-100 uppercase bg-green-500 rounded-lg focus:outline-none focus:shadow-outline">
            上記内容を送信
            </button>
        </div>
        <div class="mt-8">
            <button
            wire:click="back"
            class="w-2/5 p-3 text-sm font-bold tracking-wide text-gray-100 uppercase bg-gray-500 rounded-lg focus:outline-none focus:shadow-outline">
            修正する
            </button>
        </div>
    </div>