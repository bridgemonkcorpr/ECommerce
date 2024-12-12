<div>
    <form wire:submit.prevent="save">
        <x-card class="relative overflow-hidden">
            <x-slot:content>
                <fieldset
                    wire:target="save"
                    wire:loading.delay.attr="disabled"
                    class="grid grid-cols-1 gap-4"
                >
                    {{-- Title --}}
                    <div>
                        <x-input-label
                            for="title"
                            :value="__('Title')"
                        />
                        <x-input
                            wire:model.lazy="collection.title"
                            id="title"
                            type="text"
                            name="title"
                            class="mt-1 block w-full sm:text-sm"
                            :placeholder="__('Enter collection name')"
                        />
                        <x-input-error
                            for="collection.title"
                            class="mt-2"
                        />
                    </div>

                    {{-- Slug --}}
                    <div>
                        <x-input-label
                            for="slug"
                            :value="__('URL handle')"
                        />

                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-slate-300 bg-slate-50 px-3 text-slate-500 sm:text-sm dark:bg-slate-800 dark:border-slate-200/20">
                                {{ config('app.url') }}/collections/
                            </span>
                            <x-input
                                wire:model.defer="collection.slug"
                                type="text"
                                id="slug"
                                class="block w-full min-w-0 flex-1 !rounded-l-none !shadow-none sm:text-sm"
                            />
                        </div>

                        <x-input-error
                            for="collection.slug"
                            class="mt-2"
                        />
                    </div>

                    {{-- Description --}}
                    <div>
                        <x-input-label
                            for="description"
                            :value="__('Description')"
                        />
                        <div class="mt-1 border border-slate-300 rounded-md px-4 shadow-sm dark:border-slate-200/20 dark:bg-slate-900">
                            <x-tiptap
                                wire:target="save"
                                wire:loading.delay.class="opacity-50"
                                wire:model="collection.description"
                            />
                        </div>
                        <x-input-error
                            for="collection.description"
                            class="mt-2"
                        />
                    </div>
                </fieldset>
            </x-slot:content>
            <x-slot:footer>
                <div class="flex items-center justify-end">
                    <button
                        wire:target="save"
                        wire:loading.attr="disabled"
                        type="submit"
                        class="btn btn-primary bg-purple-600 hover:bg-purple-700"
                    >
                        {{ __('Save changes') }}
                    </button>
                </div>
            </x-slot:footer>
        </x-card>
    </form>

    <div
        x-data="{ addFromURL: false, selectedImage: null }"
        x-on:upload-image-success.window="addFromURL = false; selectedImage = $event.detail.imageId;"
    >
        <x-modal-dialog wire:model.defer="showImageModal">
            <x-slot:title>
                {{ __('Media') }}
            </x-slot:title>
            <x-slot:content>
                <div
                    x-show="!addFromURL"
                    x-transition:enter.duration.150ms
                    x-transition:leave.duration.50ms
                >
                    <div class="inline-flex rounded-md">
                        <button
                            x-on:click="$refs.imageInput.click()"
                            type="button"
                            class="relative inline-flex items-center rounded-l-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 focus:z-10 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500 dark:bg-slate-700 dark:border-slate-500 dark:text-slate-200 dark:focus:ring-purple-400 dark:focus:border-purple-400 dark:hover:border-slate-400 dark:focus:ring-offset-slate-800"
                        >
                            <x-heroicon-m-photo class="-ml-1 mr-2 w-5 h-5" />
                            {{ __('Add new') }}
                        </button>
                        <div class="relative -ml-px block">
                            <x-dropdown align="left">
                                <x-slot:trigger>
                                    <button
                                        type="button"
                                        class="relative inline-flex items-center rounded-r-md border border-slate-300 bg-white px-2 py-2 text-sm font-medium text-slate-500 hover:bg-slate-50 focus:z-10 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500 dark:bg-slate-700 dark:border-slate-500 dark:text-slate-200 dark:focus:ring-purple-400 dark:focus:border-purple-400 dark:hover:border-slate-400 dark:focus:ring-offset-slate-800"
                                    >
                                        <span class="sr-only">
                                            {{ __('Open options') }}
                                        </span>
                                        <x-heroicon-m-chevron-down class="h-5 w-5" />
                                    </button>
                                </x-slot:trigger>
                                <x-slot:content>
                                    <x-dropdown-link
                                        x-on:click="addFromURL = !addFromURL"
                                        role="button"
                                    >
                                        {{ __('Add from URL') }}
                                    </x-dropdown-link>
                                </x-slot:content>
                            </x-dropdown>
                        </div>
                        <button
                            x-show="selectedImage"
                            x-on:click.prevent="if(confirm('{{ __('Are you sure you want to delete this image?') }}')) $wire.deleteImage(selectedImage); selectedImage = null;"
                            type="button"
                            class="btn btn-outline-danger ml-4"
                        >
                            <x-heroicon-m-trash class="h-5 w-5" />
                        </button>
                    </div>
                    <x-input
                        wire:model.defer="image"
                        x-ref="imageInput"
                        type="file"
                        class="hidden"
                    />
                </div>
                <div
                    x-show="addFromURL"
                    x-transition:enter.duration.150ms
                    x-transition:leave.duration.50ms
                >
                    <form wire:submit.prevent="uploadImageFromURL">
                        <fieldset wire:loading.attr="disabled">
                            <x-input-label
                                for="imageUrl"
                                class="sr-only"
                            >
                                {{ __('Image URL') }}
                            </x-input-label>
                            <div class="flex items-center">
                                <div class="flex flex-1 rounded-md">
                                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                        <x-input
                                            wire:model.defer="imageUrl"
                                            type="text"
                                            id="imageUrl"
                                            class="block w-full !rounded-r-none sm:text-sm"
                                            placeholder="https://"
                                        />
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-primary bg-purple-600 hover:bg-purple-700 !rounded-l-none"
                                    >
                                        <x-heroicon-m-arrow-up-tray class="-ml-1 mr-2 h-5 w-5 text-white dark:text-slate-200" />
                                        <span>{{ __('Upload') }}</span>
                                    </button>
                                </div>
                                <button
                                    x-on:click="addFromURL = false"
                                    type="button"
                                    class="ml-3 inline-flex items-center py-2"
                                >
                                    <x-heroicon-m-x-mark class="w-5 h-5" />
                                </button>
                            </div>
                            <x-input-error
                                for="imageUrl"
                                class="mt-2"
                            />
                        </fieldset>
                    </form>
                </div>
                <ul class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    <li
                        wire:target="image, imageUrl"
                        wire:loading
                        class="relative"
                    >
                        <div class="block w-full aspect-w-10 aspect-h-7 rounded-lg bg-slate-100 overflow-hidden dark:bg-slate-700">
                            <x-loading-spinner class="absolute inset-0 m-auto w-5 h-5" />
                        </div>
                    </li>
                    @foreach ($this->collection->getMedia('images')->reverse() as $image)
                        <li class="relative">
                            <div
                                class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-slate-100 overflow-hidden"
                                :class="{ 'ring-2 ring-offset-2 ring-purple-500 dark:ring-offset-slate-800': selectedImage === {{ $image->id }} }"
                            >
                                <img
                                    src="{{ $image->getUrl() }}"
                                    alt="{{ $image->name }}"
                                    class="object-cover pointer-events-none"
                                    :class="{ 'group-hover:opacity-75': selectedImage !== {{ $image->id }} }"
                                >
                                <button
                                    x-on:click="selectedImage = {{ $image->id }}"
                                    class="absolute inset-0 focus:outline-none"
                                >
                                    <span class="sr-only">
                                        {{ __('Select this image') }}
                                    </span>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </x-slot:content>
            <x-slot:footer>
                <button
                    x-bind:disabled="!selectedImage"
                    x-on:click="$wire.insertImage(selectedImage); selectedImage = null"
                    type="button"
                    class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full sm:ml-3 sm:w-auto"
                >
                    {{ __('Insert') }}
                </button>
                <button
                    x-on:click="$wire.set('showImageModal', false)"
                    type="button"
                    class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </div>
</div>
