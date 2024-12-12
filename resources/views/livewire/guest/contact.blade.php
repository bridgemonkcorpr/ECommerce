<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden p-8">
            <div class="gap-12 justify-between lg:flex">
                <div class="max-w-lg space-y-6">
                    <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                        {{ __('Let us know how we can help') }}
                    </h1>
                    <p class="text-purple-600 dark:text-purple-300">
                        {{ __('We are here to help and answer any question you might have. We look forward to hearing from you! Please fill out the form, or use the contact information below.') }}
                    </p>
                    <div>
                        <ul class="mt-6 flex flex-wrap gap-x-10 gap-y-6 items-center">
                            @if($generalSettings->contact_email)
                                <li class="flex items-center gap-x-3">
                                    <div class="flex-none text-purple-500">
                                        <x-heroicon-o-envelope class="w-6 h-6" />
                                    </div>
                                    <p class="text-purple-700 dark:text-purple-300">
                                        {{ $generalSettings->contact_email }}
                                    </p>
                                </li>
                            @endif

                            @if($generalSettings->contact_phone)
                                <li class="flex items-center gap-x-3">
                                    <div class="flex-none text-purple-500">
                                        <x-heroicon-o-phone class="w-6 h-6" />
                                    </div>
                                    <p class="text-purple-700 dark:text-purple-300">
                                        {{ $generalSettings->contact_phone }}
                                    </p>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="flex-1 sm:max-w-lg lg:max-w-md mt-8 lg:mt-0">
                    <form
                        wire:submit.prevent="sendMessage"
                        class="space-y-5"
                    >
                        <div>
                            <x-input-label
                                for="nameInput"
                                :value="__('Your full name')"
                            />
                            <x-input
                                wire:model.defer="state.name"
                                id="nameInput"
                                class="block mt-1 w-full sm:text-sm"
                                type="text"
                                required
                            />
                            <x-input-error
                                for="state.name"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <x-input-label
                                for="emailInput"
                                :value="__('Email address')"
                            />
                            <x-input
                                wire:model.defer="state.email"
                                id="emailInput"
                                class="block mt-1 w-full sm:text-sm"
                                type="email"
                                required
                            />
                            <x-input-error
                                for="state.email"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <x-input-label
                                for="phoneInput"
                                :value="__('Phone number')"
                            />
                            <x-input
                                wire:model.defer="state.phone"
                                id="phoneInput"
                                class="block mt-1 w-full sm:text-sm"
                                type="text"
                                required
                            />
                            <x-input-error
                                for="state.phone"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <x-input-label
                                for="messageInput"
                                :value="__('Message')"
                            />
                            <x-textarea
                                wire:model.defer="state.message"
                                id="messageInput"
                                class="block mt-1 w-full sm:text-sm"
                                rows="4"
                                required
                            />
                            <x-input-error
                                for="state.message"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <button class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                                {{ __('Send message') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
