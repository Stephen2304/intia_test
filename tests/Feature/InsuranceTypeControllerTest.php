<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\InsuranceType;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InsuranceTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $agent;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer les rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'agent']);
        
        // Créer un utilisateur admin
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        // Créer un utilisateur agent
        $this->agent = User::factory()->create();
        $this->agent->assignRole('agent');
    }

    /** @test */
    public function admin_can_view_insurance_types_index()
    {
        $response = $this->actingAs($this->admin)->get(route('insurance_types.index'));
        $response->assertStatus(200);
        $response->assertViewIs('insurance_types.index');
    }

    /** @test */
    public function agent_can_view_insurance_types_index()
    {
        $response = $this->actingAs($this->agent)->get(route('insurance_types.index'));
        $response->assertStatus(200);
        $response->assertViewIs('insurance_types.index');
    }

    /** @test */
    public function admin_can_create_insurance_type()
    {
        $typeData = [
            'name' => 'Assurance Auto',
            'description' => 'Assurance pour véhicules automobiles',
            'coverage_details' => 'Responsabilité civile, dommages, vol',
            'status' => 'active'
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('insurance_types.store'), $typeData);

        $response->assertRedirect(route('insurance_types.index'));
        $this->assertDatabaseHas('insurance_types', $typeData);
    }

    /** @test */
    public function agent_cannot_create_insurance_type()
    {
        $typeData = [
            'name' => 'Assurance Auto',
            'description' => 'Assurance pour véhicules automobiles',
            'coverage_details' => 'Responsabilité civile, dommages, vol',
            'status' => 'active'
        ];

        $response = $this->actingAs($this->agent)
            ->post(route('insurance_types.store'), $typeData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('insurance_types', $typeData);
    }

    /** @test */
    public function admin_can_update_insurance_type()
    {
        $type = InsuranceType::factory()->create();
        $updatedData = [
            'name' => 'Assurance Auto Premium',
            'description' => 'Assurance complète pour véhicules automobiles',
            'coverage_details' => 'Responsabilité civile, dommages, vol, assistance',
            'status' => 'active'
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('insurance_types.update', $type), $updatedData);

        $response->assertRedirect(route('insurance_types.index'));
        $this->assertDatabaseHas('insurance_types', $updatedData);
    }

    /** @test */
    public function agent_cannot_update_insurance_type()
    {
        $type = InsuranceType::factory()->create();
        $updatedData = [
            'name' => 'Assurance Auto Premium',
            'description' => 'Assurance complète pour véhicules automobiles',
            'coverage_details' => 'Responsabilité civile, dommages, vol, assistance',
            'status' => 'active'
        ];

        $response = $this->actingAs($this->agent)
            ->put(route('insurance_types.update', $type), $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('insurance_types', $updatedData);
    }

    /** @test */
    public function admin_can_delete_insurance_type()
    {
        $type = InsuranceType::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('insurance_types.destroy', $type));

        $response->assertRedirect(route('insurance_types.index'));
        $this->assertDatabaseMissing('insurance_types', ['id' => $type->id]);
    }

    /** @test */
    public function agent_cannot_delete_insurance_type()
    {
        $type = InsuranceType::factory()->create();

        $response = $this->actingAs($this->agent)
            ->delete(route('insurance_types.destroy', $type));

        $response->assertStatus(403);
        $this->assertDatabaseHas('insurance_types', ['id' => $type->id]);
    }
} 