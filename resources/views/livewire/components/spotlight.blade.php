<div
    x-data="{ searchOpen: false }"
    x-on:keydown.slash.window="if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA' && !document.activeElement.isContentEditable) searchOpen = true"
>
    <div
        x-cloak
        x-show="searchOpen"
        x-trap.noreturn="searchOpen"
        x-on:open-search.window="searchOpen = true"
        x-on:keydown.escape="searchOpen = false"
        class="relative z-[60]"
        role="dialog"
        aria-modal="true"
    >
        <div
            x-show="searchOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur"
        ></div>

        <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
            <div
                x-show="searchOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                x-on:click.away="searchOpen = false"
                class="mx-auto max-w-xl transform divide-y divide-slate-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all dark:bg-slate-800 dark:divide-white/10 dark:ring-1 dark:ring-slate-700"
            >
                <div class="relative">
                    <x-heroicon-o-magnifying-glass class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-slate-400" />
                    <label
                        for="search"
                        class="sr-only"
                    >
                        {{ __('Search') }}
                    </label>
                    <input
                        wire:model.debounce.500ms="query"
                        type="search"
                        id="search"
                        class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-0 sm:text-sm dark:text-white"
                        placeholder="{{ __('Type to search...') }}"
                        autocomplete="off"
                    >
                </div>

                <div
                    wire:loading.delay
                    wire:target="query"
                    class="py-3 px-6 w-full"
                >
                    <div wire:loading.class="w-full">
                        <div class="animate-pulse flex space-x-4">
                            <div class="rounded-lg bg-slate-200 h-10 w-10"></div>
                            <div class="flex-1 space-y-4 py-1">
                                <div class="h-2 bg-slate-200 rounded"></div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($query)
                    <ul
                        wire:loading.delay.remove
                        wire:target="search"
                        class="max-h-96 scroll-py-3 overflow-y-auto p-3"
                        id="options"
                        role="listbox"
                    >
                        @forelse($this->products as $product)
                            <li
                                wire:key="product-{{ $product->id }}"
                                class="relative group flex items-center cursor-default select-none rounded-xl p-3 hover:bg-slate-100 dark:hover:bg-white/5"
                            >
                                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-slate-200 dark:bg-slate-800">
                                    <img
                                        src="{{ $product->getFirstMediaUrl('gallery', 'thumb_large') }}"
                                        alt="{{ $product->name }}"
                                        class="rounded-md"
                                    >
                                </div>
                                <div class="ml-4 flex-auto">
                                    <a
                                        href="{{ $searchFromAdmin ? route('employee.products.detail', $product->id) : route('guest.products.detail', $product->slug) }}"
                                        class="text-sm font-medium text-slate-700 group-hover:text-slate-900 dark:text-slate-200 dark:group-hover:text-white"
                                    >
                                        <span class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                    <p class="text-sm text-slate-500 group-hover:text-slate-700 dark:text-slate-400 dark:group-hover:text-slate-200">
                                        <x-money :amount="$product->price" />
                                    </p>
                                </div>
                            </li>
                        @empty
                            <div class="px-6 py-14 text-center text-sm sm:px-14">
                                <x-heroicon-o-information-circle class="mx-auto h-6 w-6 text-slate-400" />
                                <p class="mt-4 font-semibold text-slate-900 dark:text-slate-200">
                                    {{ __('No results found') }}
                                </p>
                                <p class="mt-2 text-slate-500 dark:text-slate-400">
                                    {{ __('Try adjusting your search or filter to find what you\'re looking for.') }}
                                </p>
                            </div>
                        @endforelse
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
