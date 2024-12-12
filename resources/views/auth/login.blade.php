<x-guest-layout>
    <div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen py-32 px-6 sm:px-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h1 class="text-center text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Sign in to your account') }}
            </h1>
            <p class="mt-2 text-center text-sm text-purple-600 dark:text-purple-300">
                {{ __('Or') }}

                   <a href="{{ route('register') }}"
                    class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-200"
                >
                    {{ __('create a new one to get started') }}
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden p-8">
                <!-- Session Status -->
                @if(session('status'))
                    <x-alert
                        class="mb-6"
                        type="success"
                        message="{{ session('status') }}"
                    />
                @endif

                <form
                    method="POST"
                    action="{{ route('login') }}"
                >
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label
                            for="email"
                            :value="__('Email address')"
                        />

                        <x-input
                            id="email"
                            class="block mt-1 w-full sm:text-sm"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                        />

                        <x-input-error
                            for="email"
                            class="mt-2"
                        />
                    </div>

                    <!-- Password -->
                    <div class="mt-6">
                        <x-input-label
                            for="password"
                            :value="__('Password')"
                        />

                        <x-input
                            id="password"
                            class="block mt-1 w-full sm:text-sm"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                        />

                        <x-input-error
                            for="password"
                            class="mt-2"
                        />
                    </div>

                    <!-- Remember Me -->
                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <x-input
                                type="checkbox"
                                name="remember_me"
                                id="remember_me"
                                class="h-4 w-4 !rounded !shadow-none text-purple-600 focus:ring-purple-500"
                            />

                            <x-input-label
                                for="remember_me"
                                :value="__('Remember me')"
                                class="ml-2"
                            />
                        </div>
                        <div class="text-sm">

                             <a   href="{{ route('password.request') }}"
                                class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-200"
                            >
                                {{ __('Forgot your password?') }}
                            </a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                            {{ __('Sign in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
