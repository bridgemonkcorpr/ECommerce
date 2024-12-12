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
                {{ trans_choice('Fulfill item|Fulfill items', $this->unshippedItems->count()) }}
            </h1>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2">
                <form wire:submit.prevent="save">
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Order #:orderId', ['orderId' => $order->id]) }}
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
                                        @foreach($this->unshippedItems as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $item->variant->hasMedia('image') ? $item->variant->getFirstMediaUrl('image', 'thumb') : $item->variant->product->getFirstMediaUrl('gallery', 'thumb') }}" alt="{{ $item->name }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-purple-900 dark:text-white">
                                                                {{ $item->name }}
                                                            </div>
                                                            <div class="text-sm text-purple-500 dark:text-purple-400">
                                                                @if($item->variant->variantAttributes)
                                                                    @foreach($item->variant->variantAttributes as $attribute)
                                                                        {{ $attribute->optionValue->label }}@if(!$loop->last), @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-purple-500 dark:text-purple-400">
                                                    <x-input
                                                        wire:model.defer="shipmentItems.{{ $loop->index }}.quantity"
                                                        type="number"
                                                        class="w-20 text-right"
                                                        min="0"
                                                        max="{{ $item->quantity - $item->shipmentItems->sum('quantity') }}"
                                                    />
                                                    <span class="ml-2">
                                                        / {{ $item->quantity - ($item->shipmentItems->sum('quantity') + $item->refundItems->sum('quantity')) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-8">
                                @if($type == 'physical')
                                    <h4 class="text-lg font-medium text-purple-900 dark:text-white mb-4">
                                        {{ __('Tracking information (optional)') }}
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="shipping_carrier" class="block text-sm font-medium text-purple-700 dark:text-purple-300">
                                                {{ __('Shipping carrier') }}
                                            </label>
                                            <select
                                                wire:model="shipment.shipping_carrier"
                                                id="shipping_carrier"
                                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-purple-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-purple-700 dark:border-purple-600 dark:text-white"
                                            >
                                                @foreach($shippingCarriers as $shippingCarrier)
                                                    <option value="{{ $shippingCarrier->value }}">{{ $shippingCarrier->label() }}</option>
                                                @endforeach
                                            </select>
                                            @error('shipment.shipping_carrier')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="tracking_number" class="block text-sm font-medium text-purple-700 dark:text-purple-300">
                                                {{ __('Tracking number') }}
                                            </label>
                                            <input
                                                wire:model.defer="shipment.tracking_number"
                                                type="text"
                                                id="tracking_number"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-purple-300 rounded-md dark:bg-purple-700 dark:border-purple-600 dark:text-white"
                                            >
                                            @error('shipment.tracking_number')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        @if($shipment->shipping_carrier->value === \App\Enums\ShippingCarrier::OTHER->value)
                                            <div class="col-span-full">
                                                <label for="tracking_url" class="block text-sm font-medium text-purple-700 dark:text-purple-300">
                                                    {{ __('Tracking URL') }}
                                                </label>
                                                <input
                                                    wire:model.defer="shipment.tracking_url"
                                                    type="text"
                                                    id="tracking_url"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-purple-300 rounded-md dark:bg-purple-700 dark:border-purple-600 dark:text-white"
                                                >
                                                @error('shipment.tracking_url')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-purple-700 dark:text-purple-300">
                                        {{ __('Shipping not required.') }}
                                    </p>
                                @endif
                            </div>

                            @error('shipmentItems')
                                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-700 px-6 py-4">
                            <div class="flex justify-end">
                                <button
                                    wire:loading.attr="disabled"
                                    type="submit"
                                    class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                                >
                                    {{ __('Create shipment') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="xl:col-span-1">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Shipping address') }}
                        </h2>
                        @if($order->shippingAddress)
                            <address class="not-italic text-sm text-purple-700 dark:text-purple-300">
                                {{ $order->shippingAddress->name }}<br>

                                @if($order->shippingAddress->company_name)
                                    {{ $order->shippingAddress->company_name }}<br>
                                @endif

                                @if($order->shippingAddress->address_line_1)
                                    {{ $order->shippingAddress->address_line_1 }}<br>
                                @endif

                                @if($order->shippingAddress->address_line_2)
                                    {{ $order->shippingAddress->address_line_2 }}<br>
                                @endif

                                @if($order->shippingAddress->city)
                                    {{ $order->shippingAddress->city }}
                                @endif

                                @if($order->shippingAddress->state)
                                    {{ $order->shippingAddress->state }}<br>
                                @endif

                                {{ $order->shippingAddress->country->name }}<br>

                                @if($order->shippingAddress->phone)
                                    {{ $order->shippingAddress->phone }}<br>
                                @endif
                            </address>
                        @else
                            <p class="text-sm text-purple-500 dark:text-purple-400">
                                {{ __('No shipping address provided.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
