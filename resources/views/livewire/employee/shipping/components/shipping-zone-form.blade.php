<div>
    <form wire:submit.prevent="save">
        <x-modal-dialog wire:model.defer="isShown">
            <x-slot:title>
                {{ $this->shippingZone->exists ? __('Edit zone') : __('Create zone') }}
            </x-slot:title>
            <x-slot:content>
                <div class="space-y-5">
                    <div>
                        <x-input-label
                            for="shippingZoneName"
                            :value="__('Zone name')"
                        />
                        <x-input
                            wire:model.defer="shippingZone.name"
                            type="text"
                            id="shippingZoneName"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        @if($errors->has('shippingZone.name'))
                            <x-input-error
                                for="shippingZone.name"
                                class="mt-2"
                            />
                        @else
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                {{ __('Customers won’t see this') }}
                            </p>
                        @endif
                    </div>

                    <hr class="-mx-4 sm:-mx-6 border-slate-300 dark:border-slate-200/20">

                    <div
                        x-data="{ search: @entangle('search')}"
                        class="relative text-slate-500 focus-within:text-slate-600 dark:focus-within:text-slate-300"
                    >
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                        </div>
                        <x-input
                            wire:model.debounce.500ms="search"
                            type="text"
                            class="placeholder-slate-500 w-full pl-10 sm:text-sm focus:placeholder-slate-400 dark:focus:placeholder-slate-600"
                            ::class="{ 'pr-10' : search }"
                            placeholder="{{ __('Search countries') }}"
                        />
                        <button
                            x-show="search.length"
                            x-on:click="search = ''"
                            type="button"
                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                        >
                            <x-heroicon-s-x-circle class="w-5 h-5 text-slate-500 hover:text-slate-600 dark:hover:text-slate-400" />
                        </button>
                    </div>

                    @if($errors->has('selectedCountries'))
                        <x-alert
                            type="error"
                            :message="$errors->first('selectedCountries')"
                        />
                    @endif

                    <div class="mt-4 -mx-6 border-t border-b border-slate-300 divide-y divide-slate-200 max-h-80 overflow-y-auto dark:border-slate-200/20 dark:divide-slate-200/10">
                        @foreach($countries as $country)
                            <label class="relative flex items-start px-4 py-4 sm:px-6 hover:bg-slate-50 cursor-pointer dark:hover:bg-slate-700/25">
                                <div class="flex items-center h-5">
                                    <x-input
                                        type="checkbox"
                                        wire:model.defer="selectedCountries"
                                        id="country-{{ $country['id'] }}"
                                        value="{{ $country['id'] }}"
                                        class="!rounded !shadow-none"
                                        :disabled="!$this->shippingZone->exists && in_array($country['id'], $this->countriesInAnotherZones) || $this->shippingZone->exists && in_array($country['id'], $this->countriesInAnotherZones) && !in_array($country['id'], $shippingZone->countries->pluck('country_id')->toArray())"
                                    />
                                </div>
                                <div class="ml-3 flex flex-1 items-center justify-between text-sm">
                                    <span>
                                        {{ $country['name'] }}
                                    </span>
                                    @if(!$this->shippingZone->exists && in_array($country['id'], $this->countriesInAnotherZones) || $this->shippingZone->exists && in_array($country['id'], $this->countriesInAnotherZones) && !in_array($country['id'], $shippingZone->countries->pluck('country_id')->toArray()))
                                        <span class="text-slate-500">{{ __('In another zone') }}</span>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </x-slot:content>
            <x-slot:footer>
                <div>
                    <button
                        wire:click="$set('isShown', false)"
                        type="button"
                        class="btn btn-invisible text-purple-600"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary bg-purple-600 hover:bg-purple-700"
                    >
                        {{ __('Save') }}
                    </button>
                </div>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
