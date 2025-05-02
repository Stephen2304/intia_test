<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $clients = Client::paginate(10);
        } else {
            $clients = Client::where('branch_id', $user->branch_id)->paginate(10);
        }
        return view('clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);
        $user = Auth::user();
        Client::create([
            'branch_id' => $user->branch_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'code' => strtoupper(uniqid()),
        ]);
        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);
        $client = Client::findOrFail($id);
        $client->update($request->only(['first_name', 'last_name', 'phone', 'email']));
        return redirect()->route('clients.index')->with('success', 'Client modifié avec succès.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
} 