<div>
    <x-modal-dialog wire:model="isShown">
        <x-slot:title>
            <h2 class="text-lg font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Shopping cart') }}
            </h2>
        </x-slot:title>
        <x-slot:content>
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
                        <button x-on:click="show = false"
                                type="button"
                                class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                            {{ __('Continue shopping') }}
                        </button>
                    </div>
                </div>
            @else
                <section aria-labelledby="cart-heading">
                    <h3 id="cart-heading" class="sr-only">
                        {{ __('Items in your shopping cart') }}
                    </h3>

                    <ul role="list" class="divide-y divide-purple-200 border-b border-purple-200">
                        @foreach($cartItems as $item)
                            <li class="flex py-6">
                                <div class="flex-shrink-0 border border-purple-200 rounded-md">
                                    <img src="{{ $item->variant->hasMedia('image') ? $item->variant->getFirstMediaUrl('image') : $item->product->getFirstMediaUrl('gallery', 'thumb_large') }}"
                                         alt="{{ $item->product->name }}"
                                         class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32">
                                </div>

                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <div class="flex justify-between">
                                            <h4 class="text-sm line-clamp-2">
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
                                    <div class="flex flex-1 items-end justify-between text-sm">
                                        <p class="text-slate-600 dark:text-slate-400">{{ __('Quantity: :count', ['count' => $item->quantity]) }}</p>

                                        <div class="flex">
                                            <button wire:click="removeCartItem('{{ $item->id }}')"
                                                    type="button"
                                                    class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700">
                                                {{ __('Remove') }}
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

                    <div class="mt-10 space-y-3">
                        <a href="{{ route('guest.cart') }}"
                           class="btn btn-default btn-lg w-full border border-purple-300 text-purple-700 hover:bg-purple-50 dark:border-purple-700 dark:text-purple-300 dark:hover:bg-purple-900">
                            {{ __('View cart') }}
                        </a>
                        <a href="{{ route('guest.checkout') }}"
                           class="btn btn-lg w-full px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300">
                            {{ __('Proceed to checkout') }}
                        </a>
                    </div>

                    <div class="mt-6 text-center text-sm">
                        <p>
                            {{ __('or') }}
                            <button x-on:click="show = false"
                                    type="button"
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700">
                                {{ __('Continue Shopping') }}
                                <span aria-hidden="true"> &rarr;</span>
                            </button>
                        </p>
                    </div>
                </section>
            @endunless
        </x-slot:content>
    </x-modal-dialog>
</div>
