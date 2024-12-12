@props(['items' => []])

<div class="space-y-2">
    @foreach($items as $item)
        <div
            wire:key="menu-{{ $item->menu_id }}-item-{{ $item->id }}"
            class="relative flex items-center space-x-3 rounded-lg border border-slate-300 bg-white px-3 py-2 dark:border-white/10 dark:bg-slate-900"
        >
            <div class="flex-shrink-0 p-2 rounded-full ring-1 ring-slate-200 bg-slate-50 dark:bg-white/10 dark:ring-white/5">
                <x-heroicon-o-link class="h-5 w-5 rounded-full text-slate-500 dark:text-slate-400" />
            </div>
            <div class="min-w-0 flex flex-1 items-center justify-between">
                <p class="text-sm text-slate-900 dark:text-white">
                    {{ $item->name }}
                </p>
                <span class="isolate inline-flex rounded-md shadow-sm">
                    <button
                        wire:click.prevent="addMenuItem({{ $item->menu_id }}, {{ $item->id }})"
                        type="button"
                        class="relative inline-flex items-center rounded-l-md bg-white px-3 py-1.5 text-sm font-medium text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 focus:z-10 dark:bg-slate-900 dark:ring-slate-700 dark:text-white dark:hover:bg-slate-800"
                    >
                        {{ __('Add') }}
                    </button>
                    <button
                        wire:click.prevent="editMenuItem({{ $item->id }})"
                        type="button"
                        class="relative -ml-px inline-flex items-center bg-white px-3 py-1.5 text-sm font-medium text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 focus:z-10 dark:bg-slate-900 dark:ring-slate-700 dark:text-white dark:hover:bg-slate-800"
                    >
                        {{ __('Edit') }}
                    </button>
                    <button
                        wire:click.prevent="confirmMenuItemDeletion({{ $item->id }})"
                        type="button"
                        class="relative -ml-px inline-flex items-center rounded-r-md bg-white px-3 py-1.5 text-sm font-medium text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 focus:z-10 dark:bg-slate-900 dark:ring-slate-700 dark:text-white dark:hover:bg-slate-800"
                    >
                        {{ __('Delete') }}
                    </button>
                </span>
            </div>
        </div>
        @if($item->children->isNotEmpty())
            <div class="ml-4 sm:ml-16">
                <x-menu-tree :items="$item->children" />
            </div>
        @endif
        @if($loop->last)
            <button
                wire:click.prevent="addMenuItem({{ $item->menu_id }}, {{ $item->parent_id ?? 'null' }})"
                type="button"
                class="group relative inline-flex w-full items-center space-x-3 rounded-lg border border-dashed border-purple-300 bg-white px-3 py-2 shadow-sm focus:outline-none hover:border-purple-400 dark:border-white/10 dark:bg-slate-900 dark:hover:border-white/20"
            >
                <div class="flex-shrink-0 p-2 rounded-full ring-1 ring-purple-300 bg-slate-50 dark:bg-white/10 dark:ring-white/5">
                    <x-heroicon-o-plus class="h-5 w-5 rounded-full text-purple-500 dark:text-slate-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-purple-500 group-hover:text-purple-600 dark:group-hover:text-purple-400">
                        {{ $item->parent_id ? __('Add menu item to ') : __('Add menu item') }}
                        @if($item->parent_id)
                            <span class="font-medium">{{ $item->parent->name }}</span>
                        @endif
                    </p>
                </div>
            </button>
        @endif
    @endforeach
</div>
