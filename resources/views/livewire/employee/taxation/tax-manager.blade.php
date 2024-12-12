<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Taxes and duties') }}
            </h1>
            @if($this->taxZones->count())
                <button
                    wire:click="$emitTo('employee.taxation.components.tax-zone-form', 'create')"
                    class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                >
                    {{ __('Create tax zone') }}
                </button>
            @endif
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
            @unless($this->taxZones->count())
                <div class="p-8 text-center">
                    <x-heroicon-o-scale class="mx-auto h-12 w-12 text-purple-400" />
                    <h3 class="mt-2 text-lg font-medium text-purple-900 dark:text-purple-200">
                        {{ __('No zones or rates') }}
                    </h3>
                    <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                        {{ __('Add zones to create rates for places you would like to apply taxes.') }}
                    </p>
                    <div class="mt-6">
                        <button
                            wire:click="$emitTo('employee.taxation.components.tax-zone-form', 'create')"
                            class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                        >
                            {{ __('Create tax zone') }}
                        </button>
                    </div>
                </div>
            @else
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-purple-900 dark:text-purple-100 mb-4">
                        {{ __('Tax zones') }}
                    </h2>
                    <div class="space-y-6">
                        @foreach($this->taxZones as $taxZone)
                            <div class="bg-purple-50 dark:bg-purple-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">
                                        {{ $taxZone->name }}
                                    </h3>
                                    <x-dropdown>
                                        <x-slot:trigger>
                                            <button class="text-purple-400 hover:text-purple-600 dark:hover:text-purple-300">
                                                <x-heroicon-m-ellipsis-horizontal class="w-5 h-5" />
                                            </button>
                                        </x-slot:trigger>
                                        <x-slot:content>
                                            <x-dropdown-link
                                                wire:click="$emitTo('employee.taxation.components.tax-zone-form', 'edit', '{{ $taxZone->id }}')"
                                                role="button"
                                            >
                                                {{ __('Edit zone') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link
                                                wire:click.prevent="confirmTaxZoneDeletion('{{ $taxZone->id }}')"
                                                role="button"
                                            >
                                                <span class="text-red-600">{{ __('Delete') }}</span>
                                            </x-dropdown-link>
                                        </x-slot:content>
                                    </x-dropdown>
                                </div>
                                <p class="text-sm text-purple-600 dark:text-purple-300 mb-4 line-clamp-1 hover:line-clamp-none">
                                    @foreach($taxZone->countries as $country)
                                        {{ $country->country->name }}{{ $loop->last ? '' : ',' }}
                                    @endforeach
                                </p>

                                @unless($taxZone->rates->count())
                                    <x-alert
                                        type="warning"
                                        :message="__('No rates. Customers in this zone won,t be able to complete checkout.')"
                                    />
                                @else
                                    <table class="min-w-full divide-y divide-purple-200 dark:divide-purple-600">
                                        <thead>
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                                    {{ __('Rate name') }}
                                                </th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                                    {{ __('Percentage') }}
                                                </th>
                                                <th class="relative px-6 py-3">
                                                    <span class="sr-only">{{ __('Edit') }}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-purple-200 dark:bg-purple-800 dark:divide-purple-700">
                                            @foreach($taxZone->rates as $taxRate)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-900 dark:text-purple-100">
                                                        {{ $taxRate->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 text-right dark:text-purple-400">
                                                        {{ $taxRate->percentage }}%
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
                                                                    wire:click="$emitTo('employee.taxation.components.tax-rate-form', 'edit', '{{ $taxRate->id }}')"
                                                                    role="button"
                                                                >
                                                                    {{ __('Edit rate') }}
                                                                </x-dropdown-link>
                                                                <x-dropdown-link
                                                                    wire:click="confirmTaxRateDeletion('{{ $taxRate->id }}')"
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
                                        wire:click="$emitTo('employee.taxation.components.tax-rate-form', 'create', '{{ $taxZone->id }}')"
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
    <x-modal-alert wire:model.defer="confirmingTaxZoneDeletion">
        <x-slot:title>
            {{ __('Delete tax zone') }}
        </x-slot:title>
        <x-slot:content>
            <p>{{ __('Are you sure you want to delete this tax zone?') }}</p>
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click="deleteTaxZone"
                wire:loading.attr="disabled"
                type="button"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
            >
                {{ __('Delete') }}
            </button>
            <button
                wire:click.prevent="$set('confirmingTaxZoneDeletion', false)"
                type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-purple-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-purple-700 dark:text-purple-300 dark:border-purple-600 dark:hover:bg-purple-600"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <x-modal-alert wire:model.defer="confirmingTaxRateDeletion">
        <x-slot:title>
            {{ __('Delete tax rate') }}
        </x-slot:title>
        <x-slot:content>
            <p>{{ __('Are you sure you want to delete this tax rate?') }}</p>
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click="deleteTaxRate"
                wire:loading.attr="disabled"
                type="button"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
            >
                {{ __('Delete') }}
            </button>
            <button
                wire:click.prevent="$set('confirmingTaxRateDeletion', false)"
                type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-purple-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-purple-700 dark:text-purple-300 dark:border-purple-600 dark:hover:bg-purple-600"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <livewire:employee.taxation.components.tax-zone-form />
    <livewire:employee.taxation.components.tax-rate-form />
</div>
