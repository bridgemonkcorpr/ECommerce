<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">

                   <a href="{{ route('employee.collections.list') }}"
                    class="bg-white dark:bg-purple-800 p-2 rounded-full shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 transition-colors duration-200"
                >
                    <x-heroicon-m-arrow-left class="w-6 h-6 text-purple-600 dark:text-purple-300" />
                </a>
                <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                    {{ $collection->title }}
                </h1>
            </div>

               <a href="{{ route('guest.collections.detail', $collection) }}"
                target="_blank"
                class="px-4 py-2 bg-white dark:bg-purple-800 text-purple-600 dark:text-purple-400 font-semibold rounded-lg shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
            >
                {{ __('Preview') }}
            </a>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Collection Information') }}
                        </h2>
                        <livewire:employee.collection.components.collection-information :collection="$collection" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Collection Products') }}
                        </h2>
                        <livewire:employee.collection.components.collection-product :collection="$collection" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Search Engine Information') }}
                        </h2>
                        <livewire:employee.search-engine-information-form :model="$collection" />
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1 space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Collection Availability') }}
                        </h2>
                        <livewire:employee.collection.components.collection-availability :collection="$collection" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Collection Cover') }}
                        </h2>
                        <livewire:employee.collection.components.collection-cover :collection="$collection" />
                    </div>
                </div>

                <button
                    wire:click="$set('confirmingCollectionDeletion', true)"
                    type="button"
                    class="w-full px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition-all duration-300"
                >
                    {{ __('Delete collection') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal-alert wire:model.defer="confirmingCollectionDeletion">
        <x-slot:title>
            {{ __('Please confirm your action!') }}
        </x-slot:title>
        <x-slot:content>
            {{ __('Are you sure you want to delete this collection? This action cannot be undone!') }}
        </x-slot:content>
        <x-slot:footer>
            <button
                wire:click.prevent="delete"
                type="button"
                class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition-all duration-300"
            >
                {{ __('Delete') }}
            </button>
            <button
                x-on:click="show = false"
                type="button"
                class="ml-3 px-4 py-2 bg-purple-200 text-purple-800 font-semibold rounded-lg shadow-md hover:bg-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-75 transition-all duration-300"
            >
                {{ __('Cancel') }}
            </button>
        </x-slot:footer>
    </x-modal-alert>
</div>
