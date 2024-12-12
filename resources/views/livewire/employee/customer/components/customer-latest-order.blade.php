<div>
    <x-card>
        <x-slot:header>
            <h2 class="text-xl font-medium leading-6 text-slate-900 dark:text-slate-100">
                {{ __('Last order placed') }}
            </h2>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            @unless($customer->orders->count())
                <p class="text-slate-500 sm:text-sm dark:text-slate-400">{{ __('This customer hasn’t placed any orders yet.') }}</p>
            @else
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <h2>
                            <a
                                href="{{ route('employee.orders.detail', ['order' => $customer->orders->last()->id]) }}"
                                class="btn btn-link  text-purple-600"
                            >
                                {{ $customer->orders->last()->id }}
                            </a>
                        </h2>
                        <div class="flex items-center text-sm text-slate-500 space-x-1 dark:text-slate-400">
                        <span
                            class="block w-2 h-2 rounded-full"
                            style="background-color: {{ $customer->orders->last()->payment_status->color() }}"
                        ></span>
                            <span>{{ $customer->orders->last()->payment_status->label() }}</span>
                        </div>
                        <div class="flex items-center text-sm text-slate-500 space-x-1 dark:text-slate-400">
                        <span
                            class="block w-2 h-2 rounded-full"
                            style="background-color: {{ $customer->orders->last()->shipping_status->color() }}"
                        ></span>
                            <span>{{ $customer->orders->last()->shipping_status->label() }}</span>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $customer->orders->last()->created_at->toDayDateTimeString() }}
                        </p>
                    </div>
                </div>

                <div class="sm:hidden">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        {{ $customer->orders->last()->created_at->toDayDateTimeString() }}
                    </p>
                </div>

                <div class="mt-5 -mx-4 relative overflow-auto sm:-mx-6">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-200/10">
                        <thead class="border-t border-slate-200 bg-slate-50 dark:border-slate-200/10 dark:bg-slate-800/75">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-3 py-3 sm:px-6 text-left text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                >
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 sm:px-6 text-center text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                >
                                    {{ __('QTY') }}
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 sm:px-6 text-right text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                >
                                    {{ __('Price') }}
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 sm:px-6 text-right text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                >
                                    {{ __('Subtotal') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-200/10">
                            @foreach($customer->orders->last()->orderItems as $item)
                                <tr>
                                    <td class="px-3 py-4 sm:px-6 w-full max-w-sm text-sm text-slate-500 dark:text-slate-400">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <img
                                                    class="h-10 w-10 rounded object-center object-cover"
                                                    src="{{ $item->variant->hasMedia('image') ? $item->variant->getFirstMediaUrl('image', 'thumb') : $item->variant->product->getFirstMediaUrl('gallery', 'thumb') }}"
                                                    alt="{{ $item->name }}"
                                                >
                                            </div>
                                            <div class="ml-4 max-w-xs flex flex-col">
                                                <div class="font-medium text-slate-900 hover:text-purple-600 truncate ... dark:text-slate-200 dark:hover:text-purple-400">
                                                    <a href="{{ route('employee.products.detail', $item->variant->product) }}">{{ $item->name }}</a>
                                                </div>
                                                @if($item->variant->variantAttributes)
                                                    <ul class="space-x-2 divide-x divide-slate-200 text-slate-500 dark:divide-slate-200/10 dark:text-slate-400">
                                                        @foreach($item->variant->variantAttributes as $attribute)
                                                            <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-center text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                        {{ $item->quantity - $item->shipment_items_sum_quantity }}
                                    </td>
                                    <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                        <x-money :amount="$item->price" />
                                    </td>
                                    <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                        <x-money :amount="$item->subtotal" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endunless
        </x-slot:content>
    </x-card>
</div>
