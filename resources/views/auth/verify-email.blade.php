<x-guest-layout>
    <div class="py-32">
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <x-card>
                <x-slot:content class="!py-8 sm:!px-10">
                    <div class="mb-6 text-sm text-purple-600">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <x-alert
                            class="mb-6"
                            type="success"
                            message="{{ __('A new verification link has been sent to the email address you provided during registration.') }}"
                        />
                    @endif

                    <div class="mt-6 flex items-center justify-between">
                        <form
                            method="POST"
                            action="{{ route('verification.send') }}"
                        >
                            @csrf

                            <div>
                                <button class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </div>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-link  text-purple-600"
                            >
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </x-slot:content>
            </x-card>
        </div>
    </div>
</x-guest-layout>
