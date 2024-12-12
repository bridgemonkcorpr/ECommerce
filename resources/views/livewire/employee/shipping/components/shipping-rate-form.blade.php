<div>
    <form wire:submit.prevent="save">
        <x-modal-dialog wire:model.defer="isShown">
            <x-slot:title>
                {{ $shippingRate->exists ? __('Edit rate') : __('Add rate') }}
            </x-slot:title>
            <x-slot:content>
                <div x-data="{ hasConditions: @entangle('hasConditions') }">
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="sm:col-span-1">
                                <x-input-label
                                    for="shippingRateName"
                                    :value="__('Rate name')"
                                />
                                <x-input
                                    wire:model.defer="shippingRate.name"
                                    type="text"
                                    id="shippingRateName"
                                    class="mt-1 block w-full sm:text-sm"
                                />
                                @if($errors->has('shippingRate.name'))
                                    <x-input-error
                                        for="shippingRate.name"
                                        class="mt-2"
                                    />
                                @else
                                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Customers will see this at checkout.') }}</p>
                                @endif
                            </div>
                            <div class="sm:col-span-1">
                                <x-input-label
                                    for="shippingRatePrice"
                                    :value="__('Price')"
                                />
                                <x-input-money
                                    wire:model.defer="shippingRate.price"
                                    id="shippingRatePrice"
                                    class="mt-1 block w-full sm:text-sm"
                                />
                                <x-input-error
                                    for="shippingRate.price"
                                    class="mt-2"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label
                                    for="shippingRateDescription"
                                    :value="__('Description')"
                                />
                                <x-input
                                    wire:model.defer="shippingRate.description"
                                    type="text"
                                    id="shippingRateDescription"
                                    class="mt-1 block w-full sm:text-sm"
                                />
                                <x-input-error
                                    for="shippingRate.description"
                                    class="mt-2"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button
                            x-on:click="hasConditions =! hasConditions"
                            type="button"
                            class="btn btn-link  text-purple-600"
                        >
                            <span
                                x-show="!hasConditions"
                                wire:click="addConditions"
                            >
                                {{ __('Add conditions') }}
                            </span>
                            <span
                                x-show="hasConditions"
                                wire:click="removeConditions"
                            >
                                {{ __('Remove conditions') }}
                            </span>
                        </button>
                    </div>
                    <div
                        x-show="hasConditions"
                        class="mt-5 space-y-5"
                    >
                        <div class="flex items-center">
                            <x-input
                                wire:model="shippingRate.based_on"
                                type="radio"
                                id="shippingRateBasedOnItemWeight"
                                name="shippingRateCondition"
                                value="weight"
                                class="!rounded-full !shadow-none"
                            />
                            <x-input-label
                                for="shippingRateBasedOnItemWeight"
                                :value="__('Based on item weight')"
                                class="ml-3"
                            />
                        </div>
                        <div class="flex items-center">
                            <x-input
                                wire:model="shippingRate.based_on"
                                type="radio"
                                id="shippingRateBasedOnOrderPrice"
                                name="shippingRateCondition"
                                value="price"
                                class="!rounded-full !shadow-none"
                            />
                            <x-input-label
                                for="shippingRateBasedOnOrderPrice"
                                :value="__('Based on order price')"
                                class="ml-3"
                            />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="sm:col-span-1">
                                <x-input-label for="shippingRateConditionMinValue">
                                    {{ __('Minimum') }} {{ $shippingRate->based_on }}
                                </x-input-label>
                                @if($shippingRate->based_on == 'weight')
                                    <div class="group mt-1 relative rounded-md shadow-sm">
                                        <x-input
                                            wire:model.defer="shippingRate.min_value"
                                            type="text"
                                            id="shippingRateConditionMinValue"
                                            class="block w-full no-spinners sm:text-sm"
                                        />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-slate-500 sm:text-sm group-focus-within:text-slate-900 dark:group-focus-within:text-slate-300"> kg </span>
                                        </div>
                                    </div>
                                @else
                                    <x-input-money
                                        wire:model.defer="shippingRate.min_value"
                                        id="shippingRateConditionMinValue"
                                        class="mt-1 block w-full sm:text-sm"
                                    />
                                @endif
                                <x-input-error
                                    for="shippingRate.min_value"
                                    class="mt-2"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <x-input-label for="shippingRateConditionMinValue">
                                    {{ __('Maximum') }} {{ $shippingRate->based_on }}
                                </x-input-label>
                                @if($shippingRate->based_on == 'weight')
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <x-input
                                            wire:model.defer="shippingRate.max_value"
                                            type="text"
                                            id="shippingRateConditionMaxValue"
                                            class="block w-full no-spinners sm:text-sm"
                                        />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-slate-500 sm:text-sm group-focus-within:text-slate-900 dark:group-focus-within:text-slate-300"> kg </span>
                                        </div>
                                    </div>
                                @else
                                    <x-input-money
                                        wire:model.defer="shippingRate.max_value"
                                        id="shippingRateConditionMaxValue"
                                        class="mt-1 block w-full sm:text-sm"
                                    />
                                @endif
                                <x-input-error
                                    for="shippingRate.max_value"
                                    class="mt-2"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot:content>
            <x-slot:footer>
                <button
                    type="submit"
                    class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full sm:ml-3 sm:w-auto"
                >
                    {{ __('Save') }}
                </button>
                <button
                    wire:click="$set('isShown', false)"
                    type="button"
                    class="btn btn-invisible text-purple-600 mt-3 w-full sm:mt-0 sm:w-auto"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
