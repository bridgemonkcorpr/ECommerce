<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center mb-8">

              <a  href="{{ route('employee.customers.list') }}"
                class="mr-4 bg-white dark:bg-purple-800 p-2 rounded-full shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 transition-colors duration-200"
            >
                <x-heroicon-m-arrow-left class="w-6 h-6 text-purple-600 dark:text-purple-300" />
            </a>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('New customer') }}
            </h1>
        </div>

        <!-- Content -->
        <form wire:submit.prevent="save" class="space-y-8">
            <!-- Customer Overview -->
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-purple-900 dark:text-purple-200">
                                {{ __('Customer overview') }}
                            </h3>
                            <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                {{ __('Personal information about the customer') }}
                            </p>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-5">
                                    <x-input-label for="full-name" :value="__('Full name')" />
                                    <x-input wire:model.defer="customer.name" type="text" id="full-name" class="mt-1 block w-full" />
                                    <x-input-error for="customer.name" class="mt-2" />
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <x-input-label for="email-address" :value="__('Email address')" />
                                    <x-input wire:model.defer="customer.email" type="text" id="email-address" class="mt-1 block w-full" />
                                    <x-input-error for="customer.email" class="mt-2" />
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-input wire:model.defer="customer_password" type="password" id="password" class="mt-1 block w-full" />
                                    <x-input-error for="customer_password" class="mt-2" />
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <x-input-label for="password-confirmation" :value="__('Confirm password')" />
                                    <x-input wire:model.defer="customer_password_confirmation" type="password" id="password-confirmation" class="mt-1 block w-full" />
                                    <x-input-error for="customer_password_confirmation" class="mt-2" />
                                </div>
                                <div x-data="{ open: false }" class="col-span-6">
                                    <x-input-label for="phone-number" :value="__('Phone number')" />
                                    <div class="relative mt-1 rounded-md">
                                        <div class="absolute inset-y-0 left-0 flex items-center">
                                            <button x-on:click="open = true" type="button" class="relative h-full w-full cursor-default rounded-md border border-transparent pl-3 pr-8 text-left focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500 sm:text-sm">
                                                <span class="text-2xl">{{ $customer_country->emoji }}</span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                                    <x-heroicon-m-chevron-up-down class="h-5 w-5 text-purple-400" />
                                                </span>
                                            </button>
                                            <ul x-show="open" x-on:click.away="open = false" class="absolute bottom-full z-10 mb-1.5 max-h-56 overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm dark:bg-purple-700">
                                                @foreach($countries as $country)
                                                    <li x-on:click="$wire.selectCustomerCountry('{{ $country->iso2 }}'); open = false;" class="relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-purple-100 dark:hover:bg-purple-600">
                                                        <div class="flex items-center">
                                                            <span class="text-2xl">{{ $country->emoji }}</span>
                                                            <span class="font-normal ml-3 block truncate">{{ $country->name }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <x-input wire:model.defer="customer_phone" type="text" id="phone-number" class="block w-full pl-[4.5rem]" />
                                    </div>
                                    <x-input-error for="customer_phone" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-purple-900 dark:text-purple-200">
                                {{ __('Address') }}
                            </h3>
                            <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                {{ __('The primary address of this customer') }}
                            </p>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <x-input-label for="country" :value="__('Country/region')" />
                                    <x-select wire:model="address.country_id" class="mt-1 block w-full">
                                        <option value="">{{ __('Please select') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error for="address.country" class="mt-2" />
                                </div>

                                <div class="col-span-6 md:col-span-5">
                                    <x-input-label for="address-name" :value="__('Full name')" />
                                    <x-input wire:model.defer="address.name" type="text" id="address-name" class="mt-1 block w-full" />
                                    <x-input-error for="address.name" class="mt-2" />
                                </div>

                                <div class="col-span-6 md:col-span-4">
                                    <x-input-label for="companyName" :value="__('Company')" />
                                    <x-input wire:model.defer="address.company_name" type="text" id="companyName" class="mt-1 block w-full" />
                                    <x-input-error for="address.company_name" class="mt-2" />
                                </div>

                                <div class="col-span-6">
                                    <x-input-label for="addressLine1" :value="__('Address')" />
                                    <x-input wire:model.defer="address.address_line_1" type="text" id="addressLine1" class="mt-1 block w-full" />
                                    <x-input-error for="address.address_line_1" class="mt-2" />
                                </div>

                                <div class="col-span-6">
                                    <x-input-label for="addressLine2" :value="__('Apartment, suite, etc.')" />
                                    <x-input wire:model.defer="address.address_line_2" type="text" id="addressLine2" class="mt-1 block w-full" />
                                    <x-input-error for="address.address_line_2" class="mt-2" />
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-input wire:model.defer="address.city" type="text" id="city" class="mt-1 block w-full" />
                                    <x-input-error for="address.city" class="mt-2" />
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    <x-input-label for="state" :value="__('State')" />
                                    <x-input wire:model.defer="address.state" type="text" id="state" class="mt-1 block w-full" />
                                    <x-input-error for="address.state" class="mt-2" />
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    <x-input-label for="postcode" :value="__('Zip/Postal code')" />
                                    <x-input wire:model.defer="address.postcode" type="text" id="postcode" class="mt-1 block w-full" />
                                    <x-input-error for="address.postcode" class="mt-2" />
                                </div>

                                <div x-data="{ open: false }" class="col-span-6">
                                    <x-input-label for="address-phone-number" :value="__('Phone number')" />
                                    <div class="relative mt-1 rounded-md">
                                        <div class="absolute inset-y-0 left-0 flex items-center">
                                            <button x-on:click="open = true" type="button" class="relative h-full w-full cursor-default rounded-md border border-transparent pl-3 pr-8 text-left focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500 sm:text-sm">
                                                <span class="text-2xl">{{ $address_country->emoji }}</span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                                    <x-heroicon-m-chevron-up-down class="h-5 w-5 text-purple-400" />
                                                </span>
                                            </button>
                                            <ul x-show="open" x-on:click.away="open = false" class="absolute bottom-full z-10 mb-1.5 max-h-56 overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm dark:bg-purple-700">
                                                @foreach($countries as $country)
                                                    <li x-on:click="$wire.selectAddressCountry('{{ $country->iso2 }}'); open = false;" class="relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-purple-100 dark:hover:bg-purple-600">
                                                        <div class="flex items-center">
                                                            <span class="text-2xl">{{ $country->emoji }}</span>
                                                            <span class="font-normal ml-3 block truncate">{{ $country->name }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <x-input wire:model.defer="address_phone" type="text" id="address-phone-number" class="block w-full pl-[4.5rem]" />
                                    </div>
                                    <x-input-error for="address_phone" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-purple-900 dark:text-purple-200">
                                {{ __('Notes') }}
                            </h3>
                            <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                {{ __('Add notes about your customer') }}
                            </p>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <x-input-label for="notes" :value="__('Note')" />
                                    <x-textarea wire:model.defer="customer.notes" id="notes" class="mt-1 block w-full" />
                                    <x-input-error for="customer.notes" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">

              <a  href="{{ route('employee.customers.list') }}"
                class="px-4 py-2 bg-purple-200 text-purple-700 font-semibold rounded-lg shadow-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-75 transition-all duration-300 dark:bg-purple-700 dark:text-purple-300 dark:hover:bg-purple-600"
            >
                {{ __('Cancel') }}
            </a>
            <button
                type="submit"
                class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
            >
                {{ __('Save') }}
            </button>
        </div>
    </form>
</div>
</div>
