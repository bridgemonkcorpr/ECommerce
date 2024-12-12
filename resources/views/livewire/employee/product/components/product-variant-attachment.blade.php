<div x-data>
    <x-card class="relative overflow-hidden">
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Digital Attachment') }}
                    </h3>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            @if($variant->hasMedia('attachment'))
                {{-- do not remove fix for livewire re-render causing alpinejs error --}}
                <hr class="hidden" />
                {{-- do not remove end fix--}}
                <x-card class="!shadow-none">
                    <x-slot:content>
                        <div class="relative flex items-center space-x-3">
                            <div class="min-w-0 flex flex-1 items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-200">
                                        {{ $variant->getFirstMedia('attachment')->file_name }}
                                    </p>
                                    <p class="truncate text-sm text-slate-500 dark:text-slate-400">
                                        {{ $variant->getFirstMedia('attachment')->human_readable_size }}
                                    </p>
                                </div>
                                <div class="ml-4 flex items-center space-x-2 flex-shrink-0">
                                    <button
                                        wire:click="download"
                                        type="button"
                                        class="font-medium text-purple-500 hover:text-purple-600 dark:hover:text-purple-400"
                                        data-tippy-content="{{ __('Download') }}"
                                    >
                                        <span class="sr-only">{{ __('Download') }}</span>
                                        <x-heroicon-m-arrow-down-tray class="w-5 h-5" />
                                    </button>
                                    <button
                                        x-on:click.prevent="if(confirm('{{ __('Are you sure you want to delete this attachment?') }}')) $wire.delete();"
                                        type="button"
                                        class="font-medium text-red-500 hover:text-red-600 dark:hover:text-red-400"
                                        data-tippy-content="{{ __('Remove') }}"
                                    >
                                        <span class="sr-only">{{ __('Remove') }}</span>
                                        <x-heroicon-m-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-slot:content>
                </x-card>
            @else
                <x-upload-widget wire:model="attachment" />
            @endif
        </x-slot:content>
    </x-card>
</div>
