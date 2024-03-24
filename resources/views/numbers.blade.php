<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">
                                Numbers
                            </h1>
                            <p class="mt-2 text-sm text-gray-700">
                                List of Numbers in the system.
                            </p>
                        </div>
                        <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-none">
                            <x-button onclick="Livewire.dispatch('openModal', { component: 'numbers.create' })" loading-on-dispatch-wire-event="openModal">
                                Create Number
                            </x-button>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        @livewire('numbers.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

