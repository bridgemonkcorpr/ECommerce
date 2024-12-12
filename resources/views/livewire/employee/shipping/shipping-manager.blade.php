<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Shipping and delivery') }}
            </h1>
            @if($this->shippingZones->count())
                <button
                    wire:click="$emitTo('employee.shipping.components.shipping-zone-form', 'create')"
                    class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                >
                    {{ __('Create shipping zone') }}
                </button>
            @endif
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
            @unless($this->shippingZones->count())
                <div class="p-8 text-center">
                    <x-heroicon-o-map-pin class="mx-auto h-12 w-12 text-purple-400" />
                    <h3 class="mt-2 text-lg font-medium text-purple-900 dark:text-purple-200">
                        {{ __('No zones or rates') }}
                    </h3>
                    <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                        {{ __('Add zones to create rates for places you want to ship to.') }}
                    </p>
                    <div class="mt-6">
                        <button
                            wire:click="$emitTo('employee.shipping.components.shipping-zone-form', 'create')"
                            class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                        >
                            {{ __('Create shipping zone') }}
                        </button>
                    </div>
                </div>
            @else
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-purple-900 dark:text-purple-100 mb-4">
                        {{ __('Shipping to') }}
                    </h2>
                    <div class="space-y-6">
                        @foreach($this->shippingZones as $shippingZone)
                            <div class="bg-purple-50 dark:bg-purple-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">
                                        {{ $shippingZone->name }}
                                    </h3>
                                    <x-dropdown>
                                        <x-slot:trigger>
                                            <button class="text-purple-400 hover:text-purple-600 dark:hover:text-purple-300">
                                                <x-heroicon-m-ellipsis-horizontal class="w-5 h-5" />
                                            </button>
                                        </x-slot:trigger>
                                        <x-slot:content>
                                            <x-dropdown-link
                                                wire:click="$emitTo('employee.shipping.components.shipping-zone-form', 'edit', '{{ $shippingZone->id }}')"
                                                role="button"
                                            >
                                                {{ __('Edit zone') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link
                                                wire:click.prevent="confirmShippingZoneDeletion('{{ $shippingZone->id }}')"
                                                role="button"
                                            >
                                                <span class="text-red-600">{{ __('Delete') }}</span>
                                            </x-dropdown-link>
                                        </x-slot:content>
                                    </x-dropdown>
                                </div>
                                <p class="text-sm text-purple-600 dark:text-purple-300 mb-4">
                                    @foreach($shippingZone->countries as $country)
                                        {{ $country->country->name }}{{ $loop->last ? '' : ',' }}
                                    @endforeach
                                </p>

                                @unless($shippingZone->rates->count())
                                    <x-alert
                                        type="warning"
                                        :message="__('No rates. Customers in this zone wont be able to complete checkout.')"
                                    />
                                @else
                                    <table class="min-w-full divide-y divide-purple-200 dark:divide-purple-600">
                                        <thead>
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                                    {{ __('Rate name') }}
                                                </th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                                    {{ __('Condition') }}
                                                </th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                                    {{ __('Price') }}
                                                </th>
                                                <th class="relative px-6 py-3">
                                                    <span class="sr-only">{{ __('Edit') }}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-purple-200 dark:bg-purple-800 dark:divide-purple-700">
                                            @foreach($shippingZone->rates as $shippingRate)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-900 dark:text-purple-100">
                                                        {{ $shippingRate->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 text-right dark:text-purple-400">
                                                        @if($shippingRate->hasConditions)
                                                            @if($shippingRate->based_on === 'price')
                                                                <x-money :amount="$shippingRate->min_value" :currency="config('app.currency')" />
                                                                @if($shippingRate->max_value)
                                                                    - <x-money :amount="$shippingRate->max_value" :currency="config('app.currency')" />
                                                                @else
                                                                    {{ __('and up') }}
                                                                @endif
                                                            @else
                                                                {{ $shippingRate->min_value . 'kg' }}
                                                                @if($shippingRate->max_value)
                                                                    - {{ $shippingRate->max_value }}kg
                                                                @else
                                                                    {{ __('and up') }}
                                                                @endif
                                                            @endif
                                                        @else
                                                            <span>&mdash;</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 text-right dark:text-purple-400">
                                                        <x-money :amount="$shippingRate->price" :currency="config('app.currency')" />
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <x-dropdown>
                                                            <x-slot name="trigger">
                                                                <button class="text-purple-400 hover:text-purple-600 dark:hover:text-purple-300">
                                                                    <x-heroicon-m-ellipsis-horizontal class="w-5 h-5" />
                                                                </button>
                                                            </x-slot>
                                                            <x-slot name="content">
                                                                <x-dropdown-link
                                                                    wire:click="$emitTo('employee.shipping.components.shipping-rate-form', 'edit', '{{ $shippingRate->id }}')"
                                                                    role="button"
                                                                >
                                                                    {{ __('Edit rate') }}
                                                                </x-dropdown-link>
                                                                <x-dropdown-link
                                                                    wire:click.prevent="confirmShippingRateDeletion('{{ $shippingRate->id }}')"
                                                                    role="button"
                                                                >
                                                                    <span class="text-red-600">{{ __('Delete') }}</span>
                                                                </x-dropdown-link>
                                                            </x-slot>
                                                        </x-dropdown>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endunless

                                <div class="mt-4">
                                    <button
                                        wire:click="$emitTo('employee.shipping.components.shipping-rate-form', 'create', '{{ $shippingZone->id }}')"
                                        type="button"
                                        class="px-4 py-2 border border-purple-300 rounded-md shadow-sm text-sm font-medium text-purple-700 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:bg-purple-700 dark:text-purple-300 dark:border-purple-600 dark:hover:bg-purple-600"
                                    >
                                        {{ __('Add rate') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endunless
        </div>
    </div>

    <!-- Modals -->
    <x-modal-alert wire:model.defer="confirmingShippingZoneDeletion">
        <x-slot:title>
            {{ __('Delete shipping zone') }}
        </x-slot:title>
        <x-slot:content>
            <p>{{ __('Are you sure you want to delete this shipping zone?') }}</p>
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click="deleteShippingZone"
                wire:loading.attr="disabled"
                type="button"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
            >
                {{ __('Delete') }}
            </button>
            <button
                wire:click.prevent="$set('confirmingShippingZoneDeletion', false)"
                type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-purple-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-purple-700 dark:text-purple-300 dark:border-purple-600 dark:hover:bg-purple-600"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <x-modal-alert wire:model.defer="confirmingShippingRateDeletion">
        <x-slot:title>
            {{ __('Delete shipping rate') }}
        </x-slot:title>
        <x-slot:content>
            <p>{{ __('Are you sure you want to delete this shipping rate?') }}</p>
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click="deleteShippingRate"
                wire:loading.attr="disabled"
                type="button"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
            >
                {{ __('Delete') }}
            </button>
            <button
                wire:click.prevent="$set('confirmingShippingRateDeletion', false)"
                type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-purple-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-purple-700 dark:text-purple-300 dark:border-purple-600 dark:hover:bg-purple-600"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <livewire:employee.shipping.components.shipping-zone-form />
    <livewire:employee.shipping.components.shipping-rate-form />
</div>
