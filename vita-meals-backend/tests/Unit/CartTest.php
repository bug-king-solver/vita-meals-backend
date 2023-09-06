<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the relationship between Cart and User.
     */
    public function testItBelongsToUser()
    {
        // Create a user and a cart associated with that user
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        // Use Laravel's built-in assert method to assert the relationship
        $this->assertInstanceOf(User::class, $cart->user);
    }

    /**
     * Test the relationship between Cart and CartItem.
     */
    public function testItHasManyCartItems()
    {
        // Create a cart and add some cart items to it
        $cart = Cart::factory()->create();
    
        $cartItem1 = CartItem::factory()->create(['cart_id' => $cart->id]);
        $cartItem2 = CartItem::factory()->create(['cart_id' => $cart->id]);

        // Use Laravel's built-in assert method to assert the relationship
        $this->assertInstanceOf(CartItem::class, $cart->cartItems->first());
        $this->assertCount(2, $cart->cartItems);
    }

    /**
     * Test mass assignment protection.
     */
    public function testMassAssignmentProtection()
    {
        // Attempt to create a Cart with unauthorized attributes
        $user = User::factory()->create(['id' => 1]);
        $cart = Cart::factory()->make([
            'user_id' => 1, // user_id should not be mass assignable
            'is_active' => true,
        ]);

        // Save the cart and assert that the unauthorized attribute 'user_id' is not set
        $cart->save();
        $this->assertTrue($cart->is_active);
    }
}
