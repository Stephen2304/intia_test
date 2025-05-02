<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BranchControllerTest extends TestCase
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
    public function admin_can_view_branches_index()
    {
        $response = $this->actingAs($this->admin)->get(route('branches.index'));
        $response->assertStatus(200);
        $response->assertViewIs('branches.index');
    }

    /** @test */
    public function agent_cannot_view_branches_index()
    {
        $response = $this->actingAs($this->agent)->get(route('branches.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_create_branch()
    {
        $branchData = [
            'name' => 'Nouvelle Branche',
            'location' => 'Paris',
            'contact_info' => '01 23 45 67 89'
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('branches.store'), $branchData);

        $response->assertRedirect(route('branches.index'));
        $this->assertDatabaseHas('branches', $branchData);
    }

    /** @test */
    public function agent_cannot_create_branch()
    {
        $branchData = [
            'name' => 'Nouvelle Branche',
            'location' => 'Paris',
            'contact_info' => '01 23 45 67 89'
        ];

        $response = $this->actingAs($this->agent)
            ->post(route('branches.store'), $branchData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('branches', $branchData);
    }

    /** @test */
    public function admin_can_update_branch()
    {
        $branch = Branch::factory()->create();
        $updatedData = [
            'name' => 'Branche Modifiée',
            'location' => 'Lyon',
            'contact_info' => '04 56 78 90 12'
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('branches.update', $branch), $updatedData);

        $response->assertRedirect(route('branches.index'));
        $this->assertDatabaseHas('branches', $updatedData);
    }

    /** @test */
    public function agent_cannot_update_branch()
    {
        $branch = Branch::factory()->create();
        $updatedData = [
            'name' => 'Branche Modifiée',
            'location' => 'Lyon',
            'contact_info' => '04 56 78 90 12'
        ];

        $response = $this->actingAs($this->agent)
            ->put(route('branches.update', $branch), $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('branches', $updatedData);
    }

    /** @test */
    public function admin_can_delete_branch()
    {
        $branch = Branch::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('branches.destroy', $branch));

        $response->assertRedirect(route('branches.index'));
        $this->assertDatabaseMissing('branches', ['id' => $branch->id]);
    }

    /** @test */
    public function agent_cannot_delete_branch()
    {
        $branch = Branch::factory()->create();

        $response = $this->actingAs($this->agent)
            ->delete(route('branches.destroy', $branch));

        $response->assertStatus(403);
        $this->assertDatabaseHas('branches', ['id' => $branch->id]);
    }
} 