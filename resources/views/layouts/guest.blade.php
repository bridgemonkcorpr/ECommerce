<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >
        <meta
            name="csrf-token"
            content="{{ csrf_token() }}"
        >
        <meta
            name="robots"
            content="index, follow"
        >

        {!! SEOMeta::generate() !!}

        {!! OpenGraph::generate() !!}

        {!! Twitter::generate() !!}

        <!-- Favicon -->
        <link
            rel="icon"
            href="{{ $brandSettings->favicon_path ? Storage::url($brandSettings->favicon_path) : asset('img/favicon.png') }}"
        >

        <!-- Fonts -->
        <link
            rel="preconnect"
            href="https://fonts.googleapis.com"
        >
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin
        >
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        >

        <!-- Styles -->
        @livewireStyles
        @vite('resources/css/guest.css')
    </head>
    <body
        id="main"
        class="antialiased font-sans"
    >
        <livewire:guest.components.header />

        {{ $slot }}

        <livewire:guest.components.footer />

        <livewire:guest.components.cart-slide />

        @if($generalSettings->cookie_consent_enabled)
            <x-cookie-consent />
        @endif

        <livewire:components.spotlight />

        <x-notification />

        <!-- Scripts -->
        @livewireScripts
        @vite('resources/js/guest.js')
        @stack('scripts')
    </body>
</html>
