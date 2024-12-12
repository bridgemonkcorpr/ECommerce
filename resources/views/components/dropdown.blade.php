@props([
    'align' => 'right',
    'width' => '48',
    'isDropUp' => false,
    'closeOnClick' => true,
    'triggerClasses' => '',
    'contentClasses' => 'py-1 bg-white dark:bg-slate-800'
])

@php
    switch ($align) {
        case 'left':
            $alignmentClasses = 'origin-top-left left-0';
            break;
        case 'top':
            $alignmentClasses = 'origin-top';
            break;
        case 'right':
        default:
            $alignmentClasses = 'origin-top-right right-0';
            break;
    }

    switch ($width) {
        case '48':
            $width = 'w-48';
            break;
        case '64':
            $width = 'w-64';
            break;
        case '80':
            $width = 'w-80';
            break;
        case '96':
            $width = 'w-96';
            break;
        case 'full':
            $width = 'w-full';
            break;
    }
@endphp

<div
    class="relative"
    x-data="{ open: false }"
    @click.outside="open = false"
    @close.stop="open = false"
>
    <div
        @click="open = ! open"
        class="{{ $triggerClasses }}"
    >
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 my-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} {{ $isDropUp ? 'bottom-full' : 'top-full' }}"
        style="display: none;"
        @if($closeOnClick)
            @click="open = false"
        @endif
    >
        <div class="rounded-md ring-1 ring-slate-900/10 dark:ring-white/5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
