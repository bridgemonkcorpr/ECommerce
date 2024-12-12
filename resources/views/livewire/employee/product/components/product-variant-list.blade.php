<div>
    <x-card class="overflow-hidden">
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Variants') }}
                    </h3>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            <ul
                role="list"
                class="-mx-4 -mb-5 border-t border-slate-300 divide-y divide-slate-200 sm:-mx-6 dark:border-slate-200/20 dark:divide-slate-200/10"
            >
                @foreach($product->variants as $variant)
                    <li>
                        <div class="relative px-4 sm:px-6 py-5 flex items-center space-x-3 hover:bg-slate-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-purple-500 dark:hover:bg-slate-800">
                            <div class="flex-shrink-0">
                                <img
                                    class="h-10 w-10 rounded"
                                    src="{{ $variant->getFirstMediaUrl('image') }}"
                                    alt="{{ $product->name }}"
                                >
                            </div>
                            <div class="flex-1 min-w-0">
                                <a
                                    href="{{ route('employee.products.variants.detail', [$product, $variant]) }}"
                                    class="focus:outline-none"
                                >
                                    <!-- Extend touch target to entire panel -->
                                    <span
                                        class="absolute inset-0"
                                        aria-hidden="true"
                                    ></span>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <ul class="space-x-2 divide-x divide-slate-200 font-medium text-sm text-slate-900 dark:divide-slate-200/10 dark:text-slate-200">
                                                @foreach($variant->variantAttributes as $attribute)
                                                    <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                @endforeach
                                            </ul>
                                            <p class="text-sm text-slate-500 truncate dark:text-slate-400">
                                                {{ $variant->sku }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-slate-900 dark:text-slate-200">
                                                <x-money
                                                    :amount="$variant->price"
                                                    :currency="config('app.currency')"
                                                />
                                            </p>
                                            <p class="text-sm text-slate-500 truncate dark:text-slate-400">
                                                {{ __(':count in stock', ['count' => $variant->stock_value]) }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </x-slot:content>
    </x-card>
</div>
