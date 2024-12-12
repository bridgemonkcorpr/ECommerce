<div
    x-data="{ isDragging: false, isUploading: false, progress: 0 }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
    x-on:drop.prevent="isUploading = true; $wire.upload('{{ $attributes->get('wire:model') }}', $event.dataTransfer.files[0], finishCallback = () => { isUploading = false }, errorCallback = () => { isUploading = false }, progressCallback = (event) => { progress = event.detail.progress });"
    x-on:dragover.prevent="isDragging = true"
    x-on:dragleave.prevent="isDragging = false"
    class="h-full w-full"
>
    <label
        for="fileInput"
        class="group h-full w-full py-4 relative flex items-center justify-center border-2 border-dashed rounded-md transition"
        :class="{ 'border-slate-300 dark:border-slate-700': !isDragging, 'border-slate-400 dark:border-slate-600': isDragging, 'cursor-pointer hover:border-slate-400 dark:hover:border-slate-600': !isUploading }"
    >
        <div
            x-show="isUploading"
            class="absolute inset-0 flex flex-col items-center justify-center bg-white dark:bg-slate-850"
        >
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-200">
                <span>{{ __('Uploading...') }}</span>
                <span x-text="progress + '%'">0</span>
            </p>
            <div class="absolute -bottom-0.5 w-full overflow-hidden rounded-md bg-slate-200">
                <div
                    class="h-0.5 rounded-full bg-gradient-to-r from-purple-500 to-purple-500"
                    x-bind:style="'width: ' + progress + '%'"
                ></div>
            </div>
        </div>
        <div class="space-y-1 text-center">
            <x-heroicon-m-arrow-up-tray class="mx-auto h-10 w-10 text-slate-400" />
            <div class="flex text-sm">
                <p>
                    <span class="font-medium text-purple-500 group-hover:text-purple-600 dark:group-hover:text-purple-400">{{ __('Upload a file') }}</span>
                    <span class="text-slate-500 dark:text-slate-400"> {{ __('or drag and drop') }}</span>
                </p>
                <x-input
                    {{ $attributes }}
                    type="file"
                    id="fileInput"
                    class="sr-only"
                    x-ref="file"
                    x-bind:disabled="isUploading"
                />
            </div>
        </div>
    </label>
</div>
