<div>
    <x-card>
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h2 class="text-lg leading-6 font-medium text-purple-900 dark:text-purple-100">
                        {{ __('Notes') }}
                    </h2>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <button
                        wire:click="$set('isEditing', true)"
                        type="button"
                        class="btn btn-link  text-purple-600"
                    >
                        {{ __('Edit') }}
                    </button>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            @unless($customer->notes)
                <p class="text-slate-500 sm:text-sm dark:text-slate-400">
                    {{ __('No notes about this customer') }}
                </p>
            @else
                <p class="text-slate-700 sm:text-sm dark:text-slate-200">
                    {{ $customer->notes }}
                </p>
            @endunless
        </x-slot:content>
    </x-card>

    <form wire:submit.prevent="save">
        <x-modal-dialog
            wire:model.defer="isEditing"
            max-width="xl"
        >
            <x-slot:title>
                {{ __('Edit notes') }}
            </x-slot:title>
            <x-slot:content>
                <fieldset
                    wire:target="save"
                    wire:loading.attr="disabled"
                    class="space-y-6"
                >
                    <div>
                        <x-input-label
                            for="notes"
                            :value="__('Notes')"
                        />
                        <x-textarea
                            wire:model.defer="customer.notes"
                            id="notes"
                            rows="3"
                            class="mt-1 block w-full sm:text-sm"
                            :placeholder="__('Enter notes about this customer')"
                        />
                        <x-input-error
                            for="customer.notes"
                            class="mt-2"
                        />
                    </div>
                </fieldset>
            </x-slot:content>
            <x-slot:footer>
                <div class="flex justify-end">
                    <button
                        wire:click="$set('isEditing', false)"
                        wire:target="save"
                        wire:loading.attr="disabled"
                        type="button"
                        class="btn btn-invisible text-purple-600"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        wire:target="save"
                        wire:loading.attr="disabled"
                        type="submit"
                        class="ml-2 btn btn-primary bg-purple-600 hover:bg-purple-700"
                    >
                        {{ __('Save') }}
                    </button>
                </div>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
