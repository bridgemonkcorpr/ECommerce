<div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img
            src="{{ $brandSettings->logo_path ? Storage::url($brandSettings->logo_path) : asset('img/logo.png') }}"
            alt="{{ config('app.name') }}"
            class="mx-auto h-20 w-auto"
        >
    </div>
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <x-card class="relative">
            <x-slot:content>
                <div class="absolute -bottom-px left-0 right-0 h-px bg-gradient-to-r from-purple-400/0 via-purple-400 to-purple-400/0"></div>
                <div class="text-center mb-5 md:mb-7">
                    <h1 class="text-3xl font-medium tracking-tight text-slate-800 dark:text-slate-100">
                        {{ __('Reset your password') }}
                    </h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        {{ __('Please enter your new password.') }}
                    </p>
                </div>

                <!-- Validation alert -->
                @if ($errors->any())
                    <x-alert
                        type="error"
                        class="mb-4"
                    >
                        <x-slot:title>
                            {{ __('Whoops! Something went wrong.') }}
                        </x-slot:title>

                        <x-slot:message>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-slot:message>
                    </x-alert>
                @endif

                <!-- Main form -->
                <form wire:submit.prevent="submit">
                    <fieldset
                        wire:target="submit"
                        wire:loading.attr="disabled"
                    >
                        <!-- Email address -->
                        <div>
                            <x-input-label
                                for="email"
                                :value="__('Email')"
                            />
                            <x-input
                                wire:model.defer="email"
                                id="email"
                                type="email"
                                class="block mt-1 w-full sm:text-sm"
                                placeholder="email@address.tld"
                                required
                                autofocus
                            />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label
                                for="password"
                                :value="__('Password')"
                            />
                            <x-input
                                wire:model.defer="password"
                                id="password"
                                type="password"
                                class="block mt-1 w-full sm:text-sm"
                                required
                            />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label
                                for="password_confirmation"
                                :value="__('Confirm Password')"
                            />
                            <x-input
                                wire:model.defer="password_confirmation"
                                id="password_confirmation"
                                type="password"
                                class="block mt-1 w-full sm:text-sm"
                                required
                            />
                        </div>

                        <!-- Action button -->
                        <div class="flex items-center justify-center mt-4">
                            <button
                                type="submit"
                                class="btn btn-primary bg-purple-600 hover:bg-purple-700 block w-full"
                            >
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </fieldset>
                </form>
            </x-slot:content>
        </x-card>
    </div>
</div>
