<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Meta title & description -->
        <x-slot:title>
            {{ __('Payments') }}
        </x-slot:title>

        <!-- Page content -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:flex lg:gap-x-16 lg:px-8">
            @include('layouts.employee-settings-navigation')

            <form wire:submit.prevent="save" class="py-6 lg:flex-auto lg:py-0">
                <div class="space-y-12">
                    <!-- Stripe Payment Section -->
                    <div class="bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 space-y-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                {{ $stripe_payment->name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div x-data="{ on: @entangle('stripe_payment_state.is_enabled').defer }" class="col-span-full">
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
                                        <x-input-label x-on:click="on = !on; $refs.switch.focus()" :value="__('Enable')" class="ml-3" />
                                    </div>
                                    <x-input-error for="stripe_payment_state.is_enabled" class="mt-2" />
                                </div>
                                <div class="sm:col-span-3">
                                    <x-input-label for="stripeDisplayNameInput" :value="__('Display name')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="stripe_payment_state.display_name"
                                            type="text"
                                            id="stripeDisplayNameInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <x-input-error for="stripe_payment_state.display_name" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="stripePaymentDescriptionInput" :value="__('Additional details')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="stripe_payment_state.description"
                                            id="stripePaymentDescriptionInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ __('Displays to customers when they are choosing a payment method.') }}
                                        </p>
                                        <x-input-error for="stripe_payment_state.description" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="stripePaymentPublicKeyInput" :value="__('Public key')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="stripe_payment_state.meta.public_key"
                                            id="stripePaymentPublicKeyInput"
                                            class="block w-full sm:text-sm"
                                            placeholder="pk_..."
                                        />
                                        <x-input-error for="stripe_payment_state.meta.public_key" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="stripePaymentSecretKeyInput" :value="__('Secret key')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="stripe_payment_state.meta.secret_key"
                                            id="stripePaymentSecretKeyInput"
                                            class="block w-full sm:text-sm"
                                            placeholder="sk_..."
                                        />
                                        <x-input-error for="stripe_payment_state.meta.secret_key" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="stripePaymentWebhookSecretInput" :value="__('Webhook secret')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="stripe_payment_state.meta.webhook_secret"
                                            id="stripePaymentWebhookSecretInput"
                                            type="text"
                                            class="block w-full sm:text-sm"
                                            placeholder="whsec_..."
                                        />
                                        <x-input-error for="stripe_payment_state.meta.webhook_secret" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razorpay Payment Section -->
                    <div class="bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 space-y-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                {{ $razorpay_payment->name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div x-data="{ on: @entangle('razorpay_payment_state.is_enabled').defer }" class="col-span-full">
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
                                        <x-input-label x-on:click="on = !on; $refs.switch.focus()" :value="__('Enable')" class="ml-3" />
                                    </div>
                                    <x-input-error for="razorpay_payment_state.is_enabled" class="mt-2" />
                                </div>
                                <div class="sm:col-span-3">
                                    <x-input-label for="razorpayDisplayNameInput" :value="__('Display name')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="razorpay_payment_state.display_name"
                                            type="text"
                                            id="razorpayDisplayNameInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <x-input-error for="razorpay_payment_state.display_name" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="razorpayPaymentDescriptionInput" :value="__('Additional details')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="razorpay_payment_state.description"
                                            id="razorpayPaymentDescriptionInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ __('Displays to customers when they are choosing a payment method.') }}
                                        </p>
                                        <x-input-error for="razorpay_payment_state.description" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="razorpayPaymentPublicKeyInput" :value="__('Public key')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="razorpay_payment_state.meta.api_key"
                                            id="razorpayPaymentPublicKeyInput"
                                            type="text"
                                            class="block w-full sm:text-sm"
                                            placeholder="rzp_..."
                                        />
                                        <x-input-error for="razorpay_payment_state.meta.api_key" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="razorpayPaymentSecretKeyInput" :value="__('Secret key')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="razorpay_payment_state.meta.api_secret"
                                            id="razorpayPaymentSecretKeyInput"
                                            type="text"
                                            class="block w-full sm:text-sm"
                                        />
                                        <x-input-error for="razorpay_payment_state.meta.api_secret" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="razorpayPaymentWebhookSecretInput" :value="__('Webhook secret')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="razorpay_payment_state.meta.webhook_secret"
                                            id="razorpayPaymentWebhookSecretInput"
                                            type="text"
                                            class="block w-full sm:text-sm"
                                            placeholder=""
                                        />
                                        <x-input-error for="razorpay_payment_state.meta.webhook_secret" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cash Payment Section -->
                    <div class="bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 space-y-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                {{ $cash_payment->name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div x-data="{ on: @entangle('cash_on_delivery_state.is_enabled').defer }" class="col-span-full">
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
                                        <x-input-label x-on:click="on = !on; $refs.switch.focus()" :value="__('Enable')" class="ml-3" />
                                    </div>
                                    <x-input-error for="cash_on_delivery_state.is_enabled" class="mt-2" />
                                </div>
                                <div class="sm:col-span-3">
                                    <x-input-label for="cashOnDeliveryDisplayNameInput" :value="__('Display name')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="cash_on_delivery_state.display_name"
                                            type="text"
                                            id="cashOnDeliveryDisplayNameInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <x-input-error for="cash_on_delivery_state.display_name" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="cashOnDeliveryDescriptionInput" :value="__('Additional details')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="cash_on_delivery_state.description"
                                            id="cashOnDeliveryDescriptionInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ __('Displays to customers when they are choosing a payment method.') }}
                                        </p>
                                        <x-input-error for="cash_on_delivery_state.description" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="cashOnDeliveryInstructionsInput" :value="__('Payment instructions')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="cash_on_delivery_state.instructions"
                                            id="cashOnDeliveryInstructionsInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ __('Displays to customers after they place an order with this payment method.') }}
                                        </p>
                                        <x-input-error for="cash_on_delivery_state.instructions" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Deposit Section -->
                    <div class="bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 space-y-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                {{ $bank_deposit->name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div x-data="{ on: @entangle('bank_deposit_state.is_enabled').defer }" class="col-span-full">
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
                                        <x-input-label x-on:click="on = !on; $refs.switch.focus()" :value="__('Enable')" class="ml-3" />
                                    </div>
                                    <x-input-error for="bank_deposit_state.is_enabled" class="mt-2" />
                                </div>
                                <div class="sm:col-span-3">
                                    <x-input-label for="bankDepositDisplayNameInput" :value="__('Display name')" />
                                    <div class="mt-2">
                                        <x-input
                                            wire:model.defer="bank_deposit_state.display_name"
                                            type="text"
                                            id="bankDepositDisplayNameInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <x-input-error for="bank_deposit_state.display_name" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="bankDepositDescriptionInput" :value="__('Additional details')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="bank_deposit_state.description"
                                            id="bankDepositDescriptionInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ __('Displays to customers when they are choosing a payment method.') }}
                                        </p>
                                        <x-input-error for="bank_deposit_state.description" class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-5">
                                    <x-input-label for="bankDepositInstructionsInput" :value="__('Payment instructions')" />
                                    <div class="mt-2">
                                        <x-textarea
                                            wire:model.defer="bank_deposit_state.instructions"
                                            id="bankDepositInstructionsInput"
                                            class="block w-full sm:text-sm"
                                        />
                                        <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                            {{ __('Displays to customers after they place an order with this payment method.') }}
                                        </p>
                                        <x-input-error for="bank_deposit_state.instructions" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="button" class="text-sm font-semibold leading-6 text-purple-900 dark:text-purple-100">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                        {{ __('Save changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
