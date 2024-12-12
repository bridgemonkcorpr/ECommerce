<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Meta title & description -->
        <x-slot:title>
            {{ __('Brand settings') }}
        </x-slot:title>

        <!-- Page content -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 xl:flex xl:gap-x-16 xl:px-8">
            @include('layouts.employee-settings-navigation')

            <div class="py-6 lg:flex-auto xl:py-0">
                <div class="space-y-12">
                    <!-- Logos Section -->
                    <div class="pb-12">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                    {{ __('Logos') }}
                                </h2>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('View and update your store logos.') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 space-y-6">
                                <div x-data>
                                    <x-input-label for="logoFileInput" :value="__('Logo')" />
                                    <div class="mt-2 flex items-center gap-x-3">
                                        @if($logo_file)
                                            <img src="{{ $logo_file->temporaryUrl() }}" alt="{{ $generalSettings->store_name }}" class="h-12 w-auto" />
                                        @elseif($this->brandSettings->logo_path)
                                            <img src="{{ Storage::url($this->brandSettings->logo_path) }}" alt="{{ $generalSettings->store_name }}" class="h-12 w-auto" />
                                        @else
                                            <x-application-logo class="h-12 w-auto" />
                                        @endif
                                        <x-input wire:model.defer="logo_file" x-ref="logoFileInput" id="logoFileInput" type="file" class="sr-only" />
                                        <button x-on:click.prevent="$refs.logoFileInput.click()" type="button" class="px-3 py-2 bg-purple-200 text-purple-700 rounded-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            {{ __('Change') }}
                                        </button>
                                    </div>
                                </div>
                                <div x-data>
                                    <x-input-label for="faviconFileInput" :value="__('Favicon')" />
                                    <div class="mt-2 flex items-center gap-x-3">
                                        @if($favicon_file)
                                            <img src="{{ $favicon_file->temporaryUrl() }}" alt="{{ $generalSettings->store_name }}" class="h-12 w-auto" />
                                        @elseif($this->brandSettings->favicon_path)
                                            <img src="{{ Storage::url($this->brandSettings->favicon_path) }}" alt="{{ $generalSettings->store_name }}" class="h-12 w-auto" />
                                        @else
                                            <x-application-logo class="h-12 w-auto" />
                                        @endif
                                        <x-input wire:model.defer="favicon_file" x-ref="faviconFileInput" id="faviconFileInput" type="file" class="sr-only" />
                                        <button x-on:click.prevent="$refs.faviconFileInput.click()" type="button" class="px-3 py-2 bg-purple-200 text-purple-700 rounded-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            {{ __('Change') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slogan Section -->
                    <div class="pb-12">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                    {{ __('Slogan') }}
                                </h2>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('Brand statement or tagline often used along with your logo') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 space-y-6">
                                <div>
                                    <x-input-label for="sloganInput" :value="__('Slogan')" />
                                    <x-input wire:model.defer="state.slogan" type="text" id="sloganInput" class="mt-1 block w-full" />
                                    <x-input-error for="state.slogan" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Short Description Section -->
                    <div class="pb-12">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                    {{ __('Short description') }}
                                </h2>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('Description of your business often used in bios and listings') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 space-y-6">
                                <div>
                                    <x-input-label for="shortDescriptionInput" :value="__('Short description')" />
                                    <x-textarea wire:model.defer="state.short_description" id="shortDescriptionInput" class="mt-1 block w-full" rows="3" />
                                    <x-input-error for="state.short_description" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links Section -->
                    <div class="pb-12">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                    {{ __('Social Links') }}
                                </h2>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('Social links for your business, often used in the theme footer') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 space-y-6">
                                @foreach($state['social_links'] as $link)
                                    <div>
                                        <x-input-label for="{{ $link['name'] }}UrlInput" :value="$link['name']" />
                                        <div class="mt-2 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <x-icon name="simpleicon-{{ strtolower($link['name']) }}" class="h-5 w-5 text-purple-400" />
                                            </div>
                                            <x-input wire:model.defer="state.social_links.{{ $loop->index }}.url" type="text" id="{{ $link['name'] }}UrlInput" class="block w-full pl-10" placeholder="{{ __('Link') }}" />
                                        </div>
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ $link['url_placeholder'] }}
                                        </p>
                                        <x-input-error for="state.social_links.{{ $loop->index }}.url" class="mt-2" />
                                    </div>
                                @endforeach
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
