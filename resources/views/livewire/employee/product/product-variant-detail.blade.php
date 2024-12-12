<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center mb-8">

                href="{{ route('employee.products.detail', $product) }}"
                class="mr-4 bg-white dark:bg-purple-800 p-2 rounded-full shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 transition-colors duration-200"
            >
                <x-heroicon-m-arrow-left class="w-6 h-6 text-purple-600 dark:text-purple-300" />
            </a>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ $variantName }}
            </h1>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-1 space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <a href="{{ route('employee.products.detail', $product) }}" class="flex-shrink-0">
                                <img
                                    src="{{ $product->getFirstMediaUrl('gallery', 'thumb_large') }}"
                                    alt="{{ $product->name }}"
                                    class="h-20 w-20 rounded-lg object-cover"
                                >
                            </a>
                            <div class="min-w-0 flex-1">
                                <p class="text-lg font-semibold text-purple-900 dark:text-purple-200">
                                    {{ $product->name }}
                                </p>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100' }}">
                                        {{ $product->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </p>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ trans_choice(':count variant|:count variants', $product->variants_count) }}
                                </p>

                                    href="{{ route('employee.products.detail', $product) }}"
                                    class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-600 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:bg-purple-800 dark:text-purple-200 dark:hover:bg-purple-700"
                                >
                                    {{ __('Back to product') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Variants') }}
                        </h3>
                        <nav class="space-y-1 max-h-96 overflow-auto">
                            @foreach($product->variants as $productVariant)

                                    href="{{ route('employee.products.variants.detail', [$product, $productVariant]) }}"
                                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ Request::segment(3) == $product->id && Request::segment(5) == $productVariant->id ? 'bg-purple-100 text-purple-900 dark:bg-purple-800 dark:text-purple-200' : 'text-purple-600 hover:bg-purple-50 hover:text-purple-900 dark:text-purple-300 dark:hover:bg-purple-900 dark:hover:text-purple-200' }}"
                                >
                                    <img
                                        src="{{ $productVariant->getFirstMediaUrl('image') }}"
                                        alt="{{ $product->name }}"
                                        class="flex-shrink-0 mr-3 h-6 w-6 rounded"
                                    >
                                    <span class="truncate">
                                        @foreach($productVariant->variantAttributes as $attribute)
                                            {{ $attribute->optionValue->label }}@if(!$loop->last) / @endif
                                        @endforeach
                                    </span>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Variant Image') }}
                        </h3>
                        <livewire:employee.product.components.product-variant-image
                            :product="$product"
                            :variant="$variant"
                        />
                    </div>
                </div>
            </div>

            <div class="xl:col-span-2 space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Pricing') }}
                        </h3>
                        <livewire:employee.product.components.product-variant-pricing
                            :product="$product"
                            :variant="$variant"
                        />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Inventory') }}
                        </h3>
                        <livewire:employee.product.components.product-variant-inventory
                            :product="$product"
                            :variant="$variant"
                        />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Shipping') }}
                        </h3>
                        <livewire:employee.product.components.product-variant-shipping
                            :product="$product"
                            :variant="$variant"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
