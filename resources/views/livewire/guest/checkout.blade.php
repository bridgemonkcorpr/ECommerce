<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="sr-only">{{ __('Checkout') }}</h1>

        <form wire:submit.prevent="placeOrder" class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <div>
                <!-- Contact information -->
                @guest
                    <div class="mb-10 pb-10 border-b border-gradient-to-r from-purple-200 to-pink-200 dark:from-purple-800 dark:to-pink-800">
                        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                            {{ __('Contact information') }}
                        </h2>

                        <div class="mt-4">
                            <x-input-label for="contact-email" class="block text-sm font-medium text-slate-700 dark:text-slate-300" :value="__('Email address')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="order.customer_email" type="email" id="contact-email" name="contact-email" autocomplete="email" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="order.customer_email" class="mt-2" />
                        </div>
                        <div class="mt-1">
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                {{ __('Already have an account?') }}
                                <a href="{{ route('login') }}" class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700">
                                    {{ __('Sign in') }}
                                </a>
                            </p>
                        </div>
                    </div>
                @endguest

                <!-- Shipping address -->
                <div>
                    <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                        {{ __('Shipping information') }}
                    </h2>

                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <x-input-label for="shipping-name" :value="__('Your name')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shippingAddress.name" type="text" id="shipping-name" name="shipping-name" autocomplete="given-name" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shippingAddress.name" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="shipping-company" :value="__('Company (optional)')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shippingAddress.company_name" type="text" name="shipping-company" id="shipping-company" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shippingAddress.company_name" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="shipping-address-line-1" :value="__('Address')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shippingAddress.address_line_1" type="text" name="shipping-address-line-1" id="shipping-address-line-1" autocomplete="street-address" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shippingAddress.address_line_1" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="shipping-address-line-2" :value="__('Apartment, suite, etc.')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shippingAddress.address_line_2" type="text" name="shipping-address-line-2" id="shipping-address-line-2" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shippingAddress.address_line_2" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="shipping-city" :value="__('City')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shippingAddress.city" type="text" name="shipping-city" id="shipping-city" autocomplete="address-level2" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shippingAddress.city" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="shipping-country" class="block text-sm font-medium text-slate-700 dark:text-slate-300" :value="__('Country')" />
                            <div class="mt-1">
                                <x-select wire:model.defer="shippingAddress.country_id" wire:change.prevent="updateShippingCountry($event.target.value)" id="shipping-country" name="shipping-country" autocomplete="country-name" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300">
                                    <option value="">Please select</option>
                                    @foreach($this->availableShippingCountries as $country)
                                        <option value="{{ $country->country->id }}">
                                            {{ $country->country->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="shipping-region" :value="__('State / Province')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shippingAddress.state" type="text" name="shipping-region" id="shipping-region" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shippingAddress.state" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="shipping-postal-code" :value="__('ZIP / Postal code')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shippingAddress.postcode" type="text" name="shipping-postal-code" id="shipping-postal-code" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shippingAddress.postcode" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="shipping-phone" :value="__('Phone')" />
                            <div class="mt-1">
                                <x-input wire:model.defer="shipping_phone" type="text" name="shipping-phone" id="shipping-phone" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                            </div>
                            <x-input-error for="shipping_phone" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Delivery method -->
                <div class="mt-10 border-t border-gradient-to-r from-purple-200 to-pink-200 pt-10 dark:from-purple-800 dark:to-pink-800">
                    <fieldset>
                        <legend class="text-lg font-medium text-slate-900 dark:text-slate-100">{{ __('Delivery method') }}</legend>

                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            @foreach($this->availableShippingRates as $shippingRate)
                                <label @class(['relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none dark:bg-purple-800', 'border-gradient-to-r from-purple-400 to-pink-400 ring-2 ring-purple-500' => $shippingRate->id == $shippingMethod, 'border-gradient-to-r from-purple-200 to-pink-200' => $shippingRate->id != $shippingMethod])>
                                    <input wire:model="shippingMethod" type="radio" name="delivery-method" value="{{ $shippingRate->id }}" class="sr-only" aria-labelledby="delivery-method-{{ $shippingRate->id }}-label" aria-describedby="delivery-method-{{ $shippingRate->id }}-description-0 delivery-method-{{ $shippingRate->id }}-description-1">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span id="delivery-method-{{ $shippingRate->id }}-label" class="block text-sm font-medium text-slate-900 dark:text-slate-100">
                                                {{ $shippingRate->name }}
                                            </span>
                                            <span id="delivery-method-{{ $shippingRate->id }}-description-0" class="mt-1 flex items-center text-sm text-slate-500 dark:text-slate-400">
                                                {{ $shippingRate->description }}
                                            </span>
                                            <span id="delivery-method-{{ $shippingRate->id }}-description-1" class="mt-6 text-sm font-medium text-slate-900 dark:text-slate-100">
                                                <x-money :amount="$shippingRate->price" :currency="$this->cart->currency" />
                                            </span>
                                        </span>
                                    </span>
                                    <x-heroicon-m-check-circle @class(['h-5 w-5 text-purple-600', 'hidden' => $shippingRate->id != $shippingMethod]) aria-hidden="true" />
                                </label>
                            @endforeach
                        </div>

                        <x-input-error for="shippingMethod" class="mt-2" />
                    </fieldset>
                </div>

                <!-- Billing address -->
                <div class="mt-10 border-t border-gradient-to-r from-purple-200 to-pink-200 pt-10 dark:from-purple-800 dark:to-pink-800">
                    <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                        {{ __('Billing information') }}
                    </h2>

                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <div class="flex space-x-2">
                                <div class="flex h-5 items-center">
                                    <x-input wire:model.lazy="isBillingSameAsShipping" type="checkbox" id="same-as-shipping" name="same-as-shipping" class="!rounded !shadow-none border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700" />
                                </div>
                                <x-input-label for="same-as-shipping" :value="__('Billing address is the same as shipping address')" class="text-slate-700 dark:text-slate-300" />
                            </div>
                        </div>

                        @unless($isBillingSameAsShipping)
                            <div class="sm:col-span-2">
                                <x-input-label for="billing-name" :value="__('Your name')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billingAddress.name" type="text" id="billing-name" name="billing-name" autocomplete="given-name" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billingAddress.name" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="billing-company" :value="__('Company (optional)')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billingAddress.company_name" type="text" name="billing-company" id="billing-company" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billingAddress.company_name" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="billing-address-line-1" :value="__('Address')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billingAddress.address_line_1" type="text" name="billing-address-line-1" id="billing-address-line-1" autocomplete="street-address" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billingAddress.address_line_1" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="billing-address-line-2" :value="__('Apartment, suite, etc.')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billingAddress.address_line_2" type="text" name="billing-address-line-2" id="billing-address-line-2" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billingAddress.address_line_2" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="billing-city" :value="__('City')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billingAddress.city" type="text" name="billing-city" id="billing-city" autocomplete="address-level2" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billingAddress.city" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="billing-country" class="block text-sm font-medium text-slate-700 dark:text-slate-300" :value="__('Country')" />
                                <div class="mt-1">
                                    <x-select wire:model.defer="billingAddress.country_id" wire:change.prevent="updateBillingCountry($event.target.value)" id="billing-country" name="billing-country" autocomplete="country-name" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300">
                                        <option value="">Please select</option>
                                        @foreach($this->availableShippingCountries as $country)
                                            <option value="{{ $country->country->id }}">
                                                {{ $country->country->name }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="billing-region" :value="__('State / Province')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billingAddress.state" type="text" name="billing-region" id="billing-region" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billingAddress.state" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="billing-postal-code" :value="__('ZIP / Postal code')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billingAddress.postcode" type="text" name="billing-postal-code" id="billing-postal-code" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billingAddress.postcode" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="billing-phone" :value="__('Phone')" />
                                <div class="mt-1">
                                    <x-input wire:model.defer="billing_phone" type="text" name="billing-phone" id="billing-phone" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" />
                                </div>
                                <x-input-error for="billing_phone" class="mt-2" />
                            </div>
                        @endunless
                    </div>
                </div>

                <!-- Payment -->
                <div class="mt-10 border-t border-gradient-to-r from-purple-200 to-pink-200 pt-10 dark:from-purple-800 dark:to-pink-800">
                    <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                        {{ __('Payment') }}
                    </h2>

                    <fieldset class="mt-4">
                        <legend class="sr-only">{{ __('Payment type') }}</legend>

                        <div x-data="{ paymentMethod: @entangle('paymentMethod').defer }" class="space-y-4">
                            @foreach($this->availablePaymentProviders as $paymentProvider)
                                <label class="relative block cursor-pointer rounded-lg border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between dark:bg-purple-800" :class="{'border-gradient-to-r from-purple-400 to-pink-400 ring-2 ring-purple-500': paymentMethod === '{{ $paymentProvider->identifier }}', 'border-gradient-to-r from-purple-200 to-pink-200': paymentMethod !== '{{ $paymentProvider->identifier }}'}">
                                    <input x-model="paymentMethod" id="{{ $paymentProvider->identifier }}" type="radio" name="payment-method" value="{{ $paymentProvider->identifier }}" class="sr-only">
                                    <span class="flex items-center">
                                        <span class="flex flex-col text-sm">
                                            <span class="font-medium text-slate-900 dark:text-slate-100">
                                                {{ $paymentProvider->display_name }}
                                            </span>
                                            <span class="text-slate-500 dark:text-slate-400">
                                                <span class="block sm:inline">
                                                    {{ $paymentProvider->description }}
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <x-input-error for="paymentMethod" class="mt-2" />
                    </fieldset>
                </div>

                <!-- Notes -->
                <div class="mt-10 border-t border-gradient-to-r from-purple-200 to-pink-200 pt-10 dark:from-purple-800 dark:to-pink-800">
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <x-input-label for="notes" :value="__('Order notes (optional)')" />
                            <div class="mt-1">
                                <x-textarea wire:model.defer="order.notes" name="notes" id="notes" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" :placeholder="__('Notes about your order, e.g. special notes for delivery.')" />
                            </div>
                            <x-input-error for="order.notes" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order summary -->
            <div class="mt-10 lg:mt-0">
                <div class="sticky top-4">
                    <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">{{ __('Order summary') }}</h2>

                    <div class="mt-4 rounded-lg border border-gradient-to-r from-purple-200 to-pink-200 bg-white shadow-sm dark:bg-purple-800 dark:border-gradient-to-r dark:from-purple-800 dark:to-pink-800">
                        <h3 class="sr-only">{{ __('Items in your cart') }}</h3>

                        <ul role="list" class="divide-y divide-gradient-to-r from-purple-200 to-pink-200 text-sm text-slate-900 dark:divide-gradient-to-r dark:from-purple-800 dark:to-pink-800 dark:text-slate-100">
                            @foreach($cartItems as $index => $item)
                                <li class="flex items-center space-x-4 px-4 py-6 sm:px-6">
                                    <div class="relative flex flex-shrink-0 border border-gradient-to-r from-purple-200 to-pink-200 rounded-md dark:border-gradient-to-r dark:from-purple-800 dark:to-pink-800">
                                        @if($item->variant->hasMedia('image'))
                                            {{ $item->variant->getFirstMedia('image')('thumb_large')->attributes(['alt' => $item->product->name, 'class' => 'h-20 w-20 rounded-md']) }}
                                        @elseif($item->product->hasMedia('gallery'))
                                            {{ $item->product->getFirstMedia('gallery')('thumb_large')->attributes(['alt' => $item->product->name, 'class' => 'h-20 w-20 rounded-md']) }}
                                        @else
                                            <div class="relative h-20 w-20 rounded-md bg-slate-100 dark:bg-slate-700">
                                                <x-heroicon-o-camera class="h-full w-12 absolute inset-0 mx-auto text-slate-400 sm:w-16 dark:text-slate-500" />
                                            </div>
                                        @endif
                                        <span class="absolute -top-3 -right-2 whitespace-nowrap rounded-full bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-2 py-0.5 text-center text-xs font-medium leading-5 text-white ring-1 ring-inset ring-purple-600 tabular-nums">{{ $item->quantity }}</span>
                                    </div>
                                    <div class="ml-6 flex-auto space-y-1">
                                        <h4 class="line-clamp-2">
                                            <a href="{{ route('guest.products.detail', $item->product) }}" class="font-medium text-slate-700 hover:text-slate-800 dark:text-slate-300 dark:hover:text-slate-200">
                                                {{ $item->product->name }}
                                            </a>
                                        </h4>
                                        @if($item->variant->variantAttributes->count())
                                            <ul class="space-x-2 divide-x divide-gradient-to-r from-purple-200 to-pink-200 text-sm text-slate-500 dark:divide-gradient-to-r dark:from-purple-800 dark:to-pink-800 dark:text-slate-400">
                                                @foreach($item->variant->variantAttributes as $attribute)
                                                    <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if($item->discount)
                                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                                <x-heroicon-o-tag class="inline-block w-4 h-4" />
                                                {{ $item->discount->code }}
                                                <x-money :amount="-$item->discountedAmount" :currency="config('app.currency')" />
                                            </p>
                                        @endif
                                    </div>
                                    <p class="font-medium flex flex-col text-right space-y-1">
                                        @if($item->discount)
                                            <span class="line-through text-slate-500 text-xs dark:text-slate-400">
                                                <x-money :amount="$item->subtotal" :currency="config('app.currency')" />
                                            </span>
                                            <span>
                                                <x-money :amount="$item->discountedPrice" :currency="config('app.currency')" />
                                            </span>
                                        @else
                                            <x-money :amount="$item->subtotal" :currency="config('app.currency')" />
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>

                        <dl class="space-y-6 border-t border-gradient-to-r from-purple-200 to-pink-200 py-6 px-4 sm:px-6 dark:border-gradient-to-r dark:from-purple-800 dark:to-pink-800">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-slate-600 dark:text-slate-400">{{ __('Subtotal') }}</dt>
                                <dd class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                    <x-money :amount="$cart->subtotal" :currency="config('app.currency')" />
                                </dd>
                            </div>
                            <div x-data="{ showDiscountForm: @entangle('showDiscountForm') }">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-slate-600 dark:text-slate-400">
                                        {{ __('Discount') }}
                                        <button x-on:click="showDiscountForm = !showDiscountForm" type="button" class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 underline">
                                            {{ __('Apply discount code') }}
                                        </button>
                                    </dt>
                                    <dd class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                        <x-money :amount="$discountTotal" :currency="config('app.currency')" />
                                    </dd>
                                </div>
                                <div class="mt-1">
                                    @foreach($cart->discounts->unique('code') as $discount)
                                        <x-badge>
                                            {{ $discount->code }}
                                            <button wire:click.prevent="removeDiscount('{{ $discount->code }}')" type="button" class="ml-0.5 -mr-2 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-500 focus:bg-slate-500 focus:text-white focus:outline-none dark:text-slate-500 dark:hover:bg-slate-700 dark:hover:text-slate-400 dark:focus:bg-slate-400 dark:focus:text-slate-900">
                                                <span class="sr-only">{{ __('Remove discount') }}</span>
                                                <x-heroicon-m-x-mark class="h-4 w-4" />
                                            </button>
                                        </x-badge>
                                    @endforeach

                                    <div x-cloak x-show="showDiscountForm" x-trap="showDiscountForm">
                                        <x-input-label for="discount" class="sr-only" :value="__('Discount code')" />
                                        <div class="mt-2 flex space-x-4">
                                            <x-input x-on:keydown.enter.prevent="$wire.applyDiscount" wire:model.defer="discountCode" type="text" name="discount" id="discount" class="block w-full sm:text-sm border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700 dark:bg-purple-800 dark:text-purple-300" placeholder="{{ __('Discount code') }}" />
                                            <button wire:click.prevent="applyDiscount" type="button" class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                                                {{ __('Apply') }}
                                            </button>
                                        </div>
                                        <x-input-error for="discountCode" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-slate-600 dark:text-slate-400">{{ __('Shipping') }}</dt>
                                <dd class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                    <x-money :amount="$order->shipping_price" :currency="config('app.currency')" />
                                </dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-slate-600 dark:text-slate-400">{{ __('Taxes') }}</dt>
                                <dd class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                    <x-money :amount="$this->totalTaxesApplied" :currency="config('app.currency')" />
                                </dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gradient-to-r from-purple-200 to-pink-200 pt-6 dark:border-gradient-to-r dark:from-purple-800 dark:to-pink-800">
                                <dt class="text-base font-medium text-slate-900 dark:text-slate-100">{{ __('Total') }}</dt>
                                <dd class="text-base font-medium text-slate-900 dark:text-slate-100">
                                    <x-money :amount="$cart->subtotal - $discountTotal + $order->shipping_price + $this->totalTaxesApplied" :currency="config('app.currency')" />
                                </dd>
                            </div>
                        </dl>

                        <div class="border-t border-gradient-to-r from-purple-200 to-pink-200 py-6 px-4 sm:px-6 dark:border-gradient-to-r dark:from-purple-800 dark:to-pink-800">
                            @if($errors->any())
                                <x-alert type="error" class="mb-4" :message="__('There was an error processing your order. Please verify your information and try again.')" />
                            @endif

                            <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                                {{ __('Confirm order') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
