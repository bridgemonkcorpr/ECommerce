<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-12">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Orders') }}
            </h1>
            <div
                x-data="{ search: @entangle('search') }"
                class="relative"
            >
                <input
                    wire:model.debounce.500ms="search"
                    type="text"
                    class="bg-white dark:bg-purple-800 text-purple-700 dark:text-purple-300 rounded-full px-6 py-3 pr-10 border-2 border-purple-300 dark:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                    placeholder="{{ __('Filter orders') }}"
                >
                <button
                    x-show="search.length"
                    x-on:click="search = ''"
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-3"
                >
                    <svg class="w-5 h-5 text-purple-500 hover:text-purple-700 dark:hover:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
            @if(!$orders->count() && !$search)
                <div class="p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <h3 class="mt-4 text-xl font-medium text-purple-900 dark:text-purple-200">{{ __('Your orders will show here') }}</h3>
                    <p class="mt-2 text-purple-500 dark:text-purple-400">{{ __("This is where you'll fulfill orders, collect payments and track order progress.") }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-purple-50 dark:bg-purple-700">
                            <tr>
                                <th class="w-12 px-6 py-3">
                                    <input type="checkbox" wire:model="selectPage" class="rounded border-purple-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __('ID') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __('Customer') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __('Payment Status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __('Shipping Status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __('Items') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __('Total') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-purple-200 dark:divide-purple-700">
                            @forelse($orders as $order)
                                <tr class="hover:bg-purple-50 dark:hover:bg-purple-700 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" wire:model="selected" value="{{ $order->id }}" class="rounded border-purple-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600 dark:text-purple-400">
                                        <a href="{{ route('employee.orders.detail', $order) }}" class="hover:underline">{{ $order->id }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300">
                                        @if($order->customer)
                                            <a href="{{ route('employee.customers.detail', $order->customer) }}" class="hover:underline">{{ $order->customer->name }}</a>
                                        @else
                                            <span class="text-purple-500">{{ __('No customer') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="color: {{ $order->payment_status->color() }}; background-color: {{ $order->payment_status->color() }}20;">
                                            {{ $order->payment_status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="color: {{ $order->shipping_status->color() }}; background-color: {{ $order->shipping_status->color() }}20;">
                                            {{ $order->shipping_status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300">
                                        {{ trans_choice(':count item|:count items', $order->order_items_sum_quantity) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300 text-right">
                                        <x-money :amount="$order->total" :currency="config('app.currency')" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300 text-right">
                                        {{ $order->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 dark:text-purple-400 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-purple-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            <p class="text-lg font-medium">{{ __('No orders found') }}</p>
                                            <p class="text-sm">{{ __('Try changing the filters or search term') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Loading Overlay -->


    <!-- No Orders Found Message (Permanent) -->
    @if($orders->count() === 0 && $search)
        <div class="absolute inset-0 z-40 bg-white dark:bg-purple-800 flex items-center justify-center">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <h3 class="mt-2 text-lg font-medium text-purple-900 dark:text-purple-200">{{ __('No orders found') }}</h3>
                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">{{ __('Try changing the filters or search term') }}</p>
            </div>
        </div>
    @endif
</div>
