<div>
    @if($items)
        <div class="mt-5 flow-root">
            <div class="-my-2">
                <div class="relative box-content h-64 overflow-x-auto py-2 xl:overflow-visible">
                    <div class="min-w-screen-xl absolute flex space-x-8 px-4 sm:px-6 lg:px-8 xl:relative xl:grid xl:grid-cols-5 xl:gap-8 xl:space-x-0 xl:px-0">
                        @foreach($this->collection_items->take(5) as $item)
                            <a
                                href="{{ route('guest.collections.detail', $item) }}"
                                class="group relative flex h-64 w-56 flex-col overflow-hidden rounded-lg p-6 hover:opacity-75 xl:w-auto"
                            >
                                <span
                                    aria-hidden="true"
                                    class="absolute inset-0"
                                >
                                    <img
                                        src="{{ $item->getFirstMediaUrl('cover') }}"
                                        alt="{{ $item->title }}"
                                        class="h-full w-full object-cover object-center group-hover:scale-125"
                                    >
                                </span>
                                <span
                                    aria-hidden="true"
                                    class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-slate-800 opacity-50"
                                ></span>
                                <span class="relative mt-auto text-center text-xl font-bold text-white">
                                    {{ $item->title }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @elseif($handle)
        <div class="mt-5 flow-root">
            <div class="-my-2">
                <div class="relative box-content h-64 overflow-x-auto py-2 xl:overflow-visible">
                    <div class="min-w-screen-xl absolute flex space-x-8 px-4 sm:px-6 lg:px-8 xl:relative xl:grid xl:grid-cols-5 xl:gap-8 xl:space-x-0 xl:px-0">
                        @foreach($this->collection_carousel->slides as $slide)
                            <a
                                href="{{ $slide->button_link }}"
                                class="group relative flex h-64 w-56 flex-col overflow-hidden rounded-lg p-6 xl:w-auto"
                            >
                                <span
                                    aria-hidden="true"
                                    class="absolute inset-0"
                                >
                                    <img
                                        src="{{ $slide->getFirstMediaUrl('image') }}"
                                        alt="{{ $slide->title }}"
                                        class="h-full w-full object-cover object-center transition duration-500 group-hover:scale-125"
                                    >
                                </span>
                                <span
                                    aria-hidden="true"
                                    class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-slate-800 opacity-50"
                                ></span>
                                <span class="relative mt-auto text-center text-xl font-bold text-white">
                                    {{ $slide->title }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
