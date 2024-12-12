<div>
    <div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:px-0">
            @unless($cartItems->count())
                <div class="mb-6 mx-auto text-center">
                    <x-heroicon-o-shopping-cart class="mx-auto h-24 w-24 text-purple-400" />

                    <h3 class="mt-2 text-lg font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                        {{ __('Your shopping cart is currently empty') }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        {{ __('Before proceed to checkout you must add some products to your shopping cart.') }}
                    </p>

                    <div class="mt-6">
                        <a href="{{ route('guest.products.list') }}"
                           class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                            {{ __('Continue shopping') }}
                        </a>
                    </div>
                </div>
            @else
                <h1 class="text-center text-3xl font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 sm:text-4xl">
                    {{ __('Shopping Cart') }}
                </h1>

                <div class="mt-12">
                    <section aria-labelledby="cart-heading">
                        <h2 id="cart-heading" class="sr-only">
                            {{ __('Items in your shopping cart') }}
                        </h2>

                        <ul role="list" class="divide-y divide-purple-200 border-b border-t border-purple-200">
                            @foreach($cartItems as $item)
                                <li class="flex py-6">
                                    <div class="flex-shrink-0 border border-purple-200 rounded-md">
                                        @if($item->variant->hasMedia('image'))
                                            {{ $item->variant->getFirstMedia('image')('thumb_large')->attributes(['alt' => $item->product->name, 'class' => 'h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32']) }}
                                        @elseif($item->product->hasMedia('gallery'))
                                            {{ $item->product->getFirstMedia('gallery')('thumb_large')->attributes(['alt' => $item->product->name, 'class' => 'h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32']) }}
                                        @else
                                            <div class="relative h-24 w-24 rounded-md bg-purple-100 sm:h-32 sm:w-32">
                                                <x-heroicon-o-camera class="h-full w-16 absolute inset-0 mx-auto text-purple-400 sm:w-24" />
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                        <div>
                                            <div class="flex justify-between">
                                                <h4 class="text-sm">
                                                    <a href="{{ route('guest.products.detail', $item->product) }}"
                                                       class="font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h4>
                                                <p class="ml-4 text-sm font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                                                    <x-money :amount="$item->price" :currency="config('app.currency')" />
                                                </p>
                                            </div>
                                            @if($item->variant->variantAttributes->count())
                                                <ul class="mt-1 space-x-2 divide-x divide-purple-200 text-sm text-slate-600 dark:text-slate-400">
                                                    @foreach($item->variant->variantAttributes as $attribute)
                                                        <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>

                                        <div class="mt-4 flex flex-1 items-end justify-between">
                                            <div>
                                                <x-input-label for="quantity" class="sr-only" :value="__('Quantity')" />
                                                <x-input wire:change="updateCartItemQuantity({{ $item->id }}, $event.target.value)"
                                                         type="number"
                                                         name="quantity"
                                                         value="{{ $item->quantity }}"
                                                         id="quantity"
                                                         class="w-16 no-spinners text-center sm:text-sm bg-purple-50 border-purple-300 focus:border-purple-500 focus:ring-purple-500" />
                                            </div>
                                            <div class="ml-4">
                                                <button wire:click.prevent="removeCartItem({{ $item->id }})"
                                                        type="button"
                                                        class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700">
                                                    <span>{{ __('Remove') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                    <section aria-labelledby="summary-heading" class="mt-10">
                        <h2 id="summary-heading" class="sr-only">
                            {{ __('Order summary') }}
                        </h2>

                        <div>
                            <dl class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-base font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                                        {{ __('Subtotal') }}
                                    </dt>
                                    <dd class="ml-4 text-base font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                                        <x-money :amount="$cart->subtotal" :currency="config('app.currency')" />
                                    </dd>
                                </div>
                            </dl>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                {{ __('Shipping and taxes will be calculated at checkout.') }}
                            </p>
                        </div>

                        <div class="mt-10">
                            <a href="{{ route('guest.checkout') }}"
                               class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300 text-center block">
                                {{ __('Checkout') }}
                            </a>
                        </div>

                        <div class="mt-6 text-center text-sm">
                            <p>
                                {{ __('or') }}
                                <a href="{{ route('guest.products.list') }}"
                                   class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700">
                                    {{ __('Continue Shopping') }}
                                    <span aria-hidden="true"> &rarr;</span>
                                </a>
                            </p>
                        </div>
                    </section>
                </div>
            @endunless
        </div>
    </div>
</div>
