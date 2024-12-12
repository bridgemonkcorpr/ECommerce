<div>
    <form
        x-data="{ dirty: new Set() }"
        x-on:variant-pricing-updated.window="dirty.clear()"
        wire:submit.prevent="save"
    >
        <x-card class="relative overflow-hidden">
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Pricing') }}
                        </h3>
                    </div>
                    <div
                        x-show="dirty.size >= 1"
                        class="ml-4 mt-2 flex-shrink-0"
                    >
                        <button
                            type="submit"
                            class="btn btn-link  text-purple-600"
                        >
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </x-slot:header>
            <x-slot:content class="-mt-5">
                <fieldset
                    wire:target="save"
                    wire:loading.delay.attr="disabled"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-6"
                >
                    <div class="col-span-1">
                        <x-input-label
                            for="variantPriceInput"
                            :value="__('Price')"
                        />
                        <x-input-money
                            x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('price') }}' ? dirty.add('price') : dirty.delete('price'))"
                            wire:model.defer="variant.price"
                            id="variantPriceInput"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="variant.price"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-1">
                        <x-input-label
                            for="variantComparePriceInput"
                            :value="__('Compare at Price')"
                        />
                        <div class="mt-1 relative">
                            <x-input-money
                                x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('compare_price') }}' ? dirty.add('compare_price') : dirty.delete('compare_price'))"
                                wire:model.defer="variant.compare_price"
                                id="variantComparePriceInput"
                                class="block w-full pr-10 sm:text-sm"
                            />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <x-heroicon-s-question-mark-circle
                                    class="h-5 w-5 text-slate-400"
                                    data-tippy-content="{{ __('To show a reduced price, move the original variant\'s price into Compare at price. Enter a lower value into Price.') }}"
                                    data-tippy-placement="bottom"
                                />
                            </div>
                        </div>
                        <x-input-error
                            for="variant.compare_price"
                            class="mt-2"
                        />
                    </div>
                </fieldset>

                <hr class="-mx-4 my-6 border-slate-200 sm:-mx-6 dark:border-slate-200/10">

                <fieldset
                    wire:target="save"
                    wire:loading.attr="disabled"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center"
                >
                    <div @class(['col-span-1 sm:col-span-2' => $variant->cost_price <= 0])>
                        <x-input-label
                            for="variantCostPriceInput"
                            :value="__('Cost per item')"
                        />
                        <x-input-money
                            x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('cost_price') }}' ? dirty.add('cost_price') : dirty.delete('cost_price'))"
                            wire:model.debounce.300ms="variant.cost_price"
                            id="variantCostPriceInput"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="variant.cost_price"
                            class="mt-2"
                        />
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ __('Customers won’t see this') }}
                        </p>
                    </div>
                    @if($variant->cost_price > 0)
                        <dl class="grid grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Margin') }}</dt>
                                <dd class="mt-1 text-sm text-slate-900 dark:text-slate-200">
                                    {{ $variant->profit_margin }}%
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Profit') }}</dt>
                                <dd class="mt-1 text-sm text-slate-900 dark:text-slate-200">
                                    <x-money
                                        :amount="$variant->gross_profit"
                                        :currency="config('app.currency')"
                                    />
                                </dd>
                            </div>
                        </dl>
                    @endif
                </fieldset>
            </x-slot:content>
        </x-card>
    </form>
</div>
