<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_access_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/admin');

        $response->assertStatus(200)
                 ->assertJsonStructure(['stats', 'latestData']);
    }

    public function test_unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->getJson('/api/admin');

        $response->assertStatus(401);
    }
}
