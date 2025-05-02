<div x-data="{ open: false }">
    <button @click="open = true" type="button" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600" title="Modifier">
        @if(isset($icon) && $icon)
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm0 0V21h8" /></svg>
        @else
            Modifier
        @endif
    </button>
    <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-bold mb-4">Modifier le client</h2>
            <form method="POST" action="{{ route('clients.update', $client->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Nom</label>
                    <input type="text" name="last_name" value="{{ $client->last_name }}" class="w-full border rounded px-3 py-2" placeholder="Nom du client">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Prénom</label>
                    <input type="text" name="first_name" value="{{ $client->first_name }}" class="w-full border rounded px-3 py-2" placeholder="Prénom du client">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Téléphone</label>
                    <input type="text" name="phone" value="{{ $client->phone }}" class="w-full border rounded px-3 py-2" placeholder="Téléphone">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $client->email }}" class="w-full border rounded px-3 py-2" placeholder="Email">
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="open = false" class="mr-2 px-4 py-2 rounded bg-gray-300 dark:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded bg-yellow-600 text-white">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div> 