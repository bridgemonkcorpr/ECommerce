<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Meta title & description -->
        <x-slot:title>
            {{ __('Users') }}
        </x-slot:title>

        <!-- Page content -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 xl:flex xl:gap-x-16 xl:px-8">
            @include('layouts.employee-settings-navigation')

            <div class="py-6 lg:flex-auto xl:py-0">
                <div class="space-y-12">
                    <!-- Admins Section -->
                    <div class="pb-12">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                    {{ __('Admins') }}
                                </h2>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('List of store administrators.') }}
                                </p>
                            </div>
                            @if(auth()->user()->is_admin)
                                <div class="ml-4 mt-4 flex-shrink-0">
                                    <a href="{{ route('employee.settings.user.create', ['admin' => 'true']) }}"
                                       class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                                        {{ __('Add admin') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                            <ul class="divide-y divide-purple-200 dark:divide-purple-700">
                                @foreach($this->employees->where('is_admin', true)->all() as $employee)
                                    <li class="p-6 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img class="h-12 w-12 rounded-full object-cover"
                                                 src="{{ $employee->getFirstMediaUrl('avatar', 'thumb') }}"
                                                 alt="{{ $employee->name }}">
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                                    {{ $employee->name }}
                                                </p>
                                                <p class="text-sm text-purple-500 dark:text-purple-400">
                                                    {{ $employee->email }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('employee.settings.user.detail', $employee->id) }}"
                                           class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium hover:bg-purple-200 transition-colors duration-300">
                                            {{ __('View profile') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Staffs Section -->
                    <div class="pb-12">
                        <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200">
                                    {{ __('Staffs') }}
                                </h2>
                                <p class="mt-1 text-sm text-purple-500 dark:text-purple-400">
                                    {{ __('List of all staff members.') }}
                                </p>
                            </div>
                            @if(auth()->user()->is_admin)
                                <div class="ml-4 mt-4 flex-shrink-0">
                                    <a href="{{ route('employee.settings.user.create') }}"
                                       class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                                        {{ __('Add staff') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="mt-6 bg-white dark:bg-purple-800 rounded-lg shadow-md overflow-hidden">
                            <ul class="divide-y divide-purple-200 dark:divide-purple-700">
                                @foreach($this->employees->where('is_admin', false)->all() as $employee)
                                    <li class="p-6 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img class="h-12 w-12 rounded-full object-cover"
                                                 src="{{ $employee->getFirstMediaUrl('avatar', 'thumb') }}"
                                                 alt="{{ $employee->name }}">
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                                    {{ $employee->name }}
                                                </p>
                                                <p class="text-sm text-purple-500 dark:text-purple-400">
                                                    {{ $employee->email }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('employee.settings.user.detail', $employee->id) }}"
                                           class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium hover:bg-purple-200 transition-colors duration-300">
                                            {{ __('View profile') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
