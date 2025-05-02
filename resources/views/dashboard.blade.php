<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de bord de la succursale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-2">Bienvenue, {{ Auth::user()->name }} !</h2>
                    <p class="mb-6">Vous êtes connecté à la branche <span class="font-semibold">{{ $branchName }}</span>.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-bold mb-4">Statistiques de la branche</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-100 dark:bg-blue-900 rounded-lg shadow p-6 flex flex-col items-center">
                        <span class="text-3xl font-bold text-blue-700 dark:text-blue-200">{{ $clientsCount }}</span>
                        <span class="mt-2 text-gray-700 dark:text-gray-300">Nombre de clients</span>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 rounded-lg shadow p-6 flex flex-col items-center">
                        <span class="text-3xl font-bold text-green-700 dark:text-green-200">{{ $policiesCount }}</span>
                        <span class="mt-2 text-gray-700 dark:text-gray-300">Nombre de polices d'assurance</span>
                    </div>
                    <div class="bg-yellow-100 dark:bg-yellow-900 rounded-lg shadow p-6 flex flex-col items-center">
                        <span class="text-3xl font-bold text-yellow-700 dark:text-yellow-200">{{ $activePoliciesCount }}</span>
                        <span class="mt-2 text-gray-700 dark:text-gray-300">Polices actives</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
