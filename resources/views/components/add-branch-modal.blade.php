<div x-data="{ open: false }">
    <button @click="open = true" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
    <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-bold mb-4">Ajouter une branche</h2>
            <form method="POST" action="{{ route('branches.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Nom</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" placeholder="Nom de la branche">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Localisation</label>
                    <input type="text" name="location" class="w-full border rounded px-3 py-2" placeholder="Localisation">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Contact</label>
                    <input type="text" name="contact_info" class="w-full border rounded px-3 py-2" placeholder="Contact">
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="open = false" class="mr-2 px-4 py-2 rounded bg-gray-300 dark:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div> 