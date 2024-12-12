<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="border-b border-gradient-to-r from-purple-200 to-pink-200 dark:from-purple-800 dark:to-pink-800">
            <ol role="list" class="flex items-center space-x-4 py-4">
                <li>
                    <div class="flex items-center">
                        <a href="/" class="mr-4 text-sm font-medium text-slate-900 dark:text-slate-100">
                            {{ __('Home') }}
                        </a>
                        <svg viewBox="0 0 6 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-5 w-auto text-slate-300 dark:text-slate-600">
                            <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />
                        </svg>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <a href="{{ route('guest.products.list') }}" class="mr-4 text-sm font-medium text-slate-900 dark:text-slate-100">
                            {{ __('All products') }}
                        </a>
                        <svg viewBox="0 0 6 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-5 w-auto text-slate-300 dark:text-slate-600">
                            <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />
                        </svg>
                    </div>
                </li>
                <li class="text-sm truncate">
                    <a href="{{ route('guest.products.detail', $product) }}" aria-current="page" class="font-medium text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300">
                        {{ $product->name }}
                    </a>
                </li>
            </ol>
        </nav>

        <main class="mx-auto max-w-2xl py-16 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="relative lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <!-- Image gallery -->
                <div wire:ignore x-data="{ current: 0, showNavigator: false }" x-init="$watch('current', value => {
                    $refs.previews.scrollTo({ left: $refs.previews.offsetWidth * value, behavior: 'smooth' });
                    $refs.thumbnails.children[value].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                })" class="lg:sticky top-10 flex flex-col-reverse">
                    <!-- Image selector -->
                    <div class="mx-auto mt-[1.4rem] hidden w-full sm:block">
                        <div x-ref="thumbnails" class="flex sm:gap-[1.8rem] lg:gap-4 xl:gap-[1.4rem] overflow-x-auto scroll-no-bar snap-mandatory snap-x">
                            @foreach($product->getMedia('gallery') as $medium)
                                <button x-on:click="current = {{ $loop->index }}" class="relative flex flex-shrink-0 items-center justify-center snap-center w-20 h-20 rounded-md" :class="{ 'ring-2 ring-gradient-to-r from-purple-400 to-pink-400': current === {{ $loop->index }}, 'ring-1 ring-gradient-to-r from-purple-200 to-pink-200': current !== {{ $loop->index }} }">
                                    <img src="{{ $medium->getUrl('thumb') }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-md">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Image preview -->
                    <div x-on:mouseenter="showNavigator = true" x-on:mouseleave="showNavigator = false" class="relative group">
                        <div x-ref="previews" class="flex flex-1 overflow-x-auto scroll-smooth scroll-no-bar snap-mandatory snap-x sm:border sm:border-gradient-to-r from-purple-200 to-pink-200 sm:rounded-lg dark:from-purple-800 dark:to-pink-800">
                            @foreach($product->getMedia('gallery') as $medium)
                                <div class="snap-center flex-shrink-0 w-full h-full">
                                    {{ $medium->hasGeneratedConversion('responsive') ? $medium('responsive')->lazy() : $medium()->lazy() }}
                                </div>
                            @endforeach
                        </div>

                        @if($product->media_count > 1)
                            <button x-cloak x-show="showNavigator" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="opacity-0 -translate-x-full" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-full" x-on:click="current = current === 0 ? {{ $product->getMedia('gallery')->count() - 1 }} : current - 1" class="absolute top-1/2 left-10 items-center rounded-full border border-transparent bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 p-2 text-white shadow-sm hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none disabled:opacity-25">
                                <span class="sr-only">{{ __('Previous') }}</span>
                                <x-heroicon-m-chevron-left class="h-5 w-5" />
                            </button>
                            <button x-cloak x-show="showNavigator" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full" x-on:click="current = current === {{ $product->getMedia('gallery')->count() - 1 }} ? 0 : current + 1" class="absolute top-1/2 right-10 inline-flex items-center rounded-full border border-transparent bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 p-2 text-white shadow-sm hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none">
                                <span class="sr-only">{{ __('Next') }}</span>
                                <x-heroicon-m-chevron-right class="h-5 w-5" />
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Product info -->
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-slate-100">
                        {{ $product->name }}
                    </h1>

                    <div class="mt-3">
                        <h2 class="sr-only">{{ __('Product information') }}</h2>
                        <p class="text-3xl tracking-tight text-slate-900 dark:text-slate-100">
                            <x-money :amount="$variant->price" :currency="config('app.currency')" />
                            @if($variant->compare_price > 0)
                                <span class="text-xl text-slate-500 line-through dark:text-slate-400">
                                    <x-money :amount="$variant->compare_price" :currency="config('app.currency')" />
                                </span>
                            @endif
                        </p>
                    </div>

                    <!-- Reviews -->
                    <div x-data class="mt-3">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <x-star-rating :rating="$product->reviews->avg('rating')" />
                            </div>
                            <p class="sr-only">
                                {{ __(':rating out of 5 stars', ['rating' => number_format($product->reviews->avg('rating'))]) }}
                            </p>
                            <button x-on:click="$dispatch('show-product-reviews')" type="button" class="ml-3 text-sm font-medium text-purple-600 hover:text-purple-500 dark:text-purple-400 dark:hover:text-purple-300">
                                {{ trans_choice(':count review|:count reviews', $product->reviews->count()) }}
                            </button>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    @if($product->excerpt)
                        <div class="mt-6">
                            <h3 class="sr-only">{{ __('Description') }}</h3>
                            <div class="space-y-6 text-base text-slate-700 dark:text-slate-300">
                                {!! $product->excerpt !!}
                            </div>
                        </div>
                    @endif

                    <!-- Variants -->
                    <form wire:submit.prevent="addToCart" class="mt-6">
                        @if($this->productVariants->count())
                            @foreach($this->productOptions as $index => $option)
                                <div @class(['mt-8' => !$loop->first])>
                                    <h3 class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                        {{ $option->name }}
                                    </h3>
                                    <fieldset class="mt-2">
                                        <legend class="sr-only">{{ __('Choose a') }} {{ $option->name }}</legend>

                                        @if($option->visual === 'color' || $option->visual === 'image')
                                            <div class="flex items-center space-x-3">
                                                @foreach($option->optionValues as $optionValue)
                                                    <label @class(['-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none', "ring-2 ring-gradient-to-r from-purple-400 to-pink-400" => in_array($optionValue->id, $selectedOptionValues)]) data-tippy-content="{{ $optionValue->label }}" data-tippy-placement="bottom">
                                                        <input wire:model="selectedOptionValues.{{ $index }}" type="radio" value="{{ $optionValue->id }}" class="sr-only peer" aria-labelledby="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label">
                                                        <p id="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label" class="sr-only">
                                                            {{ $optionValue->label }}
                                                        </p>
                                                        @if($option->visual === 'color')
                                                            <span class="w-8 h-8 rounded-full border border-black border-opacity-10" style="background-color: {{ $optionValue->value }}"></span>
                                                        @elseif($option->visual === 'image')
                                                            <span class="w-8 h-8 rounded-full border border-black border-opacity-10 bg-center bg-cover" style="background-image: url('{{ $optionValue->getFirstMediaUrl('image') }}')"></span>
                                                        @endif
                                                        <x-heroicon-m-check class="w-5 h-5 text-white absolute inset-0 m-auto z-0 pointer-events-none hidden peer-checked:block duration-150" />
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="flex flex-wrap gap-4">
                                                @foreach($option->optionValues as $optionValue)
                                                    <label @class(['relative overflow-hidden flex flex-1 items-center justify-center px-4 py-3 cursor-pointer text-sm font-medium uppercase rounded-md shadow-sm hover:bg-slate-50 focus:outline-none sm:flex-none dark:hover:bg-slate-800', 'ring-1 ring-gradient-to-r from-purple-200 to-pink-200 dark:from-purple-800 dark:to-pink-800' => !in_array($optionValue->id, $selectedOptionValues), 'ring-2 ring-gradient-to-r from-purple-400 to-pink-400' => in_array($optionValue->id, $selectedOptionValues)])>
                                                        <input wire:model="selectedOptionValues.{{ $index }}" type="radio" value="{{ $optionValue->id }}" class="sr-only" aria-labelledby="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label">
                                                        <span id="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label">
                                                            {!! $optionValue->label ?? $optionValue->value !!}
                                                        </span>
                                                        @if(in_array($optionValue->id, $selectedOptionValues))
                                                            <div class="absolute bottom-0 right-0 w-4 overflow-hidden inline-block">
                                                                <div class="h-6 bg-gradient-to-r from-purple-500 to-pink-500 rotate-45 transform origin-bottom-left"></div>
                                                                <x-heroicon-m-check class="h-3.5 w-2.5 absolute -bottom-0.5 right-0 text-white" />
                                                            </div>
                                                        @endif
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </fieldset>
                                </div>
                            @endforeach
                        @endif

                        <div class="flex items-center space-x-3 mt-8">
                            <div>
                                <x-input-label for="productQuantity" :value="__('Quantity')" class="sr-only" />
                                <x-input wire:model.lazy="addToCart.quantity" type="number" id="productQuantity" class="py-3 w-28 text-sm text-center sm:text-base show-spinners border-gradient-to-r from-purple-200 to-pink-200 focus:border-gradient-to-r focus:from-purple-400 focus:to-pink-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:border-gradient-to-r dark:from-purple-700 dark:to-pink-700" :min="$minQuantity" :max="$maxQuantity" />
                                <x-input-error for="addToCart.quantity" />
                            </div>
                            <div class="flex w-full">
                                <button wire:loading.delay.attr="disabled" class="btn btn-primary btn-xl w-full bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300" @disabled($variant->stock_value < 1)>
                                    {{ $variant->stock_value >= 1 ? __('Add to cart') : __('Sold out') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Specifications -->
                    @if($product->specifications->isNotEmpty())
                        <section aria-labelledby="specifications-heading" class="mt-12">
                            <h2 id="specifications-heading" class="sr-only">{{ __('Product specifications') }}</h2>

                            <div class="divide-y divide-gradient-to-r from-purple-200 to-pink-200 border-t border-gradient-to-r from-purple-200 to-pink-200 dark:from-purple-800 dark:to-pink-800">
                                @foreach($product->specifications as $specification)
                                    <div x-data="{ expanded: false }">
                                        <h3>
                                            <button x-on:click="expanded = !expanded" type="button" class="group relative flex w-full items-center justify-between py-6 text-left" aria-controls="disclosure-{{ $loop->index }}" :aria-expanded="expanded.toString()">
                                                <span class="text-slate-900 text-sm font-medium dark:text-slate-100" :class="{ 'text-purple-600 dark:text-purple-400': expanded, 'text-slate-900 dark:text-slate-100': !expanded }">
                                                    {{ $specification->name }}
                                                </span>
                                                <span class="ml-6 flex items-center">
                                                    <x-heroicon-o-arrow-small-down class="h-6 w-6 text-slate-400 group-hover:text-slate-500 dark:text-slate-500 dark:group-hover:text-slate-400" ::class="{ 'rotate-180': expanded }" aria-hidden="true" />
                                                </span>
                                            </button>
                                        </h3>
                                        <div x-cloak x-collapse x-show="expanded" id="disclosure-{{ $loop->index }}">
                                            <div class="prose prose-sm pb-6 dark:prose-invert">
                                                {!! $specification->value !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
            </div>

            <div wire:ignore class="px-4 mt-10 sm:px-0 lg:max-w-none">
                <div x-data="tabs" x-id="['tabs']" x-on:show-product-reviews.window="select($id('tabs', 2)); $el.scrollIntoView({ behavior: 'smooth'} )">
                    <div class="border-b border-gradient-to-r from-purple-200 to-pink-200 dark:from-purple-800 dark:to-pink-800">
                        <ul x-bind="tablist" class="-mb-px flex space-x-8" aria-orientation="horizontal" role="tablist">
                            <li>
                                <button x-bind="tab" id="tab-description" class="whitespace-nowrap border-b-2 py-6 text-sm font-medium" :class="isSelected($el.id) ? 'border-gradient-to-r from-purple-600 to-pink-600 text-purple-600 dark:text-purple-400' : 'border-transparent text-slate-700 hover:text-slate-800 hover:border-slate-300 dark:text-slate-300 dark:hover:text-slate-200 dark:hover:border-slate-600'" aria-controls="tab-panel-description" role="tab" type="button">
                                    {{ __('Product Description') }}
                                </button>
                            </li>
                            <li>
                                <button x-bind="tab" id="tab-reviews" class="whitespace-nowrap border-b-2 py-6 text-sm font-medium" :class="isSelected($el.id) ? 'border-gradient-to-r from-purple-600 to-pink-600 text-purple-600 dark:text-purple-400' : 'border-transparent text-slate-700 hover:text-slate-800 hover:border-slate-300 dark:text-slate-300 dark:hover:text-slate-200 dark:hover:border-slate-600'" aria-controls="tab-panel-reviews" role="tab" type="button">
                                    {{ __('Customer Reviews') }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <div x-show="isSelected($id('tabs', whichChild($el, $el.parentElement)))" id="tab-panel-description" class="pt-6" role="tabpanel" tabindex="0" aria-labelledby="tab-description">
                            <h3 class="sr-only">{{ __('Product Description') }}</h3>

                            <div class="prose prose-sm prose-slate max-w-none dark:prose-invert">
                                {!! $product->description !!}
                            </div>
                        </div>
                        <div x-cloak x-show="isSelected($id('tabs', whichChild($el, $el.parentElement)))" id="tab-panel-reviews" class="-mb-10" role="tabpanel" tabindex="0" aria-labelledby="tab-reviews">
                            <h3 class="sr-only">{{ __('Customer Reviews') }}</h3>

                            @foreach($product->reviews as $review)
                                <div class="flex space-x-4 text-sm text-slate-500 dark:text-slate-400">
                                    <div class="flex-none py-10">
                                        <img src="{{ $review->customer->getFirstMediaUrl('avatar') }}" alt="{{ $review->customer->name }}" class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-800">
                                    </div>
                                    <div class="flex-1 py-10">
                                        <h3 class="font-medium text-slate-900 dark:text-slate-100">
                                            {{ $review->customer->name }}
                                        </h3>
                                        <p>
                                            <time datetime="{{ $review->created_at->format('Y-m-d')}}">
                                                {{ $review->created_at->format('F j, Y') }}
                                            </time>
                                        </p>
                                        <div class="mt-4">
                                            <x-star-rating :rating="$review->rating" />
                                        </div>
                                        <p class="sr-only">
                                            {{ __(':rating out of 5 stars', ['rating' => $review->rating]) }}
                                        </p>
                                        <h3 class="mt-4 font-medium text-slate-900 dark:text-slate-100">
                                            {{ $review->title }}
                                        </h3>
                                        <div class="prose prose-sm prose-slate mt-1 max-w-none dark:prose-invert">
                                            {!! $review->content !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recently viewed products -->
            <div class="pt-12 px-4 sm:pt-24 sm:px-0">
                <div class="flex items-center justify-between space-x-4">
                    <h2 class="text-lg font-medium text-purple-900 dark:text-purple-100">{{ __('Recently viewed products') }}</h2>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                    @foreach($this->recentlyViewedProducts as $product)
                        <div class="group flex flex-col relative rounded-lg p-4 ring-1 ring-gradient-to-r from-purple-200 to-pink-200 sm:p-6 hover:ring-gradient-to-r hover:from-purple-300 hover:to-pink-300 hover:shadow-lg hover:shadow-purple-300/50 transition dark:ring-gradient-to-r dark:from-purple-800 dark:to-pink-800 dark:hover:from-purple-700 dark:hover:to-pink-700 dark:hover:shadow-purple-800/50">
                            <div class="aspect-h-9 aspect-w-8 overflow-hidden rounded-lg group-hover:opacity-75">
                                @if($product->hasMedia('gallery'))
                                    {{ $product->getFirstMedia('gallery')->hasGeneratedConversion('responsive') ? $product->getFirstMedia('gallery')('responsive')->attributes(['class' => 'w-full h-full object-cover object-center'])->lazy() : $product->getFirstMedia('gallery')()->lazy() }}
                                @else
                                    <img src="{{ $product->getFirstMediaUrl('media') }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover">
                                @endif
                            </div>
                            <div class="flex flex-col flex-1 pb-4 pt-10 text-center">
                                <h3 class="text-sm font-medium text-slate-900 line-clamp-1 dark:text-slate-100">
                                    <a href="{{ route('guest.products.detail', $product) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-4 text-base font-medium text-slate-900 dark:text-slate-100">
                                    <x-money :amount="$product->price" />
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tabs', () => ({
                selectedId: null,
                init() {
                    this.$nextTick(() => this.select(this.$id('tabs', 1)))
                },
                select(id) {
                    this.selectedId = id
                },
                isSelected(id) {
                    return this.selectedId === id
                },
                whichChild(el, parent) {
                    return Array.from(parent.children).indexOf(el) + 1
                }
            }))
            Alpine.bind('tablist', () => ({
                ['x-ref']: 'tablist',
                ['@keydown.right.prevent.stop']() {
                    this.$focus.wrap().next()
                },
                ['@keydown.home.prevent.stop']() {
                    this.$focus.first()
                },
                ['@keydown.page-up.prevent.stop']() {
                    this.$focus.first()
                },
                ['@keydown.left.prevent.stop']() {
                    this.$focus.wrap().prev()
                },
                ['@keydown.end.prevent.stop']() {
                    this.$focus.last()
                },
                ['@keydown.page-down.prevent.stop']() {
                    this.$focus.last()
                },
            }))
            Alpine.bind('tab', () => ({
                [':id']() {
                    return this.$id('tabs', this.whichChild(this.$el.parentElement, this.$refs.tablist))
                },
                ['@click']() {
                    this.select(this.$el.id)
                },
                ['@focus']() {
                    this.select(this.$el.id)
                },
                [':tabindex']() {
                    return this.isSelected(this.$el.id) ? 0 : -1
                },
                [':aria-selected']() {
                    return this.isSelected(this.$el.id)
                },
                [':class']() {
                    return this.isSelected(this.$el.id) ? 'border-gradient-to-r from-purple-600 to-pink-600 text-purple-600 dark:text-purple-400' : 'border-transparent text-slate-700 hover:text-slate-800 hover:border-slate-300 dark:text-slate-300 dark:hover:text-slate-200 dark:hover:border-slate-600'
                },
            }))
        })
    </script>
@endpush
