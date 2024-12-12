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
    <div class="relative z-10 w-full max-w-3xl px-6 py-10">
        @unless($completed)
            <form wire:submit.prevent="save" class="transform transition-all duration-300 hover:scale-105">
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/50">
                    <!-- Header -->
                    <div class="border-b border-slate-200 p-8">
                        <h3 class="text-3xl font-bold text-[#4A5568] mb-2 animate-fade-in">
                            {{ __('Verify your information') }}
                        </h3>
                        <p class="text-sm text-slate-500 animate-fade-in-delay">
                            {{ __('Please verify your information before continuing.') }}
                        </p>
                    </div>

                    <!-- Content -->
                    <div class="p-2 space-y-6">
                        <dl class="divide-y divide-purple-100">
                            @foreach([
                                'Store name' => $this->store_information_state['store_name'],
                                'Store slogan' => $this->store_information_state['store_slogan'],
                                'Store contact email' => $this->store_information_state['store_contact_email'] ?: __('*Not provided*'),
                                'Store contact phone' => $this->store_information_state['store_contact_phone'] ?: __('*Not provided*'),
                                'Administrator name' => $this->administrator_account_state['administrator_name'],
                                'Administrator email' => $this->administrator_account_state['administrator_email'],
                                'Administrator password' => __('*Hidden*'),
                            ] as $label => $value)
                                <div class="px-3 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                    <dt class="text-sm font-medium text-[#4A5568]">
                                        {{ __($label) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-slate-700 sm:col-span-2">
                                        {{ $value }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <!-- Footer -->
                    <div class="bg-slate-50/50 px-8 py-6">
                        <button
                            type="submit"
                            class="btn bg-gradient-to-r from-[#6A5ACD] to-[#9370DB] hover:from-[#5B4FCF] hover:to-[#8A62E6] text-white font-semibold py-3 px-6 rounded-lg w-full transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg animate-fade-in-up"
                            style="animation-delay: 0.6s;"
                        >
                            {{ __('Finish setup') }}
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/50 p-8 text-center transform transition-all duration-300 hover:scale-105">
                <span class="text-5xl animate-bounce inline-block mb-4">
                    🎉
                </span>
                <h3 class="text-3xl font-bold text-[#4A5568] mb-4 animate-fade-in">
                    {{ __('Congratulations!') }}
                </h3>
                <p class="text-slate-600 mb-8 animate-fade-in-delay">
                    {{ __("Your store has been successfully set up. You can now log in to your store's administration panel and start selling your products.") }}
                </p>

                  <a  href="{{ route('employee.dashboard') }}"
                    class="btn bg-gradient-to-r from-[#6A5ACD] to-[#9370DB] hover:from-[#5B4FCF] hover:to-[#8A62E6] text-white font-semibold py-3 px-6 rounded-lg inline-block transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg animate-fade-in-up"
                >
                    {{ __('Go to administration panel') }}
                </a>
            </div>
        @endunless
    </div>
</div>
