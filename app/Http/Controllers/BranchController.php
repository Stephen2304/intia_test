<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::paginate(10);
        return view('branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
        ]);
        Branch::create($request->only(['name', 'location', 'contact_info']));
        return redirect()->route('branches.index')->with('success', 'Branche ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
        ]);
        $branch = Branch::findOrFail($id);
        $branch->update($request->only(['name', 'location', 'contact_info']));
        return redirect()->route('branches.index')->with('success', 'Branche modifiée avec succès.');
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branche supprimée avec succès.');
    }
} 