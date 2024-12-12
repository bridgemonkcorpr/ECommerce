<x-guest-layout>
    <div class="py-32">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-card class="!rounded-none sm:!rounded-lg">
                <x-slot:content class="!py-8 sm:!px-10">
                    <div class="mb-6 text-sm text-purple-600">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </div>

                    <form
                        method="POST"
                        action="{{ route('password.confirm') }}"
                    >
                        @csrf

                        <!-- Password -->
                        <div>
                            <x-input-label
                                for="password"
                                :value="__('Password')"
                            />

                            <x-input
                                id="password"
                                class="block mt-1 w-full"
                                type="password"
                                required
                            />

                            <x-input-error
                                for="password"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-6">
                            <button class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>
                </x-slot:content>
            </x-card>
        </div>
    </div>
</x-guest-layout>
