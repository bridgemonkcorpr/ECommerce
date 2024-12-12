<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Meta title & description -->
        <x-slot:title>
            {{ __('Users') }} - {{ $state['is_admin'] ? __('Add admin') : __('Add staff') }}
        </x-slot:title>

        <!-- Page content -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 xl:flex xl:gap-x-16 xl:px-8">
            @include('layouts.employee-settings-navigation')

            <div class="py-6 lg:flex-auto xl:py-0">
                <div class="space-y-12">
                    <!-- Add User Section -->
                    <div class="pb-12">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                    {{ $state['is_admin'] ? __('Add admin') : __('Add staff') }}
                                </h2>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('Enter the details of the new user.') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                            <form wire:submit.prevent="save" class="p-6 space-y-6">
                                <div>
                                    <x-input-label for="userNameInput" :value="__('Full name')" />
                                    <x-input
                                        wire:model.defer="state.name"
                                        type="text"
                                        id="userNameInput"
                                        class="mt-1 block w-full"
                                    />
                                    <x-input-error for="state.name" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="userEmailInput" :value="__('Email address')" />
                                    <x-input
                                        wire:model.defer="state.email"
                                        type="email"
                                        id="userEmailInput"
                                        class="mt-1 block w-full"
                                    />
                                    <x-input-error for="state.email" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="userPasswordInput" :value="__('Password')" />
                                    <x-input
                                        wire:model.defer="state.password"
                                        type="password"
                                        id="userPasswordInput"
                                        class="mt-1 block w-full"
                                    />
                                    <x-input-error for="state.password" class="mt-2" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end gap-x-6">

                    <a    href="{{ route('employee.settings.user.list') }}"
                        class="text-sm font-semibold leading-6 text-purple-900 dark:text-purple-100"
                    >
                        {{ __('Cancel') }}
                    </a>
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
