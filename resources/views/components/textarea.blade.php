@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'appearance-none border border-slate-300 rounded-md shadow-sm disabled:bg-slate-100 disabled:opacity-50 disabled:cursor-not-allowed focus:border-purple-500 focus:ring-purple-500 dark:border-white/10 dark:bg-white/5 dark:focus:border-purple-500 dark:focus:ring-purple-500 dark:text-slate-300 dark:focus:ring-offset-slate-900']) !!}>
    {{ $slot }}
</textarea>
