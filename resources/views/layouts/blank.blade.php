<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
    x-cloak
    x-data="{ theme: $persist('light') }"
    x-bind:class="{ 'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
>
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
            content="noindex, nofollow"
        >

        <!-- Title -->
        {{--        <title>{{ isset($title) ? $title . ' - ' . $generalSettings->store_name : $generalSettings->store_name }}</title>--}}

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
    <body class="antialiased bg-white font-sans h-full dark:bg-slate-900">
        {{ $slot }}

        <!-- Scripts -->
        @livewireScripts
        @vite('resources/js/guest.js')
        @stack('scripts')
    </body>
</html>
