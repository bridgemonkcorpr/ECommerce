<div x-data>
    <x-card class="relative overflow-hidden">
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Image') }}
                    </h3>
                </div>
                @if($collection->hasMedia('cover'))
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <button
                            x-on:click.prevent="if(confirm('{{ __('Are you sure you want to delete this image?') }}')) $wire.delete();"
                            type="button"
                            class="btn p-0 text-red-500 hover:text-red-600 dark:hover:text-red-400"
                        >
                            {{ __('Delete') }}
                        </button>
                    </div>
                @endif
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            <div class="relative aspect-[16/9]">
                @if($collection->hasMedia('cover'))
                    <img
                        src="{{ $collection->getFirstMediaUrl('cover') }}"
                        alt="{{ $collection->title }}"
                        class="absolute inset-0 h-full mx-auto rounded-lg object-cover"
                    >
                @else
                    <x-upload-widget wire:model="image" />
                @endif
            </div>
        </x-slot:content>
    </x-card>
</div>
