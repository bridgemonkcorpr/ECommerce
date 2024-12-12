<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-slate-900/10 pb-12 md:grid-cols-3">
            <div>
                <h2 class="text-base font-semibold leading-7 text-slate-900 dark:text-slate-200">
                    {{ __('Profile') }}
                </h2>
                <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-400">
                    {{ __('This information will be displayed publicly so be careful what you share.') }}
                </p>
            </div>
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                <div class="col-span-full">
                    <div class="flex items-center gap-x-8">
                        @if($avatarFile)
                            <img
                                src="{{ $avatarFile->temporaryUrl() }}"
                                alt=""
                                class="h-24 w-24 flex-none rounded-lg bg-slate-100 object-cover dark:bg-slate-800"
                            />
                        @else
                            <img
                                src="{{ auth()->user()->getFirstMediaUrl('avatar') }}"
                                alt=""
                                class="h-24 w-24 flex-none rounded-lg bg-slate-100 object-cover dark:bg-slate-800"
                            >
                        @endif
                        <div x-data>
                            <x-input
                                wire:model="avatarFile"
                                x-ref="avatarInput"
                                type="file"
                                class="sr-only"
                            />
                            <button
                                x-on:click="$refs.avatarInput.click()"
                                type="button"
                                class="btn btn-default"
                            >
                                {{ __('Change avatar') }}
                            </button>
                            <p class="mt-2 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                {{ __('JPG, GIF or PNG. 1MB max.') }}
                            </p>
                        </div>
                    </div>
                    <x-input-error
                        for="avatarFile"
                        class="mt-2"
                    />
                </div>
                <div class="sm:col-span-3">
                    <x-input-label
                        for="nameInput"
                        :value="__('Your name')"
                    />
                    <x-input
                        wire:model.defer="state.name"
                        type="text"
                        id="nameInput"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="state.name"
                        class="mt-2"
                    />
                </div>
                <div class="sm:col-span-3">
                    <x-input-label
                        for="emailInput"
                        :value="__('Email address')"
                    />
                    <x-input
                        wire:model.defer="state.email"
                        type="email"
                        id="emailInput"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="state.email"
                        class="mt-2"
                    />
                </div>
                <div class="sm:col-span-4">
                    <x-input-label
                        for="websiteInput"
                        :value="__('Website')"
                    />
                    <x-input
                        wire:model.defer="state.website"
                        type="text"
                        id="websiteInput"
                        class="mt-1 block w-full sm:text-sm"
                        placeholder="https://www.example.org"
                    />
                    <x-input-error
                        for="state.website"
                        class="mt-2"
                    />
                </div>
                <div class="col-span-full">
                    <x-input-label
                        for="bioInput"
                        :value="__('Bio')"
                    />
                    <x-textarea
                        wire:model.defer="state.bio"
                        id="bioInput"
                        class="mt-1 block w-full sm:text-sm"
                        :placeholder="__('Write a few sentences about yourself')"
                    />
                </div>
                <div class="col-span-full">
                    <button class="btn btn-primary bg-purple-600 hover:bg-purple-700">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
