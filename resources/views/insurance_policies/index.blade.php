<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Polices d\'assurance') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Liste des polices</h3>
                        @include('components.add-insurance-policy-modal')
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($policies as $policy)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $policy->policy_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $policy->client->first_name }} {{ $policy->client->last_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $policy->type->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $policy->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            @include('components.edit-insurance-policy-modal', ['policy' => $policy, 'insuranceTypes' => $insuranceTypes, 'icon' => true])
                                            @include('components.delete-insurance-policy-modal', ['policy' => $policy, 'icon' => true])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $policies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 