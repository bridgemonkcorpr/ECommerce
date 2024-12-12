<main class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900 min-h-screen">
{{-- This is our dynamic banner --}}

        <h1>About us</h1>




    {{-- This is our static banner --}}



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
        </section>


</main>
