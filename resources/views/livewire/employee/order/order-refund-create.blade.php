<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center mb-8">

              <a  href="{{ route('employee.orders.detail', $order) }}"
                class="mr-4 bg-white dark:bg-purple-800 p-2 rounded-full shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 transition-colors duration-200"
            >
                <x-heroicon-m-arrow-left class="w-6 h-6 text-purple-600 dark:text-purple-300" />
            </a>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Refund') }}
            </h1>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                @if($removedItemsCount)
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg">
                        <p class="text-sm">{{ __('Some items in this order have been removed.') }}</p>
                    </div>
                @endif

                @if($this->unshippedItems->count())
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Unshipped Items') }}
                            </h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-purple-200 dark:divide-purple-700">
                                    <thead class="bg-purple-50 dark:bg-purple-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-500 uppercase tracking-wider">
                                                {{ __('Item') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-purple-500 uppercase tracking-wider">
                                                {{ __('Quantity') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-purple-200 dark:divide-purple-700">
                                        @foreach($this->unshippedItems as $unShippedItem)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $unShippedItem->variant->hasMedia('image') ? $unShippedItem->variant->getFirstMediaUrl('image', 'thumb') : $unShippedItem->variant->product->getFirstMediaUrl('gallery', 'thumb') }}" alt="{{ $unShippedItem->name }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-purple-900 dark:text-white">
                                                                {{ $unShippedItem->name }}
                                                            </div>
                                                            <div class="text-sm text-purple-500 dark:text-purple-400">
                                                                @if($unShippedItem->variant->variantAttributes)
                                                                    @foreach($unShippedItem->variant->variantAttributes as $attribute)
                                                                        {{ $attribute->optionValue->label }}@if(!$loop->last), @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-purple-500 dark:text-purple-400">
                                                    <x-input
                                                        wire:model="selectedUnshippedItems.{{ $loop->index }}.selected_quantity"
                                                        type="number"
                                                        class="w-20 text-right"
                                                        min="0"
                                                        max="{{ $unShippedItem->quantity - ($unShippedItem->shipmentItems->sum('quantity') + $unShippedItem->refundItems->where('is_shipped', false)->sum('quantity')) }}"
                                                    />
                                                    <span class="ml-2">
                                                        / {{ $unShippedItem->quantity - ($unShippedItem->shipmentItems->sum('quantity') + $unShippedItem->refundItems->where('is_shipped', false)->sum('quantity')) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if($this->shippedItems->count())
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Shipped Items') }}
                            </h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-purple-200 dark:divide-purple-700">
                                    <thead class="bg-purple-50 dark:bg-purple-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-500 uppercase tracking-wider">
                                                {{ __('Item') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-purple-500 uppercase tracking-wider">
                                                {{ __('Quantity') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-purple-200 dark:divide-purple-700">
                                        @foreach($this->shippedItems as $shippedItem)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $shippedItem->variant->hasMedia('image') ? $shippedItem->variant->getFirstMediaUrl('image', 'thumb') : $shippedItem->variant->product->getFirstMediaUrl('gallery', 'thumb') }}" alt="{{ $shippedItem->name }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-purple-900 dark:text-white">
                                                                {{ $shippedItem->name }}
                                                            </div>
                                                            <div class="text-sm text-purple-500 dark:text-purple-400">
                                                                @if($shippedItem->variant->variantAttributes)
                                                                    @foreach($shippedItem->variant->variantAttributes as $attribute)
                                                                        {{ $attribute->optionValue->label }}@if(!$loop->last), @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-purple-500 dark:text-purple-400">
                                                    <x-input
                                                        wire:model="selectedShippedItems.{{ $loop->index }}.selected_quantity"
                                                        type="number"
                                                        class="w-20 text-right"
                                                        min="0"
                                                        max="{{ $shippedItem->shipmentItems->sum('quantity') - $shippedItem->refundItems->where('is_shipped', true)->sum('quantity') }}"
                                                    />
                                                    <span class="ml-2">
                                                        / {{ $shippedItem->shipmentItems->sum('quantity') - $shippedItem->refundItems->where('is_shipped', true)->sum('quantity') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Reason for Refund') }}
                        </h2>
                        <div>
                            <label for="reason" class="block text-sm font-medium text-purple-700 dark:text-purple-300 mb-2">
                                {{ __('Reason') }}
                            </label>
                            <input
                                wire:model.defer="refund.reason"
                                type="text"
                                id="reason"
                                class="mt-1 block w-full rounded-md border-purple-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-purple-700 dark:border-purple-600 dark:text-white"
                            />
                            <p class="mt-2 text-sm text-purple-500 dark:text-purple-400">
                                {{ __('Only you and other staff can see this reason.') }}
                            </p>
                            @error('refund.reason')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Summary') }}
                        </h2>
                        <div wire:target="selectedShippedItems, selectedUnshippedItems" wire:loading.remove>
                            @if($this->summary['items_count'] > 0)
                                <dl class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-purple-500 dark:text-purple-400">{{ __('Items subtotal') }}</dt>
                                        <dd class="font-medium text-purple-900 dark:text-white">{{ money($this->summary['subtotal']) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-purple-500 dark:text-purple-400">{{ __('Discount') }}</dt>
                                        <dd class="font-medium text-purple-900 dark:text-white">{{ money($this->summary['discount_total']) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-purple-500 dark:text-purple-400">{{ __('Tax') }}</dt>
                                        <dd class="font-medium text-purple-900 dark:text-white">{{ money($this->summary['tax_total']) }}</dd>
                                    </div>
                                    <div class="flex justify-between border-t border-purple-200 dark:border-purple-700 pt-3">
                                        <dt class="text-purple-900 dark:text-white font-medium">{{ __('Refund total') }}</dt>
                                        <dd class="text-purple-900 dark:text-white font-medium">{{ money($this->summary['refund_total']) }}</dd>
                                    </div>
                                </dl>
                            @else
                                <p class="text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('No items selected.') }}
                                </p>
                            @endif
                        </div>
                        <div wire:target="selectedShippedItems, selectedUnshippedItems" wire:loading.flex class="justify-center">
                            <svg class="animate-spin h-5 w-5 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <hr class="my-5 border-purple-200 dark:border-purple-700">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-purple-700 dark:text-purple-300 mb-2">
                                {{ __('Refund amount') }}
                            </label>
                            <x-input-money
                                wire:model.lazy="refund.amount"
                                id="amount"
                                class="block w-full rounded-md border-purple-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-purple-700 dark:border-purple-600 dark:text-white"
                                placeholder="0.00"
                            />
                            <p class="mt-2 text-sm text-purple-500 dark:text-purple-400">
                                {{ money($order->total_paid - $order->totalRefunded) }} {{ __('available for refund') }}
                            </p>
                            @error('refund.amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <hr class="my-5 border-purple-200 dark:border-purple-700">
                        <button
                            wire:click="refund"
                            wire:loading.attr="disabled"
                            wire:target="refund"
                            type="button"
                            class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                            @disabled($refund->amount <= 0)
                        >
                            <span wire:loading.remove wire:target="refund">
                                {{ __('Refund :amount', ['amount' => money($refund->amount ?? 0)]) }}
                            </span>
                            <span wire:loading wire:target="refund" class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('Processing...') }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
