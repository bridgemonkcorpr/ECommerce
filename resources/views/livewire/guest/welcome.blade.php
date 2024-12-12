<main class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900 min-h-screen">
{{-- This is our dynamic banner --}}
    <div x-data="{ current: 0 }" class="relative overflow-hidden">
        <ul x-ref="slider" class="flex flex-1 scroll-smooth scroll-no-bar snap-mandatory snap-x overflow-x-auto overflow-y-hidden">
                <li x-intersect.threshold.90="$nextTick(() => current = 0)" class="snap-center shrink-0 w-full">
                    <div class="relative bg-gradient-to-br from-purple-100 to-indigo-100">
                        <div aria-hidden="true" class="absolute inset-0 ">

                                <img src="{{ asset('img/cover.png') }}" alt="My first image" class="h-full w-full object-cover object-center opacity-75">

                        </div>
                        <div class="relative px-6 py-32 sm:px-12 sm:py-40 lg:px-16">
                            <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
                                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                    First Banner
                                </h2>

                                    <p class="mt-3 text-xl text-white line-clamp-2">
                                        This is our first banner
                                    </p>

                                    <a href="#" class="mt-8 block w-full rounded-md border border-transparent bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-8 py-3 text-base font-medium text-white hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 sm:w-auto transition duration-300">
                                        Button 1
                                    </a>

                            </div>
                        </div>
                    </div>
                </li>
                <li x-intersect.threshold.90="$nextTick(() => current = 1)" class="snap-center shrink-0 w-full">
                    <div class="relative bg-gradient-to-br from-purple-100 to-indigo-100">
                        <div aria-hidden="true" class="absolute inset-0 ">

                                <img src="{{ asset('img/cover.png') }}" alt="My first image" class="h-full w-full object-cover object-center opacity-75">

                        </div>
                        <div class="relative px-6 py-32 sm:px-12 sm:py-40 lg:px-16">
                            <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
                                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                   Second Banner
                                </h2>

                                    <p class="mt-3 text-xl text-white line-clamp-2">
                                        This is our second banner
                                    </p>

                                    <a href="#" class="mt-8 block w-full rounded-md border border-transparent bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-8 py-3 text-base font-medium text-white hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 sm:w-auto transition duration-300">
                                        Button 2
                                    </a>

                            </div>
                        </div>
                    </div>
                </li>


                <li x-intersect.threshold.90="$nextTick(() => current = 2)" class="snap-center shrink-0 w-full">
                    <div class="relative bg-gradient-to-br from-purple-100 to-indigo-100">
                        <div aria-hidden="true" class="absolute inset-0 ">

                                <img src="{{ asset('img/cover.png') }}" alt="My first image" class="h-full w-full object-cover object-center opacity-75">

                        </div>
                        <div class="relative px-6 py-32 sm:px-12 sm:py-40 lg:px-16">
                            <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
                                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                    Third Banner
                                </h2>

                                    <p class="mt-3 text-xl text-white line-clamp-2">
                                        This is our third banner
                                    </p>

                                    <a href="#" class="mt-8 block w-full rounded-md border border-transparent bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-8 py-3 text-base font-medium text-white hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 sm:w-auto transition duration-300">
                                        Button 3
                                    </a>

                            </div>
                        </div>
                    </div>
                </li>


        </ul>
        <div class="absolute bottom-10 inset-x-0 flex justify-center space-x-3">


                <button x-on:click="$refs.slider.scrollTo({ left: $refs.slider.offsetWidth * 0, behavior: 'smooth' })">
                    <span class="sr-only">{{ __('Slide :count', ['count' =>0 + 1]) }}</span>
                    <span class="block h-2 w-2 rounded-full ring-2 ring-white ring-opacity-50 hover:ring-opacity-100 transition duration-300"
                          :class="{ 'bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 ring-opacity-100': current === 0 }"></span>
                </button>

                <button x-on:click="$refs.slider.scrollTo({ left: $refs.slider.offsetWidth * 1, behavior: 'smooth' })">
                    <span class="sr-only">{{ __('Slide :count', ['count' =>1 + 1]) }}</span>
                    <span class="block h-2 w-2 rounded-full ring-2 ring-white ring-opacity-50 hover:ring-opacity-100 transition duration-300"
                          :class="{ 'bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 ring-opacity-100': current === 1 }"></span>
                </button>
                <button x-on:click="$refs.slider.scrollTo({ left: $refs.slider.offsetWidth * 2, behavior: 'smooth' })">
                    <span class="sr-only">{{ __('Slide :count', ['count' =>2 + 1]) }}</span>
                    <span class="block h-2 w-2 rounded-full ring-2 ring-white ring-opacity-50 hover:ring-opacity-100 transition duration-300"
                          :class="{ 'bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 ring-opacity-100': current === 2 }"></span>
                </button>


        </div>
    </div>


    {{-- This is our static banner --}}
        <div class="relative bg-gradient-to-r from-purple-900 to-indigo-900">
            <div aria-hidden="true" class="absolute inset-0">
                <img src="{{ asset('img/cover.png') }}" alt="{{ __('Hero carousel placeholder') }}" class="h-full w-full object-cover object-center opacity-75">
            </div>
            <div class="relative px-6 py-32 sm:px-12 sm:py-40 lg:px-16">
                <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        {{ __('Welcome Title') }}
                    </h2>
                    <p class="mt-3 text-xl text-white line-clamp-2">
                        {{ __('Welcome page first description') }}
                    </p>
                    <a href="javascript:void(0);" class="mt-8 block w-full rounded-md border border-transparent bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-8 py-3 text-base font-medium text-white cursor-not-allowed hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 sm:w-auto transition duration-300">
                        {{ __('Shop now') }}
                    </a>
                </div>
            </div>
        </div>



{{-- Here you can add perks of your ecommerce sites --}}
        <div class=" dark:bg-purple-800">
            <h2 class="sr-only">{{ __('Our perks') }}</h2>
            <div class="mx-auto max-w-7xl divide-y divide-purple-200 dark:divide-purple-700 lg:flex lg:divide-x lg:divide-y-0 lg:py-8 overflow-x-auto">
                     <div class="py-8 lg:w-1/3 lg:flex-none lg:py-0">
                        <div class="mx-auto flex max-w-xs items-center px-4 lg:max-w-none lg:px-8">
                                <img src="{{ asset('img/cover.png') }}" alt="Media title" class="mr-4 h-12 w-12 flex-shrink-0">
                             <div class="flex flex-auto flex-col-reverse">
                                <h3 class="font-medium text-purple-900 dark:text-white">This is first slide</h3>
                                <p class="text-sm text-purple-500 dark:text-purple-400">This is some slide description.</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-8 lg:w-1/3 lg:flex-none lg:py-0">
                        <div class="mx-auto flex max-w-xs items-center px-4 lg:max-w-none lg:px-8">
                                <img src="{{ asset('img/cover.png') }}" alt="Media title" class="mr-4 h-12 w-12 flex-shrink-0">
                             <div class="flex flex-auto flex-col-reverse">
                                <h3 class="font-medium text-purple-900 dark:text-white">This is second slide</h3>
                                <p class="text-sm text-purple-500 dark:text-purple-400">This is some slide description.</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-8 lg:w-1/3 lg:flex-none lg:py-0">
                        <div class="mx-auto flex max-w-xs items-center px-4 lg:max-w-none lg:px-8">
                                <img src="{{ asset('img/cover.png') }}" alt="Media title" class="mr-4 h-12 w-12 flex-shrink-0">
                             <div class="flex flex-auto flex-col-reverse">
                                <h3 class="font-medium text-purple-900 dark:text-white">This is third slide</h3>
                                <p class="text-sm text-purple-500 dark:text-purple-400">This is some slide description.</p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <section class="bg-white dark:bg-purple-800 px-4 pt-24 space-y-5 sm:px-6 sm:pt-32 xl:mx-auto xl:max-w-7xl lg:px-8 ">
            <div class="sm:flex sm:items-center sm:justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                   This is home section
                </h2>
                     <a href="#" class="bg-white hidden text-sm font-semibold text-purple-600 hover:text-pink-600 transition duration-300 sm:block">
                        Welcome back k*ng
                        <span aria-hidden="true"> &rarr;</span>
                    </a>

            </div>
            <img src="{{ asset('img/cover.png') }}" alt="This is our title" class="w-full h-auto object-cover object-center rounded-lg shadow-lg">
            {{-- @if($section['banner_path'])

            @endif
            @if($section['type'] === 'collection')
                <livewire:components.collection-section :handle="$section['carousel_handle']" :items="$section['items']" />
            @elseif($section['type'] === 'product')
                <livewire:components.product-section :handle="$section['carousel_handle']" :items="$section['items']" />
            @elseif($section['type'] === 'blog')
                <livewire:components.blog-section />
            @endif --}}
        </section>


        {{-- Product Section --}}
        @php
        use App\Models\Product;

        $product_items = Product::all();
    @endphp

        <div>

            <div>
                    <div class="mt-5 relative">
                        <div class="-mx-px grid grid-cols-1 sm:mx-0 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($product_items as $product)
                                <div class="group relative rounded-lg p-4 ring-1 ring-slate-200 sm:p-6 hover:ring-1 hover:ring-purple-300 hover:shadow-lg hover:shadow-purple-300/50 transition">
                                    <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg group-hover:opacity-75">
                                        @if($product->hasMedia('gallery'))
                                            {{ $product->getFirstMedia('gallery')('responsive')->attributes(['alt' => $product->name, 'class' => 'h-full w-full object-cover object-center']) }}
                                        @else
                                            <img
                                                src="{{ $product->getFirstMediaUrl('gallery') }}"
                                                alt="{{ $product->name }}"
                                                class="h-full w-full object-cover object-center"
                                            >
                                        @endif
                                    </div>
                                    <div class="pb-4 pt-10 text-center">
                                        <h3 class="text-sm font-medium text-slate-900 line-clamp-2">
                                            <a href="{{ route('guest.products.detail', $product) }}">
                                                <span
                                                    aria-hidden="true"
                                                    class="absolute inset-0"
                                                ></span>
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        <p class="mt-4 text-base font-medium text-slate-900">
                                            <x-money :amount="$product->price" />
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

            </div>
        </div>

        {{-- Collection section --}}

        <section class="bg-white dark:bg-purple-800 px-4 pt-24 space-y-5 sm:px-6 sm:pt-32 xl:mx-auto xl:max-w-7xl lg:px-8 ">
            <div class="sm:flex sm:items-center sm:justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                   This is Collection section
                </h2>
                     <a href="#" class="bg-white hidden text-sm font-semibold text-purple-600 hover:text-pink-600 transition duration-300 sm:block">
                        Welcome back k*ng
                        <span aria-hidden="true"> &rarr;</span>
                    </a>

            </div>
            <img src="{{ asset('img/cover.png') }}" alt="This is our title" class="w-full h-auto object-cover object-center rounded-lg shadow-lg">
            {{-- @if($section['banner_path'])

            @endif
            @if($section['type'] === 'collection')
                <livewire:components.collection-section :handle="$section['carousel_handle']" :items="$section['items']" />
            @elseif($section['type'] === 'product')
                <livewire:components.product-section :handle="$section['carousel_handle']" :items="$section['items']" />
            @elseif($section['type'] === 'blog')
                <livewire:components.blog-section />
            @endif --}}
        </section>


        {{-- Product Section --}}
        @php
        use App\Models\Collection;

        $collection_items = Collection::all();
    @endphp

        <div>

            <div>
                   <div class="mt-5 flow-root">
                        <div class="-my-2">
                            <div class="relative box-content h-64 overflow-x-auto py-2 xl:overflow-visible">
                                <div class="min-w-screen-xl absolute flex space-x-8 px-4 sm:px-6 lg:px-8 xl:relative xl:grid xl:grid-cols-5 xl:gap-8 xl:space-x-0 xl:px-0">
                                    @foreach($collection_items->take(5) as $item)
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

            </div>
        </div>



</main>
