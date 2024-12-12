@props(['id' => null, 'maxWidth' => null])

<x-modal
    :id="$id"
    :maxWidth="$maxWidth"
    {{ $attributes }}
>
    <div class="sm:flex sm:items-start">
        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
        </div>
        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3
                class="font-display font-medium text-lg text-slate-900 leading-6 dark:text-slate-200"
                id="modal-title"
            >
                {{ $title }}
            </h3>
            <div class="mt-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ $content }}
                </p>
            </div>
        </div>
    </div>
    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
        {{ $footer }}
    </div>
</x-modal>
