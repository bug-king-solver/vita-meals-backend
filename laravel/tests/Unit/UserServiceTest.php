<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user creation with valid data.
     *
     * @return void
     */
    public function testCreateUserWithValidData()
    {
        $userService = new UserService();

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret-password',
        ];

        $user = $userService->create($userData);

        $this->assertNotNull($user);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertTrue(Hash::check('secret-password', $user->password));
    }

    /**
     * Test user creation with missing data.
     *
     * @return void
     */
    public function testCreateUserWithMissingData()
    {
        $userService = new UserService();

        // Missing 'email' in user data
        $userData = [
            'name' => 'John Doe',
            'password' => 'secret-password',
        ];

        $this->expectException(\Exception::class);
        $user = $userService->create($userData);
    }
}
