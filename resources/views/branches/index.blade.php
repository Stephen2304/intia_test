<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Branches') }}
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
                        <h3 class="text-lg font-bold">Liste des branches</h3>
                        @include('components.add-branch-modal')
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localisation</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $branch->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $branch->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $branch->contact_info }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            @include('components.edit-branch-modal', ['branch' => $branch, 'icon' => true])
                                            @include('components.delete-branch-modal', ['branch' => $branch, 'icon' => true])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $branches->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 