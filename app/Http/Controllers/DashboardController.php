<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\InsurancePolicy;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Si l'utilisateur est admin, on affiche toutes les statistiques
        if ($user->hasRole('admin')) {
            $clientsCount = Client::count();
            $policiesCount = InsurancePolicy::count();
            $activePoliciesCount = InsurancePolicy::where('status', 'active')->count();
            $branchName = 'Toutes les branches';
        } else {
            // Sinon, on affiche uniquement les statistiques de la branche de l'utilisateur
            $branchId = $user->branch_id;
            $clientsCount = Client::where('branch_id', $branchId)->count();
            $policiesCount = InsurancePolicy::whereHas('client', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            })->count();
            $activePoliciesCount = InsurancePolicy::whereHas('client', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            })->where('status', 'active')->count();
            $branchName = $user->branch ? $user->branch->name : '';
        }

        return view('dashboard', [
            'clientsCount' => $clientsCount,
            'policiesCount' => $policiesCount,
            'activePoliciesCount' => $activePoliciesCount,
            'branchName' => $branchName,
        ]);
    }
} 