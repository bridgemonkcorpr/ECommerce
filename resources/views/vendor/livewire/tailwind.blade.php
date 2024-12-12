<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)

        <nav
            role="navigation"
            aria-label="{{ __('Pagination Navigation') }}"
            class="flex items-center justify-between"
        >
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    <button
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        wire:loading.attr="disabled"
                        type="button"
                        class="btn btn-default"
                        @disabled($paginator->onFirstPage())
                    >
                        {!! __('pagination.previous') !!}
                    </button>
                </span>

                <span>
                    <button
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        wire:loading.attr="disabled"
                        class="btn btn-default"
                        @disabled(!$paginator->hasMorePages())
                    >
                        {!! __('pagination.next') !!}
                    </button>
                </span>
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-slate-700 leading-5 dark:text-slate-400">
                        <span>{!! __('Showing') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('to') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('of') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('results') !!}</span>
                    </p>
                </div>

                <div>
                    <span>
                        @if(method_exists($paginator,'getCursorName'))
                            <button
                                wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                                wire:loading.attr="disabled"
                                type="button"
                                class="btn btn-default"
                                @disabled($paginator->onFirstPage())
                            >
                                {!! __('pagination.previous') !!}
                            </button>
                        @else
                            <button
                                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled"
                                type="button"
                                class="btn btn-default"
                                @disabled($paginator->onFirstPage())
                            >
                                {!! __('pagination.previous') !!}
                            </button>
                        @endif
                    </span>

                    <span>
                        @if(method_exists($paginator,'getCursorName'))
                            <button
                                wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                                wire:loading.attr="disabled"
                                type="button"
                                class="ml-3 btn btn-default"
                                @disabled(!$paginator->hasMorePages())
                            >
                                {!! __('pagination.next') !!}
                            </button>
                        @else
                            <button
                                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled"
                                type="button"
                                class="ml-3 btn btn-default"
                                @disabled(!$paginator->hasMorePages())
                            >
                                {!! __('pagination.next') !!}
                            </button>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
