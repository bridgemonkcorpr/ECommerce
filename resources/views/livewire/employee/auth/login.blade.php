<div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img
            src="{{ $brandSettings->logo_path ? Storage::url($brandSettings->logo_path) : asset('img/logo.png') }}"
            alt="{{ config('app.name') }}"
            class="mx-auto h-20 w-auto"
        >
    </div>
    <div
        x-data
        class="mt-8 sm:mx-auto sm:w-full sm:max-w-md"
    >
        <x-card
            class="relative"
            x-on:login-error.window="$el.classList.add('animate-buzz'); setTimeout(() => $el.classList.remove('animate-buzz'), 1000)"
        >
            <x-slot:content>
                <button
                    x-on:click.prevent="theme = (theme === 'light' ? 'dark' : 'light')"
                    class="absolute top-2 right-2"
                >
                    <span
                        x-text="theme === 'light' ? '{{ __('Enable dark mode') }}' : '{{ __('Enable light mode') }}'"
                        class="sr-only"
                    ></span>
                    <svg
                        x-show="theme === 'light'"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512"
                        class="h-6 w-6 text-slate-500 fill-current hover:text-slate-600"
                    >
                        <path d="M180.7 120.5C81 120.5 .2 201.5 .2 301.4S81 482.2 180.7 482.2c48.9 0 93.3-19.5 125.8-51.2c4.7-4.6 5.9-11.8 2.9-17.6s-9.5-9.1-16-8c-7.7 1.3-15.6 2-23.6 2c-76 0-137.6-61.8-137.6-138c0-51.6 28.2-96.5 70-120.2c5.7-3.3 8.7-9.9 7.3-16.3s-6.9-11.2-13.4-11.8c-5-.4-10.2-.6-15.3-.6z" />
                        <path
                            class="opacity-40"
                            d="M268.3 93.4l10.4 36.4c1 3.4 4.1 5.8 7.7 5.8s6.7-2.4 7.7-5.8l10.4-36.4L340.8 83c3.4-1 5.8-4.1 5.8-7.7s-2.4-6.7-5.8-7.7L304.4 57.2 294 20.9c-1-3.4-4.1-5.8-7.7-5.8s-6.7 2.4-7.7 5.8L268.3 57.2 231.9 67.6c-3.4 1-5.8 4.1-5.8 7.7s2.4 6.7 5.8 7.7l36.4 10.4zm96.4 144.6l15.6 54.6c1.5 5.1 6.2 8.7 11.5 8.7s10-3.5 11.5-8.7l15.6-54.6 54.6-15.6c5.1-1.5 8.7-6.2 8.7-11.5s-3.5-10-8.7-11.5l-54.6-15.6-15.6-54.6c-1.5-5.1-6.2-8.7-11.5-8.7s-10 3.5-11.5 8.7l-15.6 54.6-54.6 15.6c-5.1 1.5-8.7 6.2-8.7 11.5s3.5 10 8.7 11.5l54.6 15.6z"
                        />
                    </svg>
                    <svg
                        x-show="theme === 'dark'"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        class="h-6 w-6 text-slate-500 fill-current hover:text-slate-400"
                    >
                        <path d="M320 256C320 309 277 352 224 352C170.1 352 128 309 128 256C128 202.1 170.1 160 224 160C277 160 320 202.1 320 256z" />
                        <path
                            class="opacity-40"
                            d="M192 80C192 62.33 206.3 48 224 48C241.7 48 256 62.33 256 80C256 97.67 241.7 112 224 112C206.3 112 192 97.67 192 80zM192 432C192 414.3 206.3 400 224 400C241.7 400 256 414.3 256 432C256 449.7 241.7 464 224 464C206.3 464 192 449.7 192 432zM400 288C382.3 288 368 273.7 368 256C368 238.3 382.3 224 400 224C417.7 224 432 238.3 432 256C432 273.7 417.7 288 400 288zM48 224C65.67 224 80 238.3 80 256C80 273.7 65.67 288 48 288C30.33 288 16 273.7 16 256C16 238.3 30.33 224 48 224zM128 128C128 145.7 113.7 160 96 160C78.33 160 64 145.7 64 128C64 110.3 78.33 96 96 96C113.7 96 128 110.3 128 128zM352 416C334.3 416 320 401.7 320 384C320 366.3 334.3 352 352 352C369.7 352 384 366.3 384 384C384 401.7 369.7 416 352 416zM384 128C384 145.7 369.7 160 352 160C334.3 160 320 145.7 320 128C320 110.3 334.3 96 352 96C369.7 96 384 110.3 384 128zM96 352C113.7 352 128 366.3 128 384C128 401.7 113.7 416 96 416C78.33 416 64 401.7 64 384C64 366.3 78.33 352 96 352z"
                        />
                    </svg>
                </button>

                <div class="absolute -bottom-px left-0 right-0 h-px bg-gradient-to-r from-purple-400/0 via-purple-400 to-purple-400/0"></div>

                <div class="text-center mb-5 md:mb-7">
                    <h2 class="text-3xl font-medium tracking-tight text-slate-800 dark:text-slate-100">
                        {{ __('Welcome back') }}
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        {{ __('Please enter your email and password to continue.') }}
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
                        class="space-y-6"
                    >
                        <!-- Email address -->
                        <div>
                            <x-input-label
                                for="email"
                                :value="__('Email address')"
                            />
                            <x-input
                                wire:model.defer="email"
                                id="email"
                                type="email"
                                name="email"
                                class="block mt-1 w-full sm:text-sm"
                                placeholder="email@address.tld"
                                required
                                autofocus
                            />
                            <x-input-error
                                for="email"
                                class="mt-2"
                            />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label
                                for="password"
                                :value="__('Password')"
                            />
                            <x-input
                                wire:model.defer="password"
                                id="password"
                                type="password"
                                name="password"
                                class="block mt-1 w-full sm:text-sm"
                            />
                            <x-input-error
                                for="password"
                                class="mt-2"
                            />
                        </div>

                        <!-- Remember -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <x-input
                                    wire:model.defer="remember_me"
                                    type="checkbox"
                                    id="remember-me"
                                    class="h-4 w-4 !rounded !shadow-none"
                                />
                                <x-input-label
                                    for="remember-me"
                                    :value="__('Remember me')"
                                    class="ml-2"
                                />
                            </div>
                            <div class="text-sm">
                                <a
                                    href="{{ route('employee.forgot-password') }}"
                                    class="btn btn-link  text-purple-600"
                                    tabindex="-1"
                                >
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        </div>

                        <!-- Action button -->
                        <div>
                            <button
                                type="submit"
                                class="btn btn-primary bg-purple-600 hover:bg-purple-700 block w-full"
                            >
                                {{ __('Sign in') }}
                            </button>
                        </div>
                    </fieldset>
                </form>
            </x-slot:content>
        </x-card>
    </div>
</div>
