<div {{ $attributes->merge(['class' => 'bg-white shadow-sm ring-1 ring-slate-200 rounded-md sm:rounded-lg dark:bg-slate-900 dark:ring-white/10 dark:shadow-inner dark:shadow-xl']) }}>
    @isset($header)
        <div {{ $header->attributes->class(['px-4 py-5 rounded-t-md sm:px-6 sm:rounded-t-lg']) }}>
            {{ $header }}
        </div>
    @endisset
    <div {{ $content->attributes->class(['px-4 py-5 sm:px-6']) }}>
        {{ $content }}
    </div>
    @isset($footer)
        <div {{ $footer->attributes->class(['px-4 py-3 rounded-b-md sm:px-6 sm:rounded-b-lg']) }}>
            {{ $footer }}
        </div>
    @endisset
</div>
