<!DOCTYPE html>
<html
    x-cloak
    x-data="{ theme: $persist('light') }"
    x-bind:class="{ 'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
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
        <title>{{ isset($title) ? $title . ' - ' . $generalSettings->store_name : $generalSettings->store_name }}</title>

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
        @vite('resources/css/admin.css')
    </head>
    <body
        id="main"
        class="antialiased font-sans h-full bg-white dark:bg-slate-900"
    >
        <div
            x-data="{ sidebarOpen: false }"
            x-on:keydown.window.esc="sidebarOpen = false"
        >
            {{-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. --}}
            <div
                x-show="sidebarOpen"
                class="relative z-50 lg:hidden"
                role="dialog"
                aria-modal="true"
            >
                <div
                    x-show="sidebarOpen"
                    x-transition:enter="transition-opacity ease-linear duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-linear duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-slate-900/80"
                ></div>

                <div class="fixed inset-0 flex">
                    <div
                        x-show="sidebarOpen"
                        x-transition:enter="transition ease-in-out duration-300 transform"
                        x-transition:enter-start="-translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in-out duration-300 transform"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="-translate-x-full"
                        x-on:click.away="sidebarOpen = false"
                        class="relative mr-16 flex w-full max-w-xs flex-1"
                    >
                        <div
                            x-show="sidebarOpen"
                            x-transition:enter="ease-in-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in-out duration-300"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="absolute left-full top-0 flex w-16 justify-center pt-5"
                        >
                            <button
                                x-on:click="sidebarOpen = false"
                                type="button"
                                class="-m-2.5 p-2.5"
                            >
                                <span class="sr-only">{{ __('Close sidebar') }}</span>
                                <x-heroicon-o-x-mark class="h-6 w-6 text-white" />
                            </button>
                        </div>

                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 dark:bg-slate-900 dark:ring-1 dark:ring-white/10">
                            <div class="flex h-16 shrink-0 items-center">
                                <img
                                    src="{{ $brandSettings->logo_path ? Storage::url($brandSettings->logo_path) : asset('img/logo.png') }}"
                                    alt="{{ config('app.name') }}"
                                    class="h-8 w-auto"
                                >
                            </div>
                            <nav class="flex flex-1 flex-col">
                                <ul
                                    role="list"
                                    class="flex flex-1 flex-col gap-y-7"
                                >
                                    <li>
                                        <ul
                                            role="list"
                                            class="-mx-2 space-y-1"
                                        >
                                            <li>

                                                    <a href="{{ route('employee.dashboard') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.dashboard'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.dashboard')])
                                                >
                                                    <x-heroicon-o-home @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.dashboard'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.dashboard')]) />
                                                    {{ __('Dashboard') }}
                                                </a>
                                            </li>
                                            <li>

                                                    <a href="{{ route('employee.orders.list') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.orders.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.orders.*')])
                                                >
                                                    <x-heroicon-o-inbox @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.orders.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.orders.*')]) />
                                                    {{ __('Orders') }}
                                                </a>
                                            </li>
                                            <li>

                                                    <a href="{{ route('employee.products.list') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.products.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.products.*')])
                                                >
                                                    <x-heroicon-o-tag @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.products.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.products.*')]) />
                                                    {{ __('Products') }}
                                                </a>
                                            </li>

                                            <li>

                                                    <a href="{{ route('employee.collections.list') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.collections.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.collections.*')])
                                                >
                                                    <x-heroicon-o-rectangle-stack @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.collections.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.collections.*')]) />
                                                    {{ __('Collections') }}
                                                </a>
                                            </li>
                                            <li>

                                                    <a href="{{ route('employee.customers.list') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.customers.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.customers.*')])
                                                >
                                                    <x-heroicon-o-users @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.customers.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.customers.*')]) />
                                                    {{ __('Customers') }}
                                                </a>
                                            </li>
                                            <li>

                                                    <a href="{{ route('employee.discounts.list') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.discounts.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.discounts.*')])
                                                >
                                                    <x-heroicon-o-ticket @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.discounts.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.discounts.*')]) />
                                                    {{ __('Discounts') }}
                                                </a>
                                            </li>
                                            <li>

                                                    <a href="{{ route('employee.shipping.manager') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.shipping.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.shipping.*')])
                                                >
                                                    <x-heroicon-o-truck @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.shipping.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.shipping.*')]) />
                                                    {{ __('Shipping') }}
                                                </a>
                                            </li>
                                            <li>

                                                    <a href="{{ route('employee.taxes.manager') }}"
                                                    @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.taxes.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.taxes.*')])
                                                    >
                                                        <x-heroicon-o-scale @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.taxes.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.taxes.*')]) />
                                                        {{ __('Taxation') }}
                                                    </a>
                                                </li>


                                            </ul>
                                        </li>
                                        <li class="mt-auto">

                                                <a href="{{ route('employee.settings.general') }}"
                                                @class(['group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-purple-700 hover:bg-purple-50 hover:text-purple-700', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.settings.*')])
                                            >
                                                <x-heroicon-o-cog-6-tooth @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.settings.*')]) />
                                                {{ __('Settings') }}
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Static sidebar for desktop --}}
                <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col">
                    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-slate-200 bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 px-6 pb-4 dark:bg-slate-900 dark:border-white/10">
                        <div class="flex h-16 shrink-0 items-center">
                            <img
                                src="{{ $brandSettings->logo_path ? Storage::url($brandSettings->logo_path) : asset('img/logo.png') }}"
                                alt="{{ config('app.name') }}"
                                class="h-8 w-auto"
                            >
                        </div>
                        <nav class="flex flex-1 flex-col">
                            <ul
                                role="list"
                                class="flex flex-1 flex-col gap-y-7"
                            >
                                <li>
                                    <ul
                                        role="list"
                                        class="-mx-2 space-y-1"
                                    >
                                        <li>

                                                <a href="{{ route('employee.dashboard') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.dashboard'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.dashboard')])
                                            >
                                                <x-heroicon-o-home @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.dashboard'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.dashboard')]) />
                                                {{ __('Dashboard') }}
                                            </a>
                                        </li>
                                        <li>

                                                <a href="{{ route('employee.orders.list') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.orders.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.orders.*')])
                                            >
                                                <x-heroicon-o-inbox @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.orders.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.orders.*')]) />
                                                {{ __('Orders') }}
                                            </a>
                                        </li>
                                        <li>

                                                <a href="{{ route('employee.products.list') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.products.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.products.*')])
                                            >
                                                <x-heroicon-o-tag @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.products.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.products.*')]) />
                                                {{ __('Products') }}
                                            </a>
                                        </li>

                                        <li>

                                                <a href="{{ route('employee.collections.list') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.collections.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.collections.*')])
                                            >
                                                <x-heroicon-o-rectangle-stack @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.collections.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.collections.*')]) />
                                                {{ __('Collections') }}
                                            </a>
                                        </li>
                                        <li>

                                                <a href="{{ route('employee.customers.list') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.customers.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.customers.*')])
                                            >
                                                <x-heroicon-o-users @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.customers.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.customers.*')]) />
                                                {{ __('Customers') }}
                                            </a>
                                        </li>
                                        <li>

                                                <a href="{{ route('employee.discounts.list') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.discounts.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.discounts.*')])
                                            >
                                                <x-heroicon-o-ticket @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.discounts.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.discounts.*')]) />
                                                {{ __('Discounts') }}
                                            </a>
                                        </li>
                                        <li>

                                                <a href="{{ route('employee.shipping.manager') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.shipping.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.shipping.*')])
                                            >
                                            <x-heroicon-o-truck @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.shipping.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.shipping.*')]) />
                                                {{ __('Shipping') }}
                                            </a>
                                        </li>
                                        <li>

                                                <a href="{{ route('employee.taxes.manager') }}"
                                                @class(['group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.taxes.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.taxes.*')])
                                            >
                                                <x-heroicon-o-scale @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.taxes.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.taxes.*')]) />
                                                {{ __('Taxation') }}
                                            </a>
                                        </li>


                                    </ul>
                                </li>

                                @if(!$is_local && !$is_staging && !$generalSettings->license_active)
                                    <li>
                                        <div class="p-4 mx-auto text-center bg-slate-50 rounded-md space-y-3 dark:bg-white/5">
                                            <p class="text-sm text-slate-900 dark:text-slate-200">
                                                {{ __('Fill out your license key to activate your store and accept live payments.') }}
                                            </p>

                                                <a href="{{ route('employee.settings.license') }}"
                                                class="btn btn-primary bg-purple-600 hover:bg-purple-700 btn-sm"
                                            >
                                                {{ __('Activate your store') }}
                                            </a>
                                        </div>
                                    </li>
                                @endif

                                <li class="mt-auto">

                                        <a href="{{ route('employee.settings.general') }}"
                                        @class(['group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-purple-700 hover:bg-purple-50 hover:text-purple-700', 'bg-slate-50 text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.*'), 'text-slate-700 hover:text-purple-700 hover:bg-purple-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => !request()->routeIs('employee.settings.*')])
                                    >
                                        <x-heroicon-o-cog-6-tooth @class(['h-6 w-6 shrink-0', 'text-purple-700 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.*'), 'text-slate-400 group-hover:text-purple-700 dark:group-hover:text-white dark:group-hover:bg-slate-800' => !request()->routeIs('employee.settings.*')]) />
                                        {{ __('Settings') }}
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class=" bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 lg:pl-72">
                    <div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 lg:mx-auto lg:max-w-7xl lg:px-8">
                        <div class="flex h-16 items-center gap-x-4 border-b border-slate-200  px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-0 lg:shadow-none dark:bg-slate-900 dark:border-white/10">
                            <button
                                x-on:click="sidebarOpen = true"
                                type="button"
                                class="-m-2.5 p-2.5 text-slate-700 lg:hidden dark:text-slate-400"
                            >
                                <span class="sr-only">{{ __('Open sidebar') }}</span>
                                <x-heroicon-o-bars-3
                                    class="h-6 w-6"
                                    aria-hidden="true"
                                />
                            </button>

                            <!-- Separator -->
                            <div
                                class="h-6 w-px bg-slate-200 lg:hidden dark:bg-white/5"
                                aria-hidden="true"
                            ></div>

                            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                                <div class="relative flex flex-1">
                                    <button
                                        class="relative w-full"
                                        x-on:click="$dispatch('open-search')"
                                    >
                                        <x-heroicon-o-magnifying-glass
                                            class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-slate-400 dark:text-slate-500"
                                            aria-hidden="true"
                                        />
                                        <span class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 hidden sm:flex items-center h-full w-full pl-8 pr-0 text-slate-400 focus:ring-0 sm:text-sm dark:bg-slate-900 dark:text-slate-500">
                                            {{ __('Search the site (Press "/" to focus)') }}
                                        </span>
                                    </button>
                                </div>
                                <div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 flex items-center gap-x-4 lg:gap-x-6">


                                    <!-- Separator -->
                                    <div
                                        class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 hidden lg:block lg:h-6 lg:w-px lg:bg-slate-200 dark:bg-white/10"
                                        aria-hidden="true"
                                    ></div>

                                    <!-- Profile dropdown -->
                                    <x-dropdown>
                                        <x-slot:trigger>
                                            <button
                                                type="button"
                                                class="-m-1.5 flex items-center p-1.5"
                                                id="user-menu-button"
                                                :aria-expanded="open.toString()"
                                                aria-haspopup="true"
                                            >
                                                <span class="sr-only">{{ __('Open user menu') }}</span>
                                                <img
                                                    class="h-8 w-8 flex-shrink-0 rounded-full bg-slate-100 dark:bg-slate-800"
                                                    src="{{ auth()->user()->getFirstMediaUrl('avatar') }}"
                                                    alt="{{ auth()->user()->name }}"
                                                >
                                                <span class="hidden lg:flex lg:items-center">
                                                    <span
                                                        class="ml-4 text-sm font-semibold leading-6 text-purple-900 dark:text-white"
                                                        aria-hidden="true"
                                                    >
                                                        {{ auth()->user()->name }}
                                                    </span>
                                                    <x-heroicon-m-chevron-down
                                                        class="ml-2 h-5 w-5 text-purple-400"
                                                        aria-hidden="true"
                                                    />
                                                </span>
                                            </button>
                                        </x-slot:trigger>
                                        <x-slot:content>
                                            <x-dropdown-link href="{{ route('employee.profile') }}">
                                                {{ __('Personal profile') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link href="{{ route('employee.profile') }}">
                                                {{ __('Change password') }}
                                            </x-dropdown-link>
                                            <hr class="border-slate-200 dark:border-white/10" />
                                            <div class="relative cursor-pointer block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-900/40 dark:hover:bg-slate-900/40">
                                                <livewire:employee.auth.logout />
                                            </div>
                                        </x-slot:content>
                                    </x-dropdown>
                                </div>
                            </div>
                        </div>
                    </div>

                    <main class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 py-10">
                        {{ $slot }}
                    </main>
                </div>
            </div>

            <livewire:components.spotlight />

            <x-notification />

            <!-- Scripts -->
            @livewireScripts
            @vite('resources/js/admin.js')
            @stack('scripts')
        </body>
    </html>
