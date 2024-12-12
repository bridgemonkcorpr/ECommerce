<aside
    wire:ignore
    class="pb-4 flex overflow-x-auto border-b border-purple-900/5 xl:block xl:w-64 xl:flex-none xl:border-0 xl:pb-0"
>
    <nav class="flex-none">
        <ul
            role="list"
            class="flex gap-x-3 gap-y-1 whitespace-nowrap xl:flex-col"
        >
            <li>
                <a
                    href="{{ route('employee.settings.general') }}"
                    @class(['group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm leading-6 font-semibold', 'bg-purple-50 text-purple-600 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.general'), 'text-purple-700 hover:text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-slate-800 dark:hover:text-white' => ! request()->routeIs('employee.settings.general')])
                >
                    <x-heroicon-o-building-storefront @class(['h-6 w-6 shrink-0', 'text-purple-600 dark:text-white' => request()->routeIs('employee.settings.general'), 'text-purple-400 group-hover:text-purple-600 dark:group-hover:bg-slate-800 dark:group-hover:text-white' => ! request()->routeIs('employee.settings.general')]) />
                    {{ __('General') }}
                </a>
            </li>
            <li>
                <a
                    href="{{ route('employee.settings.branding') }}"
                    @class(['group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm leading-6 font-semibold', 'bg-purple-50 text-purple-600 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.branding'), 'text-purple-700 hover:text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-slate-800 dark:hover:text-white' => ! request()->routeIs('employee.settings.branding')])
                >
                    <x-heroicon-o-star @class(['h-6 w-6 shrink-0', 'text-purple-600 dark:text-white' => request()->routeIs('employee.settings.branding'), 'text-purple-400 group-hover:text-purple-600 dark:group-hover:bg-slate-800 dark:group-hover:text-white' => ! request()->routeIs('employee.settings.branding')]) />
                    {{ __('Brand') }}
                </a>
            </li>
            <li>
                <a
                    href="{{ route('employee.settings.user.list') }}"
                    @class(['group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm leading-6 font-semibold', 'bg-purple-50 text-purple-600 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.user.*'), 'text-purple-700 hover:text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-slate-800 dark:hover:text-white' => ! request()->routeIs('employee.settings.user.*')])
                >
                    <x-heroicon-o-user-circle @class(['h-6 w-6 shrink-0', 'text-purple-600 dark:text-white' => request()->routeIs('employee.settings.user.*'), 'text-purple-400 group-hover:text-purple-600 dark:group-hover:bg-slate-800 dark:group-hover:text-white' => ! request()->routeIs('employee.settings.user.*')]) />
                    {{ __('Users') }}
                </a>
            </li>



            <li>
                <a
                    href="{{ route('employee.settings.payments') }}"
                    @class(['group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm leading-6 font-semibold', 'bg-purple-50 text-purple-600 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.payments'), 'text-purple-700 hover:text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-slate-800 dark:hover:text-white' => ! request()->routeIs('employee.settings.payments')])
                >
                    <x-heroicon-o-credit-card @class(['h-6 w-6 shrink-0', 'text-purple-600 dark:text-white' => request()->routeIs('employee.settings.payments'), 'text-purple-400 group-hover:text-purple-600 dark:group-hover:text-white' => ! request()->routeIs('employee.settings.payments')]) />
                    {{ __('Payments') }}
                </a>
            </li>
            <li>
                <a
                    href="{{ route('employee.settings.checkout') }}"
                    @class(['group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm leading-6 font-semibold', 'bg-purple-50 text-purple-600 dark:bg-slate-800 dark:text-white' => request()->routeIs('employee.settings.checkout'), 'text-purple-700 hover:text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-slate-800 dark:hover:text-white' => ! request()->routeIs('employee.settings.checkout')])
                >
                    <x-heroicon-o-shopping-cart @class(['h-6 w-6 shrink-0', 'text-purple-600 dark:text-white' => request()->routeIs('employee.settings.checkout'), 'text-purple-400 group-hover:text-purple-600 dark:group-hover:text-white' => ! request()->routeIs('employee.settings.checkout')]) />
                    {{ __('Checkout') }}
                </a>
            </li>

        </ul>
    </nav>
</aside>
