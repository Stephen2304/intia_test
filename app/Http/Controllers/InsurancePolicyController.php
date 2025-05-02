<?php

namespace App\Http\Controllers;

use App\Models\InsurancePolicy;
use App\Models\InsuranceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsurancePolicyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $insuranceTypes = InsuranceType::all();
        if ($user->hasRole('admin')) {
            $policies = InsurancePolicy::with(['client', 'type'])->paginate(10);
        } else {
            $policies = InsurancePolicy::with(['client', 'type'])
                ->whereHas('client', function($q) use ($user) {
                    $q->where('branch_id', $user->branch_id);
                })
                ->paginate(10);
        }
        return view('insurance_policies.index', compact('policies', 'insuranceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'policy_number' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'insurance_type_id' => 'required|exists:insurance_types,id',
        ]);
        InsurancePolicy::create([
            'policy_number' => $request->policy_number,
            'client_id' => $request->client_id,
            'insurance_type_id' => $request->insurance_type_id,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'coverage_amount' => 0,
            'annual_premium' => 0,
            'status' => 'active',
        ]);
        return redirect()->route('insurance_policies.index')->with('success', 'Police ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'policy_number' => 'required|string|max:255',
            'insurance_type_id' => 'required|exists:insurance_types,id',
        ]);
        $policy = InsurancePolicy::findOrFail($id);
        $policy->update($request->only(['policy_number', 'insurance_type_id']));
        return redirect()->route('insurance_policies.index')->with('success', 'Police modifiée avec succès.');
    }

    public function destroy($id)
    {
        $policy = InsurancePolicy::findOrFail($id);
        $policy->delete();
        return redirect()->route('insurance_policies.index')->with('success', 'Police supprimée avec succès.');
    }
} 