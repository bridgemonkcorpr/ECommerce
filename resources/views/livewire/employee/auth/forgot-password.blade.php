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
                        {{ __('Forgot your password?') }}
                    </h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        {{ __('Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </p>
                </div>

                <!-- Status alert -->
                <x-alert
                    type="success"
                    class="mb-4"
                    :message="session('status')"
                />

                <!-- Main form -->
                <form wire:submit.prevent="submit">
                    <fieldset
                        wire:target="submit"
                        wire:loading.attr="disabled"
                    >
                        <!-- Email Address -->
                        <div>
                            <x-input-label
                                for="email"
                                :value="__('Email')"
                            />
                            <x-input
                                wire:model.defer="email"
                                id="email"
                                type="email"
                                name="email"
                                class="block mt-1 w-full sm:text-sm"
                                value="{{ old('email') }}"
                                placeholder="email@address.tld"
                                required
                                autofocus
                            />
                            <x-input-error
                                for="email"
                                class="mt-2"
                            />
                        </div>

                        <!-- Action button -->
                        <div class="flex items-center center mt-4">
                            <button
                                type="submit"
                                class="btn btn-primary bg-purple-600 hover:bg-purple-700 block w-full"
                            >
                                {{ __('Email Password Reset Link') }}
                            </button>
                        </div>
                    </fieldset>
                </form>
            </x-slot:content>
        </x-card>
    </div>
</div>
