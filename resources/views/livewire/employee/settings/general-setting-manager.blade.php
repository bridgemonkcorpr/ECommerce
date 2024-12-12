    <div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
        <div class="max-w-7xl mx-auto">
            <!-- Meta title & description -->
            <x-slot:title>
                {{ __('General settings') }}
            </x-slot:title>

            <!-- Page content -->
            <div class="px-4 mx-auto max-w-7xl sm:px-6 xl:flex xl:gap-x-16 xl:px-8">
                @include('layouts.employee-settings-navigation')

                <div class="py-6 lg:flex-auto xl:py-0">
                    <div class="space-y-12">
                        <!-- Store Details Section -->
                        <div class="pb-12">
                            <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                                <div class="ml-4 mt-4">
                                    <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                        {{ __('Store details') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                        {{ __('View and update your store details.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                                <div class="p-6 space-y-6">
                                    <div>
                                        <x-input-label for="storeNameInput" :value="__('Store name')" />
                                        <x-input
                                            wire:model.defer="state.store_name"
                                            type="text"
                                            id="storeNameInput"
                                            class="mt-1 block w-full"
                                        />
                                        <x-input-error for="state.store_name" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="contactEmailInput" :value="__('Contact email')" />
                                        <x-input
                                            wire:model.defer="state.contact_email"
                                            type="email"
                                            id="contactEmailInput"
                                            class="mt-1 block w-full"
                                        />
                                        <x-input-error for="state.contact_email" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="contactPhoneInput" :value="__('Contact phone')" />
                                        <x-input
                                            wire:model.defer="state.contact_phone"
                                            type="tel"
                                            id="contactPhoneInput"
                                            class="mt-1 block w-full"
                                        />
                                        <x-input-error for="state.contact_phone" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cookie Consent Section -->
                        <div class="pb-12">
                            <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                                <div class="ml-4 mt-4">
                                    <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                        {{ __('Cookie consent') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                        {{ __('Configure your cookie consent banner.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                                <div class="p-6 space-y-6">
                                    <div x-data="{ on: @entangle('state.cookie_consent_enabled').defer }">
                                        <div class="flex items-center justify-between">
                                            <x-input-label :value="__('Enable cookie consent')" />
                                            <button
                                                x-on:click="on = !on"
                                                type="button"
                                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-purple-900"
                                                :class="{ 'bg-purple-600': on, 'bg-purple-200 dark:bg-purple-700': !on }"
                                                role="switch"
                                                :aria-checked="on.toString()"
                                            >
                                                <span
                                                    aria-hidden="true"
                                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                    :class="{ 'translate-x-5': on, 'translate-x-0': !on }"
                                                ></span>
                                            </button>
                                        </div>
                                        <x-input-error for="state.cookie_consent_enabled" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="cookieConsentMessageInput" :value="__('Message')" />
                                        <x-textarea
                                            wire:model.defer="state.cookie_consent_message"
                                            id="cookieConsentMessageInput"
                                            class="mt-1 block w-full"
                                            rows="3"
                                        />
                                        <x-input-error for="state.cookie_consent_message" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="cookieConsentAgreeInput" :value="__('Agree button text')" />
                                        <x-input
                                            wire:model.defer="state.cookie_consent_agree"
                                            type="text"
                                            id="cookieConsentAgreeInput"
                                            class="mt-1 block w-full"
                                        />
                                        <x-input-error for="state.cookie_consent_agree" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="cookieConsentRejectInput" :value="__('Reject button text')" />
                                        <x-input
                                            wire:model.defer="state.cookie_consent_reject"
                                            type="text"
                                            id="cookieConsentRejectInput"
                                            class="mt-1 block w-full"
                                        />
                                        <x-input-error for="state.cookie_consent_reject" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button
                            type="button"
                            class="text-sm font-semibold leading-6 text-purple-900 dark:text-purple-100"
                        >
                            {{ __('Cancel') }}
                        </button>
                        <button
                            wire:click="save"
                            type="button"
                            class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                        >
                            {{ __('Save changes') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
