<x-app-layout>

@if(auth()->user()->id == 11)
<div>
    <p style="text-align: center; margin-top:30px">デモではアカウント情報を修正できません。</p>
</div>
@else
<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')
                
                <x-jet-section-border />
            @endif
            
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>
                
                <x-jet-section-border />
                @endif

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
                @endif
        </div>
    </div>
@endif
</x-app-layout>
