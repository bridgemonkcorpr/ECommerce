<div>
    <x-card>
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Payment') }}
                    </h3>
                </div>
                @if($order->total_paid > 0)
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <a
                            href="{{ route('employee.orders.refund', $order) }}"
                            class="btn btn-link  text-purple-600"
                        >
                            {{ __('Refund payment') }}
                        </a>
                    </div>
                @endif
            </div>
        </x-slot:header>
        <x-slot:content class="-mx-4 -my-5 sm:-mx-6">
            <dl @class(['border-t border-slate-200 divide-y divide-slate-100 dark:border-slate-200/20 dark:divide-slate-200/5', '-mb-5' => $order->payment_status === \App\Enums\PaymentStatus::PAID])>
                <div class="p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium leading-6 text-slate-500 dark:text-slate-400">
                        {{ __('Subtotal') }}
                    </dt>
                    <dd class="mt-1 flex text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0 dark:text-slate-400">
                        <div class="flex-grow">
                            {{ trans_choice(':count item|:count items', $this->total_order_items_quantity) }}
                        </div>
                        <div class="ml-4 flex-shrink-0 text-right tabular-nums">
                            <x-money
                                :amount="$order->subtotal"
                                :currency="config('app.currency')"
                            />
                        </div>
                    </dd>
                </div>
                @if($order->orderDiscounts->count())
                    <div class="p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium leading-6 text-slate-500 dark:text-slate-400">
                            {{ __('Discount') }}
                        </dt>
                        <dd class="mt-1 flex text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0 dark:text-slate-400">
                            <div class="flex-grow">
                                <ul>
                                    @foreach($order->orderDiscounts as $discount)
                                        <li>{{ $discount->code }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="ml-4 flex-shrink-0 text-right tabular-nums">
                                <ul>
                                    @foreach($order->orderDiscounts as $discount)
                                        <li>
                                            <x-money
                                                :amount="$discount->discounted_amount"
                                                :currency="config('app.currency')"
                                            />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </dd>
                    </div>
                @endif
                <div class="p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium leading-6 text-slate-500 dark:text-slate-400">
                        {{ __('Shipping') }}
                    </dt>
                    <dd class="mt-1 flex text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0 dark:text-slate-400">
                        <div class="flex-grow">
                            {{ $order->shipping_rate }}
                        </div>
                        <div class="ml-4 flex-shrink-0 text-right tabular-nums">
                            <x-money
                                :amount="$order->shipping_price"
                                :currency="config('app.currency')"
                            />
                        </div>
                    </dd>
                </div>
                @if($order->tax_breakdown)
                    <div class="p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium leading-6 text-slate-500 dark:text-slate-400">
                            {{ __('Tax') }}
                        </dt>
                        <dd class="mt-1 flex text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0 dark:text-slate-400">
                            <div class="flex-grow">
                                <ul>
                                    @foreach($order->tax_breakdown as $line)
                                        <li>
                                            {{ $line['name'] }} {{ $line['percentage'] }}%
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="ml-4 flex-shrink-0 text-right tabular-nums">
                                <ul>
                                    @foreach($order->tax_breakdown as $line)
                                        <li>
                                            <x-money
                                                :amount="($order->subtotal - $order->discount_total) * $line['percentage'] / 100"
                                                :currency="config('app.currency')"
                                            />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </dd>
                    </div>
                @endif
                <div class="flex items-center justify-between p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Total') }}
                    </dt>
                    <dd class="text-sm font-medium text-slate-900 tabular-nums sm:col-span-2 sm:text-right dark:text-slate-200">
                        <x-money
                            :amount="$order->total"
                            :currency="config('app.currency')"
                        />
                    </dd>
                </div>
                <div class="p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">
                        {{ __('Paid by customer') }}
                    </dt>
                    <dd class="mt-1 flex text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0 dark:text-slate-400">
                        <div class="flex-grow">
                            {{ $order->paymentMethod->name }}
                        </div>
                        <div class="ml-4 flex-shrink-0 text-right tabular-nums">
                            <x-money
                                :amount="$order->total_paid"
                                :currency="config('app.currency')"
                            />
                        </div>
                    </dd>
                </div>
                @if($order->refunds->count())
                    <div class="p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium leading-6 text-slate-500 dark:text-slate-400">
                            {{ __('Refunded') }}
                        </dt>
                        <dd class="mt-1 flex text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0 dark:text-slate-400">
                            <div class="flex-grow">
                                <ul>
                                    @foreach($order->refunds as $refund)
                                        <li>{{ __('Reason:') }} {!! $refund->reason ?? '&mdash;' !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="ml-4 flex-shrink-0 text-right tabular-nums">
                                <ul>
                                    @foreach($order->refunds as $refund)
                                        <li>
                                            <x-money
                                                :amount="-$refund->amount"
                                                :currency="config('app.currency')"
                                            />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </dd>
                    </div>
                    <div class="p-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Net payment') }}
                        </dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900 sm:mt-0 sm:col-span-2 sm:text-right tabular-nums dark:text-slate-200">
                            <x-money
                                :amount="$order->total_paid - $order->total_refunded"
                                :currency="config('app.currency')"
                            />
                        </dd>
                    </div>
                @endif
            </dl>
        </x-slot:content>

        @if(! $order->paymentMethod->is_third_party && $order->payment_status !== \App\Enums\PaymentStatus::PAID && ! $order->refunds->count())
            <x-slot:footer class="bg-slate-50 dark:bg-slate-800/75">
                <div class="flex justify-end">
                    <button
                        wire:click="confirmMarkingPaymentAsPaid"
                        wire:target="confirmingMarkingAsPaid"
                        wire:loading.attr="disabled"
                        class="btn btn-primary bg-purple-600 hover:bg-purple-700"
                    >
                        {{ __('Mark as paid') }}
                    </button>
                </div>
            </x-slot:footer>
        @endif
    </x-card>

    <x-modal-alert wire:model="confirmingMarkingAsPaid">
        <x-slot name="title">
            {{ __('Mark as paid') }}
        </x-slot>
        <x-slot name="content">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ __('Processed by') }}
                <span class="font-medium text-slate-700 dark:text-slate-200">{{ $order->paymentMethod->name }}</span>
            </p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ __('If you received payment manually, mark this order as paid.') }}
            </p>
        </x-slot>
        <x-slot name="footer">
            <button
                wire:click="markAsPaid"
                wire:target="markAsPaid"
                wire:loading.attr="disabled"
                class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full sm:ml-3 sm:w-auto"
            >
                {{ __('Mark as paid') }}
            </button>
            <button
                x-on:click="show = false"
                class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot>
    </x-modal-alert>
</div>
