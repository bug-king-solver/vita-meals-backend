<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can be created.
     *
     * @return void
     */
    public function testUserCanBeCreated()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ];

        $user = User::factory()->create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['name'], $user->name);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertTrue(password_verify('password123', $user->password));
    }

    /**
     * Test that a user can have many carts.
     *
     * @return void
     */
    public function testUserCanHaveManyCarts()
    {
        $user = User::factory()->create();
        $cart1 = $user->carts()->create(['is_active' => true]);
        $cart2 = $user->carts()->create(['is_active' => false]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->carts);
        $this->assertTrue($user->carts->contains($cart1));
        $this->assertTrue($user->carts->contains($cart2));
    }
}
