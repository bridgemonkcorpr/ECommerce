<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Meta title & description -->
        <x-slot:title>
            {{ __('Users') }} - {{ $employee->name }}
        </x-slot:title>

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Store profile') }}
            </h1>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 xl:flex xl:gap-x-16">
                @include('layouts.employee-settings-navigation')

                <form wire:submit.prevent="save" class="xl:flex-auto" @disabled(!auth()->user()->is_admin)>
                    <div class="space-y-6">
                        <p class="text-sm text-purple-500 dark:text-purple-400">
                            {{ __('Manage :employeeName profile.', ['employeeName' => $employee->name]) }}
                        </p>

                        <div>
                            <x-input-label for="userNameInput" :value="__('Full name')" />
                            <x-input wire:model.defer="state.name" type="text" id="userNameInput" class="mt-1 block w-full" />
                            <x-input-error for="state.name" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="userEmailInput" :value="__('Email address')" />
                            <x-input wire:model.defer="state.email" type="email" id="userEmailInput" class="mt-1 block w-full" />
                            <x-input-error for="state.email" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="userPasswordInput" :value="__('Password (optional)')" />
                            <x-input wire:model.defer="state.password" type="password" id="userPasswordInput" class="mt-1 block w-full" />
                            <x-input-error for="state.password" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="userWebsiteInput" :value="__('Website (optional)')" />
                            <x-input wire:model.defer="state.website" type="text" id="userWebsiteInput" class="mt-1 block w-full" />
                            <x-input-error for="state.website" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="userBioInput" :value="__('Bio (optional)')" />
                            <x-textarea wire:model.defer="state.bio" id="userBioInput" class="mt-1 block w-full" rows="3" />
                            <x-input-error for="state.bio" class="mt-2" />
                        </div>

                        @if(auth()->user()->is_admin && auth()->user()->id !== $employee->id)
                            <div class="border-t border-purple-200 pt-6 dark:border-purple-700">
                                <h2 class="text-lg font-semibold text-purple-900 dark:text-purple-100">
                                    {{ __('Manage staff access') }}
                                </h2>
                                <div class="mt-4 space-y-4">
                                    @if($employee->isBanned())
                                        <div>
                                            <h3 class="text-sm font-medium text-purple-900 dark:text-purple-100">{{ __('Restore access') }}</h3>
                                            <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                                {{ __('This staff member\'s access is currently suspended.') }}
                                            </p>
                                            <button wire:click.prevent="restoreAccess" wire:loading.attr="disabled"
                                                    class="mt-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75 transition-all duration-300">
                                                {{ __('Restore access') }}
                                            </button>
                                        </div>
                                    @else
                                        <div>
                                            <h3 class="text-sm font-medium text-purple-900 dark:text-purple-100">{{ __('Suspend access') }}</h3>
                                            <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                                {{ __('This account will no longer have access to your store. You can restore access at any time.') }}
                                            </p>
                                            <button wire:click.prevent="confirmAccessSuspension" wire:loading.attr="disabled"
                                                    class="mt-2 px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-75 transition-all duration-300">
                                                {{ __('Suspend access') }}
                                            </button>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                            {{ __('Remove :employeeName', ['employeeName' => $employee->name]) }}
                                        </h3>
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ __('Removed staff members will be permanently removed from your store. This action cannot be reversed.') }}
                                        </p>
                                        <button wire:click.prevent="confirmEmployeeRemoval"
                                                class="mt-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition-all duration-300">
                                            {{ __('Remove :employeeName', ['employeeName' => $employee->name]) }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-end gap-x-6 pt-6">
                            <a href="{{ route('employee.settings.user.list') }}"
                               class="px-4 py-2 bg-purple-200 text-purple-800 font-semibold rounded-lg shadow-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-75 transition-all duration-300">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                                {{ __('Save changes') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <x-modal-alert wire:model="confirmingAccessSuspension">
        <x-slot:title>
            {{ __('Suspend :employeeName\'s account access', ['employeeName' => $employee->name]) }}
        </x-slot:title>
        <x-slot:content>
            <p class="text-sm text-purple-500">
                {{ __('Are you sure you want to suspend :employeeName\'s access to your store?', ['employeeName' => $employee->name]) }}
            </p>
        </x-slot:content>
        <x-slot:footer>
            <button wire:click="suspendAccess"
                    class="px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-75 transition-all duration-300">
                {{ __('Suspend') }}
            </button>
            <button x-on:click="show = false"
                    class="ml-3 px-4 py-2 bg-purple-200 text-purple-800 font-semibold rounded-lg shadow-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-75 transition-all duration-300">
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <x-modal-alert wire:model="confirmingEmployeeRemoval">
        <x-slot:title>
            {{ __('Remove :employeeName', ['employeeName' => $employee->name]) }}
        </x-slot:title>
        <x-slot:content>
            <p class="text-sm text-purple-500">
                {{ __('Are you sure you want to remove :employeeName from your store? This action cannot be reversed.', ['employeeName' => $employee->name]) }}
            </p>
        </x-slot:content>
        <x-slot:footer>
            <button wire:click="removeEmployee"
                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition-all duration-300">
                {{ __('Remove') }}
            </button>
            <button x-on:click="show = false"
                    class="ml-3 px-4 py-2 bg-purple-200 text-purple-800 font-semibold rounded-lg shadow-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-75 transition-all duration-300">
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>
</div>
