<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-slate-900/10 pb-12 md:grid-cols-3">
            <div>
                <h2 class="text-base font-semibold leading-7 text-slate-900 dark:text-slate-200">
                    {{ __('Change password') }}
                </h2>
                <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-400">
                    {{ __('Update your password associated with your account.') }}
                </p>
            </div>
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                <div class="col-span-full">
                    <x-input-label
                        for="currentPasswordInput"
                        :value="__('Current password')"
                    />
                    <x-input
                        wire:model.defer="state.current_password"
                        type="password"
                        id="currentPasswordInput"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="state.current_password"
                        class="mt-2"
                    />
                </div>
                <div class="col-span-full">
                    <x-input-label
                        for="newPasswordInput"
                        :value="__('New password')"
                    />
                    <x-input
                        wire:model.defer="state.password"
                        type="password"
                        id="newPasswordInput"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="state.password"
                        class="mt-2"
                    />
                </div>
                <div class="col-span-full">
                    <x-input-label
                        for="confirmNewPasswordInput"
                        :value="__('Confirm password')"
                    />
                    <x-input
                        wire:model.defer="state.password_confirmation"
                        type="password"
                        id="confirmNewPasswordInput"
                        class="mt-1 block w-full sm:text-sm"
                    />
                    <x-input-error
                        for="state.password_confirmation"
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
