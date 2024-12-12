<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Products') }}
            </h1>
            @if($products->count())
                <button
                    wire:click.prevent="newProduct"
                    class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                >
                    {{ __('Add product') }}
                </button>
            @endif
        </div>

        <!-- Content -->
        @if(!$products->count() && !$search)
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden p-8 text-center">
                <x-heroicon-o-tag class="mx-auto h-16 w-16 text-purple-400" />
                <h3 class="mt-4 text-xl font-medium text-purple-900 dark:text-purple-200">
                    {{ __('First up: what are you selling?') }}
                </h3>
                <p class="mt-2 text-sm text-purple-500 dark:text-purple-400">
                    {{ __('Before you open your store, first you need some products.') }}
                </p>
                <button
                    wire:click.prevent="newProduct"
                    class="mt-6 px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                >
                    <x-heroicon-m-plus class="-ml-1 mr-2 h-5 w-5 inline" />
                    {{ __('Add your products') }}
                </button>
            </div>
        @else
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-6 border-b border-purple-200 dark:border-purple-700">
                    <div class="relative max-w-sm">
                        <input
                            wire:model.debounce.500ms="search"
                            type="text"
                            class="w-full pl-10 pr-4 py-2 border border-purple-300 rounded-lg text-purple-700 focus:outline-none focus:border-purple-500 dark:bg-purple-700 dark:border-purple-600 dark:text-purple-300"
                            placeholder="{{ __('Filter products') }}"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-purple-400" />
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-purple-200 dark:divide-purple-700">
                        <thead class="bg-purple-50 dark:bg-purple-700">
                            <tr>
                                <th scope="col" class="relative px-6 py-3">
                                    <input
                                        wire:model="selectPage"
                                        type="checkbox"
                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-purple-300 text-purple-600 focus:ring-purple-500 dark:border-purple-600 dark:bg-purple-700 dark:ring-offset-purple-800"
                                    />
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                    {{ __('Product') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                    {{ __('Status') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                    {{ __('Inventory') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-purple-200 dark:bg-purple-800 dark:divide-purple-700">
                            @forelse($products as $product)
                                <tr class="hover:bg-purple-50 dark:hover:bg-purple-700 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input
                                            wire:model="selected"
                                            type="checkbox"
                                            value="{{ $product->id }}"
                                            class="h-4 w-4 rounded border-purple-300 text-purple-600 focus:ring-purple-500 dark:border-purple-600 dark:bg-purple-700 dark:ring-offset-purple-800"
                                        />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $product->getFirstMediaUrl('gallery', 'thumb') }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('employee.products.detail', $product->id) }}" class="text-sm font-medium text-purple-900 hover:text-purple-600 dark:text-purple-100 dark:hover:text-purple-400">
                                                    {{ $product->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100' }}">
                                            {{ $product->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 dark:text-purple-400">
                                        {{ __(':count in stock', ['count' => $product->variants_sum_stock_value]) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 dark:text-purple-400 text-center">
                                        <div class="flex flex-col items-center">
                                            <x-heroicon-o-magnifying-glass class="h-12 w-12 text-purple-400 dark:text-purple-300 mb-4" />
                                            <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">{{ __('No products found') }}</h3>
                                            <p class="mt-1 text-purple-500 dark:text-purple-400">{{ __('Try changing the filters or search term') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
