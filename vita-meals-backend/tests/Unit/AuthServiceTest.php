<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching an authenticated user.
     *
     * @return void
     */
    public function testFetchAuthenticatedUser()
    {
        // Create a user (you can customize this as needed)
        $user = User::factory()->create();

        // Authenticate the user
        Auth::login($user);

        // Create an instance of the AuthService
        $authService = new AuthService();

        // Call the fetchAuthenticatedUser method
        $authenticatedUser = $authService->fetchAuthenticatedUser();

        // Assert that the returned user is the same as the authenticated user
        $this->assertEquals($user->id, $authenticatedUser->id);
    }

    /**
     * Test fetching an authentication token.
     *
     * @return void
     */
    public function testFetchAuthToken()
    {
        // Create a user (you can customize this as needed)
        $user = User::factory()->create();

        // Authenticate the user
        Auth::login($user);

        // Create an instance of the AuthService
        $authService = new AuthService();

        // Call the fetchAuthToken method
        $token = $authService->fetchAuthToken();

        // Assert that a token was generated
        $this->assertNotNull($token);
    }
    
    /**
     * Test fetching the token expiration time.
     *
     * @return void
     */
    public function testFetchTokenExpirationTime()
    {
        // Create an instance of the AuthService
        $authService = new AuthService();

        // Call the fetchTokenExpirationTime method
        $expirationTime = $authService->fetchTokenExpirationTime();

        // Assert that the expiration time is a Carbon instance
        $this->assertInstanceOf(\Carbon\Carbon::class, $expirationTime);
    }

    /**
     * Test logging out a user.
     *
     * @return void
     */
    public function testLogout()
    {
        // Create a user (you can customize this as needed)
        $user = User::factory()->create();

        // Authenticate the user
        Auth::login($user);

        // Create an instance of the AuthService
        $authService = new AuthService();

        // Call the logout method
        $authService->logout();

        // Assert that the user's tokens were revoked
        $this->assertCount(0, PersonalAccessToken::all());
    }
}
