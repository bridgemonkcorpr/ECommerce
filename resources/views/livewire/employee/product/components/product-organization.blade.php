<div
    x-data="{ dirty: false, original: @json($selectedCollections), selected: @json($selectedCollections) }"
    x-init="$watch('selected', () => dirty = selected.sort().toString() !== original.sort().toString())"
    x-on:saved.window="dirty = false; original = selected"
>
    <x-card class="overflow-hidden">
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Collection') }}
                    </h3>
                </div>
                <div
                    x-show="dirty"
                    class="ml-4 mt-2 flex-shrink-0"
                >
                    <button
                        wire:target="save"
                        wire:loading.delay.attr="disabled"
                        wire:click.prevent="save"
                        class="btn btn-link  text-purple-600"
                    >
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            <div class="-mx-4 -mb-5 border-t border-slate-300 max-h-72 overflow-y-auto sm:-mx-6 dark:border-slate-200/20">
                @if($this->collections->count())
                    <ul class="divide-y divide-slate-200 dark:divide-slate-200/10">
                        @foreach($this->collections as $collection)
                            <div class="relative flex items-start p-4 sm:px-6 hover:bg-slate-50 dark:hover:bg-slate-800">
                                <span
                                    onclick="event.preventDefault(); document.querySelector('#collection-{{ $collection->id }}').click()"
                                    class="absolute inset-0 cursor-pointer"
                                ></span>
                                <div class="min-w-0 flex-1 text-sm">
                                    <x-input-label
                                        for="collection-{{ $collection->id }}"
                                        :value="$collection->title"
                                    />
                                </div>
                                <div class="ml-3 flex items-center h-5">
                                    <x-input
                                        x-model.number="selected"
                                        wire:model.defer="selectedCollections"
                                        id="collection-{{ $collection->id }}"
                                        type="checkbox"
                                        value="{{ $collection->id }}"
                                        class="h-4 w-4 !rounded !shadow-none"
                                    />
                                </div>
                            </div>
                        @endforeach
                    </ul>
                @else
                    <p class="my-6 text-center text-sm">
                        {{ __('No collections available.') }}
                    </p>
                @endif
            </div>
        </x-slot:content>
    </x-card>
</div>
