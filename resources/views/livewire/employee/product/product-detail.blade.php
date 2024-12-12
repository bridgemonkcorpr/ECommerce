<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center mb-8">
            <div class="flex items-center space-x-4 mb-4 sm:mb-0">

                   <a href="{{ route('employee.products.list') }}"
                    class="bg-white dark:bg-purple-800 p-2 rounded-full shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 transition-colors duration-200"
                >
                    <x-heroicon-m-arrow-left class="w-6 h-6 text-purple-600 dark:text-purple-300" />
                </a>
                <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                    {{ $product->name }}
                </h1>
                <span class="px-2 py-1 text-sm font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100' }}">
                    {{ $product->status->label() }}
                </span>
            </div>

             <a   href="{{ route('guest.products.detail', $product) }}"
                target="_blank"
                class="px-4 py-2 bg-white dark:bg-purple-800 text-purple-600 dark:text-purple-400 font-semibold rounded-lg shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
            >
                {{ __('Preview') }}
            </a>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Product Information') }}
                        </h2>
                        <livewire:employee.product.components.product-information :product="$product" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Product Specification') }}
                        </h2>
                        <livewire:employee.product.components.product-specification :product="$product" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Product Gallery') }}
                        </h2>
                        <livewire:employee.product.components.product-gallery :product="$product" />
                    </div>
                </div>

                @unless($product_options_count)
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Pricing') }}
                            </h2>
                            <livewire:employee.product.components.product-variant-pricing
                                :product="$product"
                                :variant="$product->variants->first()"
                            />
                        </div>
                    </div>

                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Inventory') }}
                            </h2>
                            <livewire:employee.product.components.product-variant-inventory
                                :product="$product"
                                :variant="$product->variants->first()"
                            />
                        </div>
                    </div>

                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Shipping') }}
                            </h2>
                            <livewire:employee.product.components.product-variant-shipping
                                :product="$product"
                                :variant="$product->variants->first()"
                            />
                        </div>
                    </div>
                @endunless

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Product Options') }}
                        </h2>
                        <livewire:employee.product.components.product-option :product="$product" />
                    </div>
                </div>

                @if($product_options_count > 0)
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Product Variants') }}
                            </h2>
                            <livewire:employee.product.components.product-variant-list :product="$product" />
                        </div>
                    </div>
                @endif

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Search Engine Information') }}
                        </h2>
                        <livewire:employee.search-engine-information-form :model="$product" />
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1 space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Product Status') }}
                        </h2>
                        <livewire:employee.product.components.product-status :product="$product" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Product Organization') }}
                        </h2>
                        <livewire:employee.product.components.product-organization :product="$product" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
