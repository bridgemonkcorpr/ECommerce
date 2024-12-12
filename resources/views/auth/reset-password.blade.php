<x-guest-layout>
    <div class="py-32">
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <x-card>
                <x-slot:content class="!py-8 sm:!px-10">
                    <form
                        method="POST"
                        action="{{ route('password.update') }}"
                    >
                        @csrf

                        <!-- Password Reset Token -->
                        <input
                            type="hidden"
                            name="token"
                            value="{{ $request->route('token') }}"
                        >

                        <!-- Email Address -->
                        <div>
                            <x-input-label
                                for="email"
                                :value="__('Email')"
                            />

                            <x-input
                                id="email"
                                class="block mt-1 w-full sm:text-sm"
                                type="email"
                                name="email"
                                :value="old('email', $request->email)"
                                required
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
                                :value="__('New password')"
                            />

                            <x-input
                                id="password"
                                class="block mt-1 w-full sm:text-sm"
                                type="password"
                                name="password"
                                required
                                autofocus
                            />

                            <x-input-error
                                for="password"
                                class="mt-2"
                            />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-6">
                            <x-input-label
                                for="password_confirmation"
                                :value="__('Confirm new password')"
                            />

                            <x-input
                                id="password_confirmation"
                                class="block mt-1 w-full sm:text-sm"
                                type="password"
                                name="password_confirmation"
                                required
                            />

                            <x-input-error
                                for="password_confirmation"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-6">
                            <button class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </x-slot:content>
            </x-card>
        </div>
    </div>
</x-guest-layout>
