<div class="flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-[#FBF4E4] to-[#F8E1F9] ">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-1/3 h-1/3 bg-[#FBEAE9] rounded-br-[80%] opacity-60 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-1/2 h-1/2 bg-[#F8E1F9] rounded-tl-[80%] opacity-60 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/4 right-1/4 w-48 h-48 bg-[#D3D5EE] rounded-full opacity-40 animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-[#E6E9F8] rounded-full opacity-40 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#D4E3F9]/20 via-transparent to-[#CEF6F8]/20"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 w-full max-w-2xl px-6 py-10">
        <form wire:submit.prevent="save" class="transform transition-all duration-300 hover:scale-105">
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/50">
                <!-- Header -->
                <div class="border-b border-slate-200 p-8">
                    <h3 class="text-3xl font-bold text-[#4A5568] mb-2 animate-fade-in">
                        {{ __('Store Information') }}
                    </h3>
                    <p class="text-sm text-slate-500 animate-fade-in-delay">
                        {{ __('Provide some basic information to bootstrap your store.') }}
                    </p>
                </div>

                <!-- Content -->
                <div class="p-8 space-y-6">
                    <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                        <label for="storeNameInput" class="block text-sm font-medium text-[#4A5568] mb-2">
                            {{ __('Store Name') }}
                        </label>
                        <input
                            wire:model.defer="state.store_name"
                            type="text"
                            id="storeNameInput"
                            class="block w-full rounded-md border-slate-300 bg-white/50 text-[#4A5568] placeholder-slate-400 shadow-sm focus:border-[#9370DB] focus:ring-[#9370DB] sm:text-sm transition-all duration-300"
                            placeholder="{{ __('My Store') }}"
                        />
                        <x-input-error for="state.store_name" class="mt-2" />
                    </div>

                    <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                        <label for="storeSloganInput" class="block text-sm font-medium text-[#4A5568] mb-2">
                            {{ __('Slogan') }}
                        </label>
                        <input
                            wire:model.defer="state.store_slogan"
                            type="text"
                            id="storeSloganInput"
                            class="block w-full rounded-md border-slate-300 bg-white/50 text-[#4A5568] placeholder-slate-400 shadow-sm focus:border-[#9370DB] focus:ring-[#9370DB] sm:text-sm transition-all duration-300"
                            placeholder="{{ __('Your store slogan') }}"
                        />
                        <x-input-error for="state.store_slogan" class="mt-2" />
                    </div>

                    <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                        <label for="storeEmailInput" class="block text-sm font-medium text-[#4A5568] mb-2">
                            {{ __('Store Email Address') }}
                        </label>
                        <input
                            wire:model.defer="state.store_contact_email"
                            type="email"
                            id="storeEmailInput"
                            class="block w-full rounded-md border-slate-300 bg-white/50 text-[#4A5568] placeholder-slate-400 shadow-sm focus:border-[#9370DB] focus:ring-[#9370DB] sm:text-sm transition-all duration-300"
                            placeholder="{{ __('contact@yourstore.tld') }}"
                        />
                        <x-input-error for="state.store_contact_email" class="mt-2" />
                    </div>

                    <div class="animate-fade-in-up" style="animation-delay: 0.5s;">
                        <label for="storeContactPhoneInput" class="block text-sm font-medium text-[#4A5568] mb-2">
                            {{ __('Contact Phone Number') }}
                        </label>
                        <input
                            wire:model.defer="state.store_contact_phone"
                            type="text"
                            id="storeContactPhoneInput"
                            class="block w-full rounded-md border-slate-300 bg-white/50 text-[#4A5568] placeholder-slate-400 shadow-sm focus:border-[#9370DB] focus:ring-[#9370DB] sm:text-sm transition-all duration-300"
                            placeholder="{{ __('+1 (555) 123-4567') }}"
                        />
                        <x-input-error for="state.store_contact_phone" class="mt-2" />
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-slate-50/50 px-8 py-6">
                    <button
                        type="submit"
                        class="btn bg-gradient-to-r from-[#6A5ACD] to-[#9370DB] hover:from-[#5B4FCF] hover:to-[#8A62E6] text-white font-semibold py-3 px-6 rounded-lg w-full transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg animate-fade-in-up"
                        style="animation-delay: 0.6s;"
                    >
                        {{ __('Save and Continue') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
