<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase; // This resets the database before and after each test
    use WithFaker;

    public function testUserCanSignInWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/api/signin', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'error',
                'user',
                'authorisation' => [
                    'token',
                    'type',
                    'expires_in',
                ],
            ]);
    }

    public function testUserCannotSignInWithInvalidCredentials()
    {
        $response = $this->post('/api/signin', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => true,
                'message' => 'Unauthorized',
            ]);
    }

    public function testUserCanSignUpWithValidData()
    {
        $response = $this->post('/api/signup', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'securepassword',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'error' => false,
                'message' => 'User created successfully',
            ]);
    }

    public function testUserCanSignOut()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/api/signout');

        $response->assertStatus(200)
            ->assertJson([
                'error' => false,
                'message' => 'Successfully logged out',
            ]);
    }

    public function testUserCanRefreshToken()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/api/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'error',
                'user',
                'authorisation' => [
                    'token',
                    'type',
                    'expires_in',
                ],
            ]);
    }
}
