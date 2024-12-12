<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <x-slot:title>
        {{ __('Collections') }}
    </x-slot:title>

    <div class="border-b border-purple-200 dark:border-purple-700">
        <nav aria-label="Breadcrumb" class="mx-auto max-w-7xl overflow-hidden whitespace-nowrap px-4 sm:px-6 lg:px-8">
            <ol role="list" class="flex items-center space-x-4 py-4">
                <li>
                    <div class="flex items-center">
                        <a href="/" class="mr-4 text-sm font-medium text-purple-900 dark:text-purple-100">
                            Home
                        </a>
                        <svg viewBox="0 0 6 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-5 w-auto text-purple-300 dark:text-purple-600">
                            <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />
                        </svg>
                    </div>
                </li>
                <li class="text-sm truncate">
                    <a href="{{ route('guest.collections.list') }}" aria-current="page" class="font-medium text-purple-500 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-200">
                        {{ __('Collections') }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <main class="mx-auto max-w-2xl px-4 lg:max-w-7xl lg:px-8">
        <div class="border-b border-purple-200 dark:border-purple-700 pt-24 pb-10">
            <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('All collections') }}
            </h1>
        </div>

        <div class="pt-12 pb-24">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($collections as $collection)
                    <div class="group aspect-w-2 aspect-h-1 overflow-hidden rounded-lg sm:relative sm:h-full shadow-md hover:shadow-lg transition-shadow duration-300">
                        <img
                            src="{{ $collection->getFirstMediaUrl('cover') }}"
                            alt="{{ $collection->title }}"
                            class="object-cover object-center group-hover:opacity-75 sm:absolute sm:inset-0 sm:h-full sm:w-full"
                        >
                        <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 sm:absolute sm:inset-0"></div>
                        <div class="flex items-end p-6 sm:absolute sm:inset-0">
                            <div>
                                <h3 class="font-semibold text-lg text-white">
                                    <a href="{{ route('guest.collections.detail', $collection) }}" class="hover:underline">
                                        <span class="absolute inset-0"></span>
                                        {{ $collection->title }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $collections->links() }}
            </div>
        </div>
    </main>
</div>
