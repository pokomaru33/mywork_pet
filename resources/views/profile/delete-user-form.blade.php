<x-jet-action-section>
    <x-slot name="title">
        {{ __('アカウント削除') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('本当に削除しますか？ あなたのデータすべて削除されます。') }}
        </div>
        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('パスワード') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="deleteUser" />

            <x-jet-input-error for="password" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                {{ __('アカウント削除') }}
            </x-jet-danger-button>
        </div>
    </x-slot>
</x-jet-action-section>
