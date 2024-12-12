<div>
    <div x-data="{ selected: @entangle('selected') }">
        <x-card class="overflow-hidden">
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Gallery') }}
                        </h3>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <button
                            x-show="selected.length"
                            x-cloak
                            wire:click="$set('confirmingMediaDeletion', true)"
                            type="button"
                            class="btn p-0 text-red-500 hover:text-red-600 dark:hover:text-red-400"
                        >
                            {{ trans_choice('Delete :count file|Delete :count files', count($selected)) }}
                        </button>
                    </div>
                </div>
            </x-slot:header>
            <x-slot:content class="-mt-5">
                <x-input-error
                    for="media.*"
                    class="mb-2"
                />
                <div @class(['grid grid-cols-3 lg:grid-cols-4 gap-4 auto-rows-fr' => $product->hasMedia('gallery')])>
                    @foreach($product->getMedia('gallery') as $medium)
                        <div @class(['relative overflow-hidden border border-slate-200 group rounded-md flex items-center justify-center dark:border-slate-200/20', 'col-start-1 col-span-2 row-span-2' => $loop->first])>
                            <img
                                src="{{ $medium->getUrl() }}"
                                alt="{{ $medium->name }}"
                                class="h-full w-full object-cover object-center transition group-hover:scale-125"
                            />
                            <div class="absolute inset-0 group-hover:bg-opacity-50 group-hover:bg-slate-600 rounded-md transition-all"></div>
                            <x-input
                                wire:model="selected"
                                type="checkbox"
                                class="absolute top-2 left-2 !rounded !shadow-none dark:!bg-slate-900 dark:checked:!bg-purple-500"
                                x-bind:class="{ 'opacity-0 group-hover:opacity-100': !selected.length }"
                                value="{{ $medium->id }}"
                            />
                        </div>
                    @endforeach
                    <label
                        for="mediaUpload"
                        class="py-4 relative flex items-center justify-center border-2 border-slate-300 border-dashed rounded-md hover:border-slate-400 cursor-pointer transition group dark:border-slate-700 dark:hover:border-slate-600"
                    >
                        <div
                            wire:target="media"
                            wire:loading.flex
                            class="hidden absolute inset-0 flex items-center justify-center bg-white dark:bg-slate-850"
                        >
                            <x-loading-spinner class="h-10 w-10 text-purple-500" />
                        </div>
                        <div class="space-y-1 text-center">
                            <x-heroicon-m-arrow-up-tray class="mx-auto h-10 w-10 text-slate-400" />
                            <div class="flex text-sm text-slate-600">
                                <span class="font-medium text-purple-600 group-hover:text-purple-500 group-hover:underline dark:group-hover:text-purple-400">{{ __('Upload') }}</span>
                                <x-input
                                    wire:model="media"
                                    type="file"
                                    id="mediaUpload"
                                    class="sr-only"
                                    multiple
                                />
                            </div>
                        </div>
                    </label>
                </div>
            </x-slot:content>
        </x-card>
    </div>
    <x-modal-alert wire:model.defer="confirmingMediaDeletion">
        <x-slot:title>
            {{ __('Please confirm your action!') }}
        </x-slot:title>
        <x-slot:content>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ trans_choice('Are you sure you want to delete :count file?|Are you sure you want to delete :count files?', count($selected)) }}
                {{ __('This action cannot be undone!') }}
            </p>
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click.prevent="delete"
                type="button"
                class="btn btn-danger w-full sm:ml-3 sm:w-auto"
            >
                {{ __('Delete') }}
            </button>
            <button
                wire:click="$set('confirmingMediaDeletion', false)"
                type="button"
                class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>
</div>
