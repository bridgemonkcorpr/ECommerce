@props(['value'])

<p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
    {{ $value ?? $slot }}
</p>
