<div x-data="{ open: false }">
    <button @click="open = true" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
    <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-bold mb-4">Ajouter une police d'assurance</h2>
            <form method="POST" action="{{ route('insurance_policies.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Numéro de police</label>
                    <input type="text" name="policy_number" class="w-full border rounded px-3 py-2" placeholder="Numéro de police">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Client</label>
                    <input type="text" name="client_id" class="w-full border rounded px-3 py-2" placeholder="ID du client">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Type d'assurance</label>
                    <select name="insurance_type_id" class="w-full border rounded px-3 py-2">
                        @foreach($insuranceTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="open = false" class="mr-2 px-4 py-2 rounded bg-gray-300 dark:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div> 