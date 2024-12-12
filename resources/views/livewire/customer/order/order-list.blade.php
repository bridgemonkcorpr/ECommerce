<div>
    <!-- Meta title & description -->
    <x-slot:title>
        {{ __('Order history') }}
    </x-slot:title>

    <div class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl sm:px-2 lg:px-8">
            <div class="mx-auto max-w-2xl px-4 lg:max-w-4xl lg:px-0">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    {{ __('Order history') }}
                </h1>
                <p class="mt-2 text-sm text-slate-500">
                    {{ __('Check the status of recent orders, manage returns, and discover similar products.') }}
                </p>
            </div>
        </div>

        <div class="mt-16">
            <h2 class="sr-only">{{ __('Recent orders') }}</h2>
            <div class="mx-auto max-w-7xl sm:px-2 lg:px-8">
                <div class="mx-auto max-w-2xl space-y-8 sm:px-4 lg:max-w-4xl lg:px-0">
                    @foreach($orders as $order)
                        <div class="border-t border-b border-slate-200 bg-white shadow-sm sm:rounded-lg sm:border">
                            <h2 class="sr-only">
                                {{ __('Order placed on') }}
                                <time datetime="{{ $order->created_at->format('Y-m-d') }}">{{ $order->created_at->toFormattedDateString() }}</time>
                            </h2>

                            <div class="flex items-center border-b border-slate-200 p-4 sm:grid sm:grid-cols-4 sm:gap-x-6 sm:p-6">
                                <dl class="grid flex-1 grid-cols-2 gap-x-6 text-sm sm:col-span-3 sm:grid-cols-3 lg:col-span-2">
                                    <div>
                                        <dt class="font-medium text-slate-900">
                                            {{ __('Order number') }}
                                        </dt>
                                        <dd class="mt-1 text-slate-500">
                                            {{ $order->id }}
                                        </dd>
                                    </div>
                                    <div class="hidden sm:block">
                                        <dt class="font-medium text-slate-900">
                                            {{ __('Date placed') }}
                                        </dt>
                                        <dd class="mt-1 text-slate-500">
                                            <time datetime="{{ $order->created_at->format('Y-m-d') }}">{{ $order->created_at->toFormattedDateString() }}</time>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-slate-900">{{ __('Total amount') }}</dt>
                                        <dd class="mt-1 font-medium text-slate-900">
                                            <x-money
                                                :amount="$order->total"
                                                :currency="config('app.currency')"
                                            />
                                        </dd>
                                    </div>
                                </dl>

                                <div class="relative flex justify-end lg:hidden">
                                    <x-dropdown>
                                        <x-slot:trigger>
                                            <button
                                                type="button"
                                                class="-m-2 flex items-center p-2 text-slate-400 hover:text-slate-500"
                                                id="menu-0-button"
                                                aria-expanded="false"
                                                aria-haspopup="true"
                                            >
                                                <span class="sr-only">{{ __('Options for order :orderId', ['orderId' => $order->id]) }}</span>
                                                <x-heroicon-o-ellipsis-vertical class="h-6 w-6" />
                                            </button>
                                        </x-slot:trigger>
                                        <x-slot:content>
                                            <x-dropdown-link href="{{ route('customer.orders.detail', $order) }}">
                                                {{ __('View') }}
                                            </x-dropdown-link>
                                        </x-slot:content>
                                    </x-dropdown>
                                </div>

                                <div class="hidden lg:col-span-2 lg:flex lg:items-center lg:justify-end lg:space-x-4">
                                    <a
                                        href="{{ route('customer.orders.detail', $order) }}"
                                        class="btn btn-outline-primary hover:bg-purple-700 text-purple-700 hover:text-white"
                                    >
                                        <span>{{ __('View Order') }}</span>
                                        <span class="sr-only">{{ $order->id }}</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Products -->
                            <h3 class="sr-only">
                                {{ __('Items') }}
                            </h3>
                            <ul
                                role="list"
                                class="divide-y divide-slate-200"
                            >
                                @foreach($order->orderItems as $item)
                                    <li class="p-4 sm:p-6">
                                        <div class="flex items-center sm:items-stretch">
                                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-200 sm:h-40 sm:w-40">
                                                <img
                                                    src="{{ $item->variant->hasMedia('image') ? $item->variant->getFirstMediaUrl('image') : $item->product->getFirstMediaUrl('gallery') }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="h-full w-full object-cover object-center"
                                                >
                                            </div>
                                            <div class="ml-6 flex flex-col flex-1 justify-between text-sm">
                                                <div>
                                                    <div class="font-medium text-slate-900 sm:flex sm:justify-between">
                                                        <h4>
                                                            {{ $item->quantity }}x
                                                            {{ $item->product->name }}
                                                        </h4>
                                                        <p class="mt-2 sm:mt-0">
                                                            <x-money
                                                                :amount="$item->price"
                                                                :currency="config('app.currency')"
                                                            />
                                                        </p>
                                                    </div>
                                                    <p class="hidden text-slate-500 sm:mt-2 sm:block">
                                                        {{ $item->product->excerpt }}
                                                    </p>
                                                    @if($item->variant->variantAttributes->count())
                                                        <ul class="mt-2 space-x-2 divide-x divide-slate-200 text-slate-700">
                                                            @foreach($item->variant->variantAttributes as $attribute)
                                                                <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="hidden mt-2 sm:flex">
                                                    <div class="flex items-center space-x-4 divide-x divide-slate-200 text-sm font-medium">
                                                        <div class="flex flex-1 justify-center">
                                                            <a
                                                                href="{{ route('guest.products.detail', $item->product) }}"
                                                                class="btn btn-link  text-purple-600 whitespace-nowrap"
                                                            >
                                                                {{ __('View product') }}
                                                            </a>
                                                        </div>
                                                        <div class="flex flex-1 justify-center pl-4">
                                                            <button
                                                                wire:click="writeReviewForProduct({{ $item->product->id }})"
                                                                type="button"
                                                                class="btn btn-link  text-purple-600 whitespace-nowrap"
                                                            >
                                                                {{ $item->product->reviews->isEmpty() ? __('Write a review') : __('Edit your review') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 sm:hidden">
                                            <div class="mt-6 flex items-center space-x-4 divide-x divide-slate-200 border-t border-slate-200 pt-4 text-sm font-medium">
                                                <div class="flex flex-1 justify-center">
                                                    <a
                                                        href="{{ route('guest.products.detail', $item->product) }}"
                                                        class="btn btn-link  text-purple-600 whitespace-nowrap"
                                                    >
                                                        {{ __('View product') }}
                                                    </a>
                                                </div>
                                                <div class="flex flex-1 justify-center pl-4">
                                                    <button
                                                        wire:click="writeReviewForProduct({{ $item->product->id }})"
                                                        type="button"
                                                        class="btn btn-link  text-purple-600 whitespace-nowrap"
                                                    >
                                                        {{ $item->product->reviews->isEmpty() ? __('Write a review') : __('Edit your review') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="saveReview">
        <x-modal-dialog wire:model="showReviewForm">
            <x-slot:title>
                {{ __('Write a review') }}
            </x-slot:title>
            <x-slot:content>
                <div class="space-y-6">
                    <div>
                        <x-input-label
                            for="review.rating"
                            :value="__('Rating')"
                        />
                        <x-select
                            wire:model.defer="review.rating"
                            id="rating"
                            class="block w-full mt-1 sm:text-sm"
                        >
                            <option value="">{{ __('Select a rating') }}</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </x-select>
                        <x-input-error
                            for="review.rating"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="review.title"
                            :value="__('Review summary')"
                        />
                        <x-input
                            wire:model.defer="review.title"
                            id="title"
                            type="text"
                            class="block w-full mt-1 sm:text-sm"
                        />
                        <x-input-error
                            for="review.title"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="review.content"
                            :value="__('Share your thoughts')"
                        />
                        <x-textarea
                            wire:model="review.content"
                            id="comment"
                            class="block w-full mt-1 sm:text-sm"
                        />
                        <x-input-error
                            for="review.content"
                            class="mt-2"
                        />
                    </div>
                </div>
            </x-slot:content>
            <x-slot:footer>
                <button
                    wire:target="save"
                    wire:loading.attr="disabled"
                    type="submit"
                    class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full sm:ml-3 sm:w-auto"
                >
                    {{ __('Save') }}
                </button>
                <button
                    wire:click="$set('showReviewForm', false)"
                    wire:target="save"
                    wire:loading.attr="disabled"
                    type="button"
                    class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
