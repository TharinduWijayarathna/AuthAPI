<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_profile_success()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = ['name' => 'Updated Name', 'email' => 'updated@example.com'];

        $response = $this->putJson('/api/v1/profile', $payload);

        $response->assertStatus(200)
            ->assertJson(['user' => ['name' => 'Updated Name', 'email' => 'updated@example.com']]);
        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    public function test_delete_account_success()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson('/api/v1/profile');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Account deleted successfully.']);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
