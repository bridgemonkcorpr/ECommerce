<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Collections') }}
            </h1>
            @if($collections->count())
                <button
                    wire:click.prevent="createNewCollection"
                    class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                >
                    {{ __('Create collection') }}
                </button>
            @endif
        </div>

        <!-- Content -->
        @if(!$collections->count() && !$search)
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden p-8 text-center">
                <x-heroicon-o-rectangle-stack class="mx-auto h-16 w-16 text-purple-400" />
                <h3 class="mt-4 text-xl font-medium text-purple-900 dark:text-purple-200">
                    {{ __('You don\'t seem to have any collections yet.') }}
                </h3>
                <p class="mt-2 text-sm text-purple-500 dark:text-purple-400">
                    {{ __('Collections are a great way to organize your products. You can create a collection for a specific type of product, like "T-shirts" or "Pants".') }}
                </p>
                <button
                    wire:click.prevent="createNewCollection"
                    class="mt-6 px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                >
                    <x-heroicon-m-plus class="-ml-1 mr-2 h-5 w-5 inline" />
                    {{ __('New collection') }}
                </button>
            </div>
        @else
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-6 border-b border-purple-200 dark:border-purple-700">
                    <div class="relative max-w-sm">
                        <input
                            wire:model.debounce.500ms="search"
                            type="text"
                            class="w-full pl-10 pr-4 py-2 border border-purple-300 rounded-lg text-purple-700 focus:outline-none focus:border-purple-500 dark:bg-purple-700 dark:border-purple-600 dark:text-purple-300"
                            placeholder="{{ __('Filter collections') }}"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-purple-400" />
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-purple-200 dark:divide-purple-700">
                        <thead class="bg-purple-50 dark:bg-purple-700">
                            <tr>
                                <th scope="col" class="relative px-6 py-3">
                                    <input
                                        wire:model="selectPage"
                                        type="checkbox"
                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-purple-300 text-purple-600 focus:ring-purple-500 dark:border-purple-600 dark:bg-purple-700 dark:ring-offset-purple-800"
                                    />
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                    @unless(count($selected))
                                        {{ __('Collection') }}
                                    @else
                                        <div class="flex items-center space-x-2">
                                            <span>{{ trans(':count selected', ['count' => count($selected)]) }}</span>
                                            <button
                                                wire:click="$set('showDeleteConfirmationModal', true)"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            >
                                                {{ __('Delete') }}
                                            </button>
                                            @if($collections->total() > $collections->count())
                                                <button
                                                    wire:click="$toggle('selectAll')"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                                >
                                                    {{ $selectAll ? __('Clear selection') : __('Select all :count collections', ['count' => $collections->total()]) }}
                                                </button>
                                            @endif
                                        </div>
                                    @endunless
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                    {{ __('Status') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-purple-500 uppercase tracking-wider dark:text-purple-400">
                                    {{ __('Products') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-purple-200 dark:bg-purple-800 dark:divide-purple-700">
                            @forelse($collections as $collection)
                                <tr class="hover:bg-purple-50 dark:hover:bg-purple-700 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input
                                            wire:model="selected"
                                            type="checkbox"
                                            value="{{ $collection->id }}"
                                            class="h-4 w-4 rounded border-purple-300 text-purple-600 focus:ring-purple-500 dark:border-purple-600 dark:bg-purple-700 dark:ring-offset-purple-800"
                                        />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden bg-purple-100 dark:bg-purple-700">
                                                @if($collection->hasMedia('cover'))
                                                    <img class="h-10 w-10 object-cover" src="{{ $collection->getFirstMediaUrl('cover') }}" alt="{{ $collection->title }}">
                                                @else
                                                    <x-heroicon-o-camera class="h-6 w-6 m-2 text-purple-400 dark:text-purple-500" />
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('employee.collections.detail', $collection->id) }}" class="text-sm font-medium text-purple-900 hover:text-purple-600 dark:text-purple-100 dark:hover:text-purple-400">
                                                    {{ $collection->title }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($collection->status == 'Unavailable')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                {{ $collection->status }}
                                            </span>
                                        @elseif($collection->status == 'Scheduled')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                {{ $collection->status }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                {{ $collection->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-purple-500 dark:text-purple-400">
                                        {{ trans_choice(':count product| :count products', $collection->products_count) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 dark:text-purple-400 text-center">
                                        <div class="flex flex-col items-center">
                                            <x-heroicon-o-magnifying-glass class="h-12 w-12 text-purple-400 dark:text-purple-300 mb-4" />
                                            <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">{{ __('No collections found') }}</h3>
                                            <p class="mt-1 text-purple-500 dark:text-purple-400">{{ __('Try changing the filters or search term') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $collections->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal-alert wire:model="showDeleteConfirmationModal">
        <x-slot:title>
            {{ __('Please confirm your action!') }}
        </x-slot:title>
        <x-slot:content>
            {{ trans_choice('Are you sure you want to delete :count collection?|Are you sure you want to delete :count collections?', count($selected)) }}
            {{ __('This action cannot be undone!') }}
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click.prevent="deleteSelected"
                class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition-all duration-300"
            >
                {{ __('Delete') }}
            </button>
            <button
                x-on:click.prevent="show = false"
                class="ml-3 px-4 py-2 bg-purple-200 text-purple-800 font-semibold rounded-lg shadow-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-75 transition-all duration-300"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>

    <!-- New Collection Modal -->
    <form wire:submit.prevent="saveNewCollection">
        <x-modal-dialog wire:model="showNewCollectionCreationModal">
            <x-slot:title>
                {{ __('Create new collection') }}
            </x-slot:title>
            <x-slot:content>
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-purple-700 dark:text-purple-300">{{ __('Title') }}</label>
                        <input
                            wire:model.defer="newCollection.title"
                            id="title"
                            type="text"
                            class="mt-1 block w-full rounded-md border-purple-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 dark:bg-purple-700 dark:border-purple-600 dark:text-white"
                            required
                            autofocus
                        />
                        @error('newCollection.title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-purple-700 dark:text-purple-300">{{ __('Description') }}</label>
                        <textarea
                            wire:model.defer="newCollection.description"
                            id="description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-purple-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 dark:bg-purple-700 dark:border-purple-600 dark:text-white"
                        ></textarea>
                        @error('newCollection.description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-slot:content>
            <x-slot:footer>
    <button
        type="submit"
        class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
    >
        {{ __('Create ') }}
    </button>
    <button
        x-on:click.prevent="show = false"
        class="ml-3 px-4 py-2 bg-purple-200 text-purple-800 font-semibold rounded-lg shadow-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-75 transition-all duration-300"
    >
        {{ __('Cancel ') }}
    </button>
</x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
