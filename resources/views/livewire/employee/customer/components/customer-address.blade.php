<div>
    <x-card>
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h2 class="text-base font-medium text-slate-900 dark:text-slate-100">
                        {{ __('Default address') }}
                    </h2>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <button
                        wire:click.prevent="manageAddresses"
                        type="button"
                        class="btn btn-link  text-purple-600"
                    >
                        {{ __('Manage') }}
                    </button>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            @unless($customer->defaultAddress())
                <div class="text-sm text-slate-500 dark:text-slate-400">
                    {{ __('No default address set.') }}
                </div>
            @else
                <address class="not-italic text-sm">
                    {{ $customer->defaultAddress()->name }}<br>

                    @if($customer->defaultAddress()->company)
                        {{ $customer->defaultAddress()->company }}<br>
                    @endif

                    @if($customer->defaultAddress()->address_line_1)
                        {{ $customer->defaultAddress()->address_line_1 }}<br>
                    @endif

                    @if($customer->defaultAddress()->address_line_2)
                        {{ $customer->defaultAddress()->address_line_2 }}<br>
                    @endif

                    @if($customer->defaultAddress()->city)
                        {{ $customer->defaultAddress()->city }}
                    @endif

                    @if($customer->defaultAddress()->postcode)
                        {{ $customer->defaultAddress()->postcode }}<br>
                    @endif

                    {{ $customer->defaultAddress()->country->name }}
                </address>
            @endunless
            <div class="mt-2">
                <button
                    wire:click.prevent="create"
                    type="button"
                    class="btn btn-link  text-purple-600"
                >
                    {{ __('Add new address') }}
                </button>
            </div>
        </x-slot:content>
    </x-card>

    <x-modal-dialog wire:model.defer="showAddressForm">
        <x-slot:title>
            {{ $this->address->exists ? __('Edit address') : __('Add new address') }}
        </x-slot:title>
        <x-slot:content>
            <fieldset
                wire:target="save"
                wire:loading.attr="disabled"
                class="mt-5 grid grid-cols-6 gap-6"
            >
                <div class="col-span-6">
                    <x-input-label
                        for="country"
                        :value="__('Country/region')"
                    />
                    <x-select
                        wire:model="address.country_id"
                        class="mt-1 block w-full sm:text-sm"
                    >
                        <option value="">{{ __('Please select') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error
                        for="address.country"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 md:col-span-3 lg:col-span-4">
                    <x-input-label
                        for="name"
                        :value="__('Customer name')"
                    />
                    <x-input
                        wire:model.defer="address.name"
                        type="text"
                        id="name"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="address.name"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 lg:col-span-4">
                    <x-input-label
                        for="companyName"
                        :value="__('Company')"
                    />
                    <x-input
                        wire:model.defer="address.company_name"
                        type="text"
                        id="companyName"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="address.company_name"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6">
                    <x-input-label
                        for="addressLine1"
                        :value="__('Address')"
                    />
                    <x-input
                        wire:model.defer="address.address_line_1"
                        type="text"
                        id="addressLine1"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="address.address_line_1"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6">
                    <x-input-label
                        for="addressLine2"
                        :value="__('Apartment, suite, etc.')"
                    />
                    <x-input
                        wire:model.defer="address.address_line_2"
                        type="text"
                        id="addressLine2"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="address.address_line_2"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 md:col-span-2">
                    <x-input-label
                        for="city"
                        :value="__('City')"
                    />
                    <x-input
                        wire:model.defer="address.city"
                        type="text"
                        id="city"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="address.city"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 md:col-span-2">
                    <x-input-label
                        for="state"
                        :value="__('State')"
                    />
                    <x-input
                        wire:model.defer="address.state"
                        type="text"
                        id="state"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="address.state"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 md:col-span-2">
                    <x-input-label
                        for="postcode"
                        :value="__('Zip/Postal code')"
                    />
                    <x-input
                        wire:model.defer="address.postcode"
                        type="text"
                        id="postcode"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="address.postcode"
                        class="mt-2"
                    />
                </div>

                <div
                    x-data="{ open: false }"
                    class="col-span-6"
                >
                    <x-input-label
                        for="phone-number"
                        value="{{ __('Phone number') }}"
                    />
                    <div class="relative mt-1 rounded-md">
                        <div class="absolute inset-y-0 left-0 flex items-center">
                            <div class="relative h-full">
                                <button
                                    x-on:click="open = true"
                                    type="button"
                                    class="relative h-full w-full cursor-default rounded-md border border-transparent pl-3 pr-8 text-left focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500 sm:text-sm"
                                >
                                    <span class="text-2xl">{{ $selectedCountry?->emoji }}</span>
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
            <button
                wire:click.prevent="save"
                wire:target="save"
                wire:loading.attr="disabled"
                type="submit"
                class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full sm:ml-3 sm:w-auto"
            >
                {{ __('Save') }}
            </button>
            <button
                wire:click="$set('showAddressForm', false)"
                wire:target="save"
                wire:loading.attr="disabled"
                type="button"
                class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-dialog>

    <x-modal-dialog wire:model.defer="showAddressesManageModal">
        <x-slot:title>
            {{ __('Manage addresses') }}
        </x-slot:title>
        <x-slot:content>
            <ul class="divide-y divide-slate-200 dark:divide-slate-200/10">
                @foreach($addresses as $customerAddress)
                    <li class="py-4">
                        @if($customerAddress->is_default)
                            <span class="block mb-3 text-xs font-medium text-slate-900 uppercase dark:text-slate-200">
                                {{ __('Default address') }}
                            </span>
                        @endif
                        <address class="not-italic text-sm">
                            {{ $customerAddress->name }}<br>

                            @if($customerAddress->company)
                                {{ $customerAddress->company }}<br>
                            @endif

                            @if($customerAddress->address_line_1)
                                {{ $customerAddress->address_line_1 }}<br>
                            @endif

                            @if($customerAddress->address_line_2)
                                {{ $customerAddress->address_line_2 }}<br>
                            @endif

                            @if($customerAddress->city)
                                {{ $customerAddress->city }}
                            @endif

                            @if($customerAddress->postcode)
                                {{ $customerAddress->postcode }}<br>
                            @endif

                            {{ $customerAddress->country->name }}
                        </address>

                        <div class="mt-3 flex items-center justify-between">
                            <button
                                wire:click.prevent="edit('{{ $customerAddress->id }}')"
                                class="btn btn-link  text-purple-600"
                            >
                                {{ __('Edit address') }}
                            </button>
                            @unless($customerAddress->is_default)
                                <button
                                    wire:target="setDefaultAddress('{{ $customerAddress->id }}')"
                                    wire:loading.attr="disabled"
                                    wire:click.prevent="setDefaultAddress('{{ $customerAddress->id }}')"
                                    class="relative btn btn-default"
                                >
                                    {{ __('Set as default') }}
                                </button>
                            @endunless
                        </div>
                    </li>
                @endforeach
            </ul>
        </x-slot:content>
    </x-modal-dialog>
</div>
