<?php

use Tests\TestCase;
use App\Services\CartService;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartServiceTest extends TestCase
{
    protected $user;
    protected $cartService;

    public function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();

        // Instantiate the CartService
        $this->cartService = new CartService();
    }

    public function testCreateCart()
    {
        // Call the create method and assert the cart is created
        $cart = $this->cartService->create($this->user->id);

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals($this->user->id, $cart->user_id);
        $this->assertEquals(1, $cart->is_active);
    }

    public function testUpdateCart()
    {
        // Create a test cart
        $cart = Cart::factory()->create();
    
        // Call the update method and assert the cart is updated
        $updated = $this->cartService->update($cart->id);
    
        // Assertions
        $this->assertEquals(1, $updated);
        $this->assertEquals(0, $cart->fresh()->is_active);
    }
    // Add more test methods for other CartService functions (all, fetchActive, destroyACartWithItems, destroyAllCartsOfAUser)

    public function tearDown(): void
    {
        // Clean up the test database (e.g., delete test users, carts, and related data)
        DB::rollBack(); // Rollback any transactions if used
        parent::tearDown();
    }
}
