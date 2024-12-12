@props(['id', 'maxWidth'])

@php
    $id = $id ?? md5($attributes->wire('model'));

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth ?? 'lg'];
@endphp

<div
    x-cloak
    x-data="{ show: @entangle($attributes->wire('model')).defer }"
    x-show="show"
    x-trap.noreturn.noscroll="show"
    x-on:keydown.escape.window="show = false"
    class="relative z-10"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true"
>
    <div
        x-cloak
        x-show="show"
        x-transition:enter="transition ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur"
    ></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div
                    x-cloak
                    x-show="show"
                    x-transition:enter="transform transition ease-in-out duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-300"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    x-on:click.away="show = false"
                    class="pointer-events-auto w-screen max-w-md"
                >
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl dark:bg-slate-800">
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2
                                    class="text-lg font-medium text-slate-900 dark:text-slate-200"
                                    id="slide-over-title"
                                >
                                    {{ $title }}
                                </h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button
                                        x-on:click="show = false"
                                        type="button"
                                        class="-m-2 p-2 text-slate-400 hover:text-slate-500"
                                    >
                                        <span class="sr-only">{{ __('Close panel') }}</span>
                                        <x-heroicon-m-x-mark class="h-6 w-6" />
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                {{ $content }}
                            </div>
                        </div>

                        @isset($footer)
                            <div class="border-t border-slate-200 p-4 sm:px-6 dark:border-white/10">
                                {{ $footer }}
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

