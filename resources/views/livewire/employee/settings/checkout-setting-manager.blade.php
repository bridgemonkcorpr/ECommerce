<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Meta title & description -->
        <x-slot:title>
            {{ __('Checkout settings') }}
        </x-slot:title>

        <!-- Page content -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 xl:flex xl:gap-x-16 xl:px-8">
            @include('layouts.employee-settings-navigation')

            <form
                wire:submit.prevent="save"
                class="py-6 xl:flex-auto xl:py-0"
            >
                <div class="space-y-12">
                    <div class="bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 space-y-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                {{ __('Checkout') }}
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-purple-500 dark:text-purple-400">
                                {{ __('Customize customer checkout experience.') }}
                            </p>
                            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div
                                    x-data="{ on: @entangle('state.requires_login').defer }"
                                    class="col-span-full"
                                >
                                    <div class="flex items-center">
                                        <button
                                            x-on:click="on = !on"
                                            x-ref="switch"
                                            type="button"
                                            role="switch"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-purple-900"
                                            :class="{ 'bg-purple-600': on, 'bg-purple-200 dark:bg-purple-700': !(on) }"
                                            :aria-checked="on.toString()"
                                        >
                                            <span
                                                aria-hidden="true"
                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"
                                            ></span>
                                        </button>
                                        <x-input-label
                                            x-on:click="on = !on; $refs.switch.focus()"
                                            :value="__('Require the customer to log in to their account before checkout')"
                                            class="ml-3"
                                        />
                                    </div>
                                    <x-input-error
                                        for="state.requires_login"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button
                        type="button"
                        class="text-sm font-semibold leading-6 text-purple-900 dark:text-purple-100"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                    >
                        {{ __('Save changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
