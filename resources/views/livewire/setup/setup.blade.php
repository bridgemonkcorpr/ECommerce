<div class="relative h-screen overflow-hidden bg-[#FBF4E4]">
    <!-- Animated Background (unchanged) -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-1/3 h-1/3 bg-[#FBEAE9] rounded-br-full opacity-70"></div>
        <div class="absolute bottom-0 right-0 w-1/2 h-1/2 bg-[#F8E1F9] rounded-tl-full opacity-70"></div>
        <div class="absolute top-1/4 right-1/4 w-48 h-48 bg-[#D3D5EE] rounded-full opacity-50 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-[#E6E9F8] rounded-full opacity-50 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#D4E3F9]/30 via-transparent to-[#CEF6F8]/30"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 flex flex-col lg:flex-row h-full">
        <!-- Left Panel - Livewire Setup -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 lg:p-16">
            <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-xl p-6 shadow-lg">
                <livewire:setup.wizard />
            </div>
        </div>

        <!-- Right Panel - Heading, Description, and Logo -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 lg:p-16">
            <div class="max-w-lg text-center">
                <h1 class="font-extrabold text-5xl lg:text-6xl mb-6 animate-text-shimmer bg-gradient-to-r from-[#6A5ACD] via-[#9370DB] to-[#8A2BE2] bg-clip-text text-transparent">
                    {{ __('Craft Your Digital Oasis') }}
                </h1>
                <p class="text-xl text-[#4A5568] mb-8 animate-fade-in-up font-light leading-relaxed">
                    {{ __('Embark on a journey to create a unique online experience that reflects your vision.') }}
                </p>
            </div>

            <!-- Logo -->
            <div class="mt-12 animate-fade-in-up" style="animation-delay: 0.5s;">
                <div class="relative w-64 h-64">
                    @foreach(['#D3D5EE', '#E6E9F8', '#D4E3F9', '#CEF6F8', '#D2F6ED'] as $index => $color)
                        <div class="absolute inset-0 rounded-full animate-pulse"
                             style="
                                background-color: {{ $color }};
                                animation-delay: {{ $index * 0.5 }}s;
                                transform: scale({{ 1 - ($index * 0.15) }});
                             ">
                        </div>
                    @endforeach
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-5xl font-bold text-[#4A5568] font-serif">We Mart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes text-shimmer {
    0% { background-position: -200% center; }
    100% { background-position: 200% center; }
}
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}
@keyframes pulse {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}
.animate-text-shimmer {
    background-size: 200% auto;
    animation: text-shimmer 5s linear infinite;
}
.animate-float {
    animation: float 6s ease-in-out infinite;
}
.animate-fade-in-up {
    animation: fade-in-up 1s ease-out;
}
.animate-pulse {
    animation: pulse 3s infinite;
}
@keyframes fade-in-up {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>
