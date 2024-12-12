<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-slate-900/10 pb-12 md:grid-cols-3">
            <div>
                <h2 class="text-base font-semibold leading-7 text-slate-900 dark:text-slate-200">
                    {{ __('Personal information') }}
                </h2>
            </div>
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                <div class="sm:col-span-4">
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
                <div class="sm:col-span-4">
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
                <div class="col-span-full">
                    <button class="btn btn-primary bg-purple-600 hover:bg-purple-700">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
