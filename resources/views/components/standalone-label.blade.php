@props(['value'])

<span {{ $attributes->merge(['class' => 'cursor-default block font-medium text-sm text-slate-700 dark:text-slate-200']) }}>
    {{ $value ?? $slot }}
</span>
