<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Client;
use App\Models\InsurancePolicy;
use App\Models\InsuranceType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class InsurancePolicyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $agent;
    protected $branch;
    protected $client;
    protected $insuranceType;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer les rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'agent']);
        
        // Créer une branche
        $this->branch = Branch::factory()->create();

        // Créer un client
        $this->client = Client::factory()->create(['branch_id' => $this->branch->id]);

        // Créer un type d'assurance
        $this->insuranceType = InsuranceType::factory()->create();

        // Créer un utilisateur admin
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        // Créer un utilisateur agent
        $this->agent = User::factory()->create([
            'branch_id' => $this->branch->id
        ]);
        $this->agent->assignRole('agent');
    }

    /** @test */
    public function admin_can_view_insurance_policies_index()
    {
        $response = $this->actingAs($this->admin)->get(route('insurance_policies.index'));
        $response->assertStatus(200);
        $response->assertViewIs('insurance_policies.index');
    }

    /** @test */
    public function agent_can_view_insurance_policies_index()
    {
        $response = $this->actingAs($this->agent)->get(route('insurance_policies.index'));
        $response->assertStatus(200);
        $response->assertViewIs('insurance_policies.index');
    }

    /** @test */
    public function admin_can_create_insurance_policy()
    {
        $policyData = [
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id,
            'policy_number' => 'POL123456',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
            'coverage_amount' => 1000000.00,
            'annual_premium' => 1000.00,
            'status' => 'active'
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('insurance_policies.store'), $policyData);

        $response->assertRedirect(route('insurance_policies.index'));
        $this->assertDatabaseHas('insurance_policies', $policyData);
    }

    /** @test */
    public function agent_can_create_insurance_policy_for_their_branch_client()
    {
        $policyData = [
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id,
            'policy_number' => 'POL123456',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
            'coverage_amount' => 1000000.00,
            'annual_premium' => 1000.00,
            'status' => 'active'
        ];

        $response = $this->actingAs($this->agent)
            ->post(route('insurance_policies.store'), $policyData);

        $response->assertRedirect(route('insurance_policies.index'));
        $this->assertDatabaseHas('insurance_policies', $policyData);
    }

    /** @test */
    public function agent_cannot_create_insurance_policy_for_other_branch_client()
    {
        $otherBranch = Branch::factory()->create();
        $otherClient = Client::factory()->create(['branch_id' => $otherBranch->id]);
        
        $policyData = [
            'client_id' => $otherClient->id,
            'insurance_type_id' => $this->insuranceType->id,
            'policy_number' => 'POL123456',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
            'coverage_amount' => 1000000.00,
            'annual_premium' => 1000.00,
            'status' => 'active'
        ];

        $response = $this->actingAs($this->agent)
            ->post(route('insurance_policies.store'), $policyData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('insurance_policies', $policyData);
    }

    /** @test */
    public function admin_can_update_insurance_policy()
    {
        $policy = InsurancePolicy::factory()->create([
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id
        ]);

        $updatedData = [
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id,
            'policy_number' => 'POL654321',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
            'coverage_amount' => 1500000.00,
            'annual_premium' => 1500.00,
            'status' => 'active'
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('insurance_policies.update', $policy), $updatedData);

        $response->assertRedirect(route('insurance_policies.index'));
        $this->assertDatabaseHas('insurance_policies', $updatedData);
    }

    /** @test */
    public function agent_can_update_insurance_policy_for_their_branch_client()
    {
        $policy = InsurancePolicy::factory()->create([
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id
        ]);

        $updatedData = [
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id,
            'policy_number' => 'POL654321',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
            'coverage_amount' => 1500000.00,
            'annual_premium' => 1500.00,
            'status' => 'active'
        ];

        $response = $this->actingAs($this->agent)
            ->put(route('insurance_policies.update', $policy), $updatedData);

        $response->assertRedirect(route('insurance_policies.index'));
        $this->assertDatabaseHas('insurance_policies', $updatedData);
    }

    /** @test */
    public function agent_cannot_update_insurance_policy_for_other_branch_client()
    {
        $otherBranch = Branch::factory()->create();
        $otherClient = Client::factory()->create(['branch_id' => $otherBranch->id]);
        $policy = InsurancePolicy::factory()->create([
            'client_id' => $otherClient->id,
            'insurance_type_id' => $this->insuranceType->id
        ]);

        $updatedData = [
            'client_id' => $otherClient->id,
            'insurance_type_id' => $this->insuranceType->id,
            'policy_number' => 'POL654321',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
            'coverage_amount' => 1500000.00,
            'annual_premium' => 1500.00,
            'status' => 'active'
        ];

        $response = $this->actingAs($this->agent)
            ->put(route('insurance_policies.update', $policy), $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('insurance_policies', $updatedData);
    }

    /** @test */
    public function admin_can_delete_insurance_policy()
    {
        $policy = InsurancePolicy::factory()->create([
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('insurance_policies.destroy', $policy));

        $response->assertRedirect(route('insurance_policies.index'));
        $this->assertDatabaseMissing('insurance_policies', ['id' => $policy->id]);
    }

    /** @test */
    public function agent_can_delete_insurance_policy_for_their_branch_client()
    {
        $policy = InsurancePolicy::factory()->create([
            'client_id' => $this->client->id,
            'insurance_type_id' => $this->insuranceType->id
        ]);

        $response = $this->actingAs($this->agent)
            ->delete(route('insurance_policies.destroy', $policy));

        $response->assertRedirect(route('insurance_policies.index'));
        $this->assertDatabaseMissing('insurance_policies', ['id' => $policy->id]);
    }

    /** @test */
    public function agent_cannot_delete_insurance_policy_for_other_branch_client()
    {
        $otherBranch = Branch::factory()->create();
        $otherClient = Client::factory()->create(['branch_id' => $otherBranch->id]);
        $policy = InsurancePolicy::factory()->create([
            'client_id' => $otherClient->id,
            'insurance_type_id' => $this->insuranceType->id
        ]);

        $response = $this->actingAs($this->agent)
            ->delete(route('insurance_policies.destroy', $policy));

        $response->assertStatus(403);
        $this->assertDatabaseHas('insurance_policies', ['id' => $policy->id]);
    }
} 