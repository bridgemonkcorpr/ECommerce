@props(['type' => 'success', 'title' => '', 'message' => ''])

@php
    $icons = [
        'success' => 'heroicon-m-check-circle',
        'error' => 'heroicon-m-exclamation-circle',
        'warning' => 'heroicon-m-exclamation-triangle',
        'info' => 'heroicon-m-information-circle',
    ][$type ?? 'success'];
@endphp

@if($message)
    <div {{ $attributes->merge() }}>
        <div @class(['rounded-md p-4', 'bg-green-50 border border-green-200 dark:border-green-900 dark:bg-green-900/20' => $type == 'success', 'bg-red-50 border border-red-200 dark:border-red-900 dark:bg-red-900/20' => $type == 'error', 'bg-purple-50 border border-purple-200 dark:border-purple-900 dark:bg-purple-900/20' => $type == 'warning', 'bg-purple-50 border border-purple-200 dark:border-purple-900 dark:bg-purple-900/20' => $type == 'info'])>
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-icon
                        :name="$icons"
                        @class(['h-5 w-5', 'text-green-400' => $type == 'success', 'text-red-400' => $type == 'error', 'text-purple-400' => $type == 'warning', 'text-purple-400' => $type == 'info'])
                    />
                </div>
                <div class="ml-3">
                    @if($title)
                        <h3 @class(['text-sm font-medium mb-2', 'text-green-800 dark:text-white' => $type == 'success', 'text-red-800 dark:text-white' => $type == 'error', 'text-purple-800 dark:text-white' => $type == 'warning', 'text-purple-800 dark:text-white' => $type == 'info'])>
                            {{ $title }}
                        </h3>
                    @endif
                    <div @class(['text-sm', 'font-medium' => empty($title), 'text-green-700 dark:text-white' => $type == 'success', 'text-red-700 dark:text-white' => $type == 'error', 'text-purple-700 dark:text-white' => $type == 'warning', 'text-purple-700 dark:text-white' => $type == 'info'])>
                        {{ $message }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
