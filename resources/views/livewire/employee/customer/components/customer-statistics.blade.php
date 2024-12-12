<div>
    <x-card>
        <x-slot:content>
            <dl class="grid grid-cols-1 divide-y divide-slate-200 md:grid-cols-3 md:divide-y-0 md:divide-x dark:divide-white/10">
                <div class="py-3 sm:pr-4 sm:py-1">
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Amount spent') }}</dt>
                    <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                        <div class="flex items-baseline text-2xl font-semibold text-slate-900 dark:text-slate-200">
                            <x-money :amount="$customer->orders->sum('total')" />
                        </div>
                    </dd>
                </div>

                <div class="py-3 sm:px-4 sm:py-1">
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Orders') }}</dt>
                    <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                        <div class="flex items-baseline text-2xl font-semibold text-slate-900 dark:text-slate-200">
                            {{ $customer->orders_count }}
                        </div>
                    </dd>
                </div>

                <div class="py-3 sm:pl-4 sm:py-1">
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Average order amount') }}</dt>
                    <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                        <div class="flex items-baseline text-2xl font-semibold text-slate-900 dark:text-slate-200">
                            <x-money :amount="$customer->orders->avg('total')" />
                        </div>
                    </dd>
                </div>
            </dl>
        </x-slot:content>
    </x-card>
</div>
