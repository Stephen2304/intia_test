<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $agent;
    protected $branch;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer les rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'agent']);
        
        // Créer une branche
        $this->branch = Branch::factory()->create();

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
    public function admin_can_view_clients_index()
    {
        $response = $this->actingAs($this->admin)->get(route('clients.index'));
        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
    }

    /** @test */
    public function agent_can_view_clients_index()
    {
        $response = $this->actingAs($this->agent)->get(route('clients.index'));
        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
    }

    /** @test */
    public function admin_can_create_client()
    {
        $clientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0123456789',
            'address' => '123 Rue Example',
            'branch_id' => $this->branch->id,
            'code' => strtoupper(uniqid()),
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('clients.store'), $clientData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', $clientData);
    }

    /** @test */
    public function agent_can_create_client_for_their_branch()
    {
        $clientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0123456789',
            'address' => '123 Rue Example',
            'branch_id' => $this->branch->id,
            'code' => strtoupper(uniqid()),
        ];

        $response = $this->actingAs($this->agent)
            ->post(route('clients.store'), $clientData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', $clientData);
    }

    /** @test */
    public function agent_cannot_create_client_for_other_branch()
    {
        $otherBranch = Branch::factory()->create();
        $clientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0123456789',
            'address' => '123 Rue Example',
            'branch_id' => $otherBranch->id,
            'code' => strtoupper(uniqid()),
        ];

        $response = $this->actingAs($this->agent)
            ->post(route('clients.store'), $clientData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('clients', $clientData);
    }

    /** @test */
    public function admin_can_update_client()
    {
        $client = Client::factory()->create(['branch_id' => $this->branch->id]);
        $updatedData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'address' => '456 Rue Example',
            'branch_id' => $this->branch->id,
            'code' => strtoupper(uniqid()),
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('clients.update', $client), $updatedData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', $updatedData);
    }

    /** @test */
    public function agent_can_update_client_from_their_branch()
    {
        $client = Client::factory()->create(['branch_id' => $this->branch->id]);
        $updatedData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'address' => '456 Rue Example',
            'branch_id' => $this->branch->id,
            'code' => strtoupper(uniqid()),
        ];

        $response = $this->actingAs($this->agent)
            ->put(route('clients.update', $client), $updatedData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', $updatedData);
    }

    /** @test */
    public function agent_cannot_update_client_from_other_branch()
    {
        $otherBranch = Branch::factory()->create();
        $client = Client::factory()->create(['branch_id' => $otherBranch->id]);
        $updatedData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'address' => '456 Rue Example',
            'branch_id' => $otherBranch->id,
            'code' => strtoupper(uniqid()),
        ];

        $response = $this->actingAs($this->agent)
            ->put(route('clients.update', $client), $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('clients', $updatedData);
    }

    /** @test */
    public function admin_can_delete_client()
    {
        $client = Client::factory()->create(['branch_id' => $this->branch->id]);

        $response = $this->actingAs($this->admin)
            ->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    /** @test */
    public function agent_can_delete_client_from_their_branch()
    {
        $client = Client::factory()->create(['branch_id' => $this->branch->id]);

        $response = $this->actingAs($this->agent)
            ->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    /** @test */
    public function agent_cannot_delete_client_from_other_branch()
    {
        $otherBranch = Branch::factory()->create();
        $client = Client::factory()->create(['branch_id' => $otherBranch->id]);

        $response = $this->actingAs($this->agent)
            ->delete(route('clients.destroy', $client));

        $response->assertStatus(403);
        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }
} 