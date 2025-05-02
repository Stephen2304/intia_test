<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();
        $adminBranch = $branches->where('name', 'Direction Générale')->first();
        $admin = User::create([
            'name' => 'Admin INTIA',
            'email' => 'admin@intia.com',
            'password' => Hash::make('password'),
            'branch_id' => $adminBranch ? $adminBranch->id : null,
        ]);
        $admin->assignRole('admin');

        $counter = 1;
        foreach ($branches as $branch) {
            $user = User::create([
                'name' => 'Agent ' . $branch->name,
                'email' => 'agent' . $counter . '@intia.com',
                'password' => Hash::make('password'),
                'branch_id' => $branch->id,
            ]);
            $user->assignRole('agent');
            $counter++;
        }
    }
} 