<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <!-- Meta title & description -->
    <x-slot:title>
        {{ __('Profile') }}
    </x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Profile') }}
            </h1>
        </div>

        <!-- Page content -->
        <div class="space-y-12">
            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-6">
                        {{ __('Personal Information') }}
                    </h2>
                    <livewire:employee.profile.components.personal-information />
                </div>
            </div>

            <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-6">
                        {{ __('Change Password') }}
                    </h2>
                    <livewire:employee.profile.components.change-password />
                </div>
            </div>
        </div>
    </div>
</div>
