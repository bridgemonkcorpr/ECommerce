<div>
    <form
        x-data="{ dirty: new Set() }"
        x-on:variant-inventory-updated.window="dirty.clear()"
        wire:submit.prevent="save"
    >
        <x-card class="relative overflow-hidden">
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Inventory') }}
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
                    class="grid grid-cols-2 gap-6"
                >
                    <div class="col-span-1">
                        <x-input-label
                            for="stock"
                            :value="__('Stock')"
                        />
                        <x-input
                            x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('stock_value') }}' ? dirty.add('stock_value') : dirty.delete('stock_value'))"
                            wire:model.defer="variant.stock_value"
                            type="number"
                            id="stock"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            class="mt-2"
                            for="variant.stock_value"
                        />
                    </div>
                    <div class="col-span-1">
                        <x-input-label
                            for="weight"
                            :value="__('Weight')"
                        />
                        <div class="mt-1 relative">
                            <x-input
                                x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('weight_value') }}' ? dirty.add('weight_value') : dirty.delete('weight_value'))"
                                wire:model.defer="variant.weight_value"
                                type="number"
                                id="weight"
                                class="block w-full sm:text-sm no-spinners"
                                step="any"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <label
                                    for="weight_unit"
                                    class="sr-only"
                                >
                                    {{ __('Weight Unit') }}
                                </label>
                                <select
                                    x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('weight_unit') }}' ? dirty.add('weight_unit') : dirty.delete('weight_unit'))"
                                    wire:model.defer="variant.weight_unit"
                                    id="weight_unit"
                                    name="weight_unit"
                                    class="h-full py-0 pl-2 pr-7 border border-transparent bg-transparent text-slate-500 sm:text-sm rounded-md focus:border-purple-500 focus:ring-purple-500 dark:focus:border-purple-500 dark:focus:ring-purple-500"
                                >
                                    <option value="lb">lb</option>
                                    <option value="oz">oz</option>
                                    <option value="kg">kg</option>
                                    <option value="g">g</option>
                                </select>
                            </div>
                        </div>
                        <x-input-error
                            for="variant.weight_value"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <x-input-label
                            for="sku"
                            :value="__('SKU (Stock Keeping Unit)')"
                        />
                        <x-input
                            x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('sku') }}' ? dirty.add('sku') : dirty.delete('sku'))"
                            wire:model.defer="variant.sku"
                            type="text"
                            id="sku"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="variant.sku"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <x-input-label
                            for="barcode"
                            :value="__('Barcode (ISBN, UPC, GTIN, etc.)')"
                        />
                        <x-input
                            x-on:change="$nextTick(() => $el.value !== '{{ $variant->getOriginal('barcode') }}' ? dirty.add('barcode') : dirty.delete('barcode'))"
                            wire:model.defer="variant.barcode"
                            type="text"
                            id="barcode"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="variant.barcode"
                            class="mt-2"
                        />
                    </div>
                </fieldset>
            </x-slot:content>
        </x-card>
    </form>
</div>
