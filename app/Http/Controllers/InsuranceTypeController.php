<?php

namespace App\Http\Controllers;

use App\Models\InsuranceType;
use Illuminate\Http\Request;

class InsuranceTypeController extends Controller
{
    public function index()
    {
        $insuranceTypes = InsuranceType::paginate(10);
        return view('insurance_types.index', compact('insuranceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        InsuranceType::create($request->only(['name', 'description']));
        return redirect()->route('insurance_types.index')->with('success', 'Type d\'assurance ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $type = InsuranceType::findOrFail($id);
        $type->update($request->only(['name', 'description']));
        return redirect()->route('insurance_types.index')->with('success', 'Type d\'assurance modifié avec succès.');
    }

    public function destroy($id)
    {
        $type = InsuranceType::findOrFail($id);
        $type->delete();
        return redirect()->route('insurance_types.index')->with('success', 'Type d\'assurance supprimé avec succès.');
    }
} 