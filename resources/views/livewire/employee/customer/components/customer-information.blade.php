<div>
    <x-card>
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h2 class="text-lg leading-6 font-medium text-slate-900 dark:text-slate-100">
                        {{ __('Customer') }}
                    </h2>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <button
                        wire:click.prevent="edit"
                        type="button"
                        class="btn btn-link  text-purple-600"
                    >
                        {{ __('Edit') }}
                    </button>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            <ul
                x-data
                class="space-y-2 sm:text-sm"
            >
                <li class="flex items-between">
                    <a
                        href="mailto:{{ $customer->email }}"
                        class="btn btn-link  text-purple-600 block w-full !justify-start"
                    >
                        {{ $customer->email }}
                    </a>
                    <button
                        x-on:click="$clipboard('{{ $customer->email }}').then(() => $dispatch('notify', '{{ __('Copied to clipboard') }}'))"
                        type="button"
                        data-tippy-content="{{ __('Copy to clipboard') }}"
                    >
                        <x-heroicon-m-clipboard class="w-5 h-5 text-slate-500 hover:text-slate-600 dark:hover:text-slate-400" />
                    </button>
                </li>
                @if($customer->phone)
                    <li>{{ $customer->phone->formatInternational() }}</li>
                @endif
            </ul>
        </x-slot:content>
    </x-card>

    <form wire:submit.prevent="save">
        <x-modal-dialog
            wire:model.defer="isEditing"
            max-width="xl"
        >
            <x-slot:title>
                {{ __('Edit customer') }}
            </x-slot:title>
            <x-slot:content>
                <fieldset
                    wire:target="save"
                    wire:loading.attr="disabled"
                    class="space-y-6"
                >
                    <div>
                        <x-input-label
                            for="name"
                            :value="__('Name')"
                        />
                        <x-input
                            wire:model.defer="customer.name"
                            id="name"
                            type="text"
                            class="block w-full mt-1 sm:text-sm"
                            required
                        />
                        <x-input-error
                            for="customer.name"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="email"
                            :value="__('Email')"
                        />
                        <x-input
                            wire:model.defer="customer.email"
                            id="email"
                            type="email"
                            class="block w-full mt-1 sm:text-sm"
                            required
                        />
                        <x-input-error
                            for="customer.email"
                            class="mt-2"
                        />
                    </div>
                    <div x-data="{ open: false }">
                        <x-input-label
                            for="phone-number"
                            value="{{ __('Phone number') }}"
                        />
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center">
                                <div class="relative h-full">
                                    <button
                                        x-on:click="open = true"
                                        type="button"
                                        class="relative h-full w-full cursor-default rounded-md border border-transparent pl-3 pr-8 text-left focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500 sm:text-sm"
                                    >
                                        <span class="text-2xl">{{ $country->emoji }}</span>
                                        <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                            <x-heroicon-m-chevron-up-down class="h-5 w-5 text-slate-400" />
                                        </span>
                                    </button>
                                    <ul
                                        x-show="open"
                                        x-on:click.away="open = false"
                                        class="absolute bottom-full z-10 mb-1.5 max-h-56 overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm dark:bg-slate-900"
                                    >
                                        @foreach($countries as $country)
                                            <li
                                                x-on:click="$wire.selectCountry('{{ $country->iso2 }}'); open = false;"
                                                class="text-purple-900 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-purple-500 hover:text-white dark:text-slate-200"
                                            >
                                                <div class="flex items-center">
                                                    <span class="text-2xl">{{ $country->emoji }}</span>
                                                    <span class="font-normal ml-3 block truncate">{{ $country->name }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-input
                                wire:model.defer="phone"
                                type="text"
                                id="phone-number"
                                class="block w-full pl-[4.5rem] sm:text-sm"
                            />
                        </div>
                        <x-input-error
                            for="phone"
                            class="mt-2"
                        />
                    </div>
                </fieldset>
            </x-slot:content>
            <x-slot:footer>
                <div class="flex justify-end">
                    <button
                        wire:click="$set('isEditing', false)"
                        wire:target="save"
                        wire:loading.attr="disabled"
                        type="button"
                        class="btn btn-invisible text-purple-600"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        wire:target="save"
                        wire:loading.attr="disabled"
                        type="submit"
                        class="btn btn-primary bg-purple-600 hover:bg-purple-700 ml-2"
                    >
                        {{ __('Save') }}
                    </button>
                </div>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
