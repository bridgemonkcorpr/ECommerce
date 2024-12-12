<div>
    <form wire:submit.prevent="save">
        <x-modal-dialog
            wire:model.defer="isShown"
            max-width="md"
        >
            <x-slot name="title">
                {{ $taxRate->exists ? __('Edit rate') : __('Add rate') }}
            </x-slot>
            <x-slot name="content">
                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <x-input-label
                                for="taxRateName"
                                :value="__('Rate name')"
                            />
                            <x-input
                                wire:model.defer="taxRate.name"
                                type="text"
                                id="taxRateName"
                                class="mt-1 block w-full sm:text-sm"
                            />
                            <x-input-error
                                for="taxRate.name"
                                class="mt-2"
                            />
                            <p class="mt-2 text-sm text-purple-600">{{ __('Customers will see this at checkout.') }}</p>
                        </div>
                        <div class="sm:col-span-1">
                            <x-input-label
                                for="taxRatePercentage"
                                :value="__('Percentage')"
                            />
                            <x-input
                                wire:model.defer="taxRate.percentage"
                                type="number"
                                id="taxRatePercentage"
                                step="any"
                                class="mt-1 block w-full sm:text-sm"
                            />
                            <x-input-error
                                for="taxRate.percentage"
                                class="mt-2"
                            />
                        </div>
                        <div class="sm:col-span-1">
                            <x-input-label
                                for="taxRatePriority"
                                :value="__('Priority')"
                            />
                            <x-input
                                wire:model.defer="taxRate.priority"
                                type="number"
                                id="taxRatePriority"
                                class="mt-1 block w-full sm:text-sm"
                            />
                            <x-input-error
                                for="taxRate.priority"
                                class="mt-2"
                            />
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div>
                    <button
                        wire:click="$set('isShown', false)"
                        type="button"
                        class="btn btn-invisible text-purple-600"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary bg-purple-600 hover:bg-purple-700"
                    >
                        {{ __('Save') }}
                    </button>
                </div>
            </x-slot>
        </x-modal-dialog>
    </form>
</div>
