<div @class(['space-y-6' => $physicalItems->count() || $digitalItems->count(), '-mt-6' => !$physicalItems->count() && !$digitalItems->count()])>
    @if($physicalItems->count())
        <x-card>
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Unshipped') }}
                        </h3>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <a
                            href="{{ route('employee.orders.shipments.create', ['order' => $order, 'type' => 'physical']) }}"
                            class="btn btn-link  text-purple-600"
                        >
                            {{ __('Create shipment') }}
                        </a>
                    </div>
                </div>
            </x-slot:header>
            <x-slot:content class="-mx-4 -mt-5 sm:-mx-6">
                <div class="-mb-5 space-y-6">
                    <div class="relative overflow-auto">
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
                                @foreach($physicalItems as $item)
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
                                                    @if($item->discount)
                                                        <ul class="list-disc list-inside">
                                                            <li>{{ __(':discountCode discount applied', ['discountCode' => $item->discount->code]) }}</li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-center text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            {{ $item->quantity - ($item->total_shipped + $item->total_removed + $item->total_shipped_refunded) }}
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            @if($item->discount)
                                                <span class="block text-xs line-through">
                                                    <x-money
                                                        :amount="$item->price"
                                                        :currency="config('app.currency')"
                                                    />
                                                </span>
                                                <x-money
                                                    :amount="$item->discount->type === 'fixed' ? $item->price - $item->discount->amount : $item->price - ($item->price * $item->discount->amount / 100)"
                                                    :currency="config('app.currency')"
                                                />
                                            @else
                                                <x-money
                                                    :amount="$item->price"
                                                    :currency="config('app.currency')"
                                                />
                                            @endif
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            <x-money
                                                :amount="$item->price * ($item->quantity - ($item->total_shipped + $item->total_removed + $item->total_shipped_refunded)) - $item->discount?->discounted_amount"
                                                :currency="config('app.currency')"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-slot:content>
        </x-card>
    @endif

    @if($digitalItems->count())
        <x-card class="-mx-4 sm:-mx-0 overflow-hidden">
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Unshipped') }}
                        </h3>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <a
                            href="{{ route('employee.orders.shipments.create', ['order' => $order, 'type' => 'digital']) }}"
                            class="btn btn-link  text-purple-600"
                        >
                            {{ __('Create shipment') }}
                        </a>
                    </div>
                </div>
            </x-slot:header>
            <x-slot:content class="-mx-4 -mt-5 sm:-mx-6">
                <div class="-mb-5 space-y-6">
                    <div class="relative overflow-auto">
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
                                @foreach($digitalItems as $item)
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
                                                    @if($item->discount)
                                                        <ul class="list-disc list-inside">
                                                            <li>{{ __(':discountCode discount applied', ['discountCode' => $item->discount->code]) }}</li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-center text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            {{ $item->quantity - ($item->shipment_items_sum_quantity + $item->total_removed) }}
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            @if($item->discount)
                                                <span class="block text-xs line-through">
                                                    <x-money
                                                        :amount="$item->price"
                                                        :currency="config('app.currency')"
                                                    />
                                                </span>
                                                <x-money
                                                    :amount="$item->discount->type === 'fixed' ? $item->price - $item->discount->amount : $item->price - ($item->price * $item->discount->amount / 100)"
                                                    :currency="config('app.currency')"
                                                />
                                            @else
                                                <x-money
                                                    :amount="$item->price"
                                                    :currency="config('app.currency')"
                                                />
                                            @endif
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            <x-money
                                                :amount="$item->price * ($item->quantity - ($item->shipment_items_sum_quantity + $item->refund_items_sum_quantity)) - $item->discount?->discounted_amount"
                                                :currency="config('app.currency')"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td
                                        colspan="4"
                                        class="px-3 py-4 sm:px-6 whitespace-nowrap w-full max-w-sm text-sm text-slate-500 dark:text-slate-400"
                                    >
                                        {{ __('Shipping not required.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-slot:content>
        </x-card>
    @endif
</div>
