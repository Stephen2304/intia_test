<div x-data="{ open: false }" class="inline">
    <button @click="open = true" type="button" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 ml-2" title="Supprimer">
        @if(isset($icon) && $icon)
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4V4a2 2 0 114 0v1m-4 0h4" /></svg>
        @else
            Supprimer
        @endif
    </button>
    <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-bold mb-4 text-red-700">Confirmer la suppression</h2>
            <p class="mb-4">Voulez-vous vraiment supprimer le client <h6 class="font-semibold">{{ $client->first_name }} {{ $client->last_name }} ?</h6> </p>
            <form method="POST" action="{{ route('clients.destroy', $client->id) }}">
                @csrf
                @method('DELETE')
                <div class="flex justify-end">
                    <button type="button" @click="open = false" class="mr-2 px-4 py-2 rounded bg-gray-300 dark:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div> 