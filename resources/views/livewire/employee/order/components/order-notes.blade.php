<div>
    <x-card>
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Notes') }}
                    </h3>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <button
                        wire:click="$toggle('isEditing')"
                        type="button"
                        class="btn btn-link  text-purple-600"
                    >
                        {{ $isEditing ? __('Cancel') : __('Edit') }}
                    </button>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            @unless($isEditing)
                <p @class(['sm:text-sm', 'text-slate-900 dark:text-slate-200' => $order->notes, 'text-slate-500 dark:text-slate-400' => !$order->notes])>
                    {{ $order->notes ?? __('No notes from customer') }}
                </p>
            @else
                <form wire:submit.prevent="save">
                    <fieldset
                        wire:target="save"
                        wire:loading.attr="disabled"
                    >
                        <x-textarea
                            wire:model.defer="order.notes"
                            class="mt-1 block w-full sm:text-sm"
                            rows="3"
                            placeholder="{{ __('Add a note') }}"
                        />
                        <div class="mt-4 flex justify-end">
                            <button
                                type="submit"
                                class="btn btn-primary bg-purple-600 hover:bg-purple-700"
                            >
                                {{ __('Save changes') }}
                            </button>
                        </div>
                    </fieldset>
                </form>
            @endunless
        </x-slot:content>
    </x-card>
</div>
