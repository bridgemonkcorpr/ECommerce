<div>
    <!-- Meta title & description -->
    <x-slot:title>
        {{ __('Profile') }}
    </x-slot:title>

    <div class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl sm:px-2 lg:px-8">
            <div class="mx-auto max-w-2xl px-4 lg:max-w-4xl lg:px-0">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    {{ __('Your Profile') }}
                </h1>
                <p class="mt-2 text-sm text-slate-500">
                    {{ __("Update your account's profile information and password.") }}
                </p>
                <div class="mt-16 space-y-12">
                    <livewire:customer.profile.components.personal-information />

                    <livewire:customer.profile.components.change-password />
                </div>
            </div>
        </div>
    </div>
</div>
