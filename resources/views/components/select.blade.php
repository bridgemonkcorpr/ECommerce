@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'block w-full rounded-md border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:border-white/10 dark:bg-white/5 dark:focus:border-purple-500 dark:focus:ring-purple-500 dark:text-slate-300 dark:focus:ring-offset-slate-900']) }}>
    {{ $slot }}
</select>
