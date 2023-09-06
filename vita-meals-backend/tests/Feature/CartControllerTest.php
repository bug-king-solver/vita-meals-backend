<?php


namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user and generate a token for testing
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function testCanAddProductToCart()
    {
        // Create a product for testing
        $product = Product::factory()->create();

        // Make an authenticated request to add the product to the cart
        $response = $this->json('POST', '/api/cart/store', [
            'user_id' => auth()->user()->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'error' => false,
            'message' => 'The product is added to the cart successfully!',
        ]);

        // Add more assertions to check the database state if needed
    }

    public function testCanUpdateCartItemQuantity()
    {
        // Create a cart, product, and cart item for testing
        $cart = Cart::factory()->create(['user_id' => auth()->user()->id]);
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        // Make an authenticated request to update the cart item quantity
        $response = $this->json('POST', '/api/cart/update', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'error' => false,
            'message' => 'Quantity updated successfully',
        ]);

        // Add more assertions to check the database state if needed
    }


    public function testCanCheckoutCart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create(['cart_id' => $cart->id]);

        $response = $this->actingAs($user)->json('POST', '/api/cart/checkout', [
            'cart_id' => $cart->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'error' => false,
            'message' => 'Checkout completed successfully',
        ]);

        // Add more assertions to check if the email was sent or other relevant data
    }

    public function testCanRemoveCartItem()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create(['cart_id' => $cart->id]);

        $response = $this->actingAs($user)->json('post', '/api/cart/removeitem', [
            'cart_id' => $cart->id,
            'product_id' => $cartItem->product_id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'error' => false,
            'message' => 'Product is removed successfully',
        ]);
    }

    public function testCanClearCart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create(['cart_id' => $cart->id]);

        $response = $this->actingAs($user)->json('post', '/api/cart/remove', [
            'cart_id' => $cart->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'error' => false,
            'message' => 'Cart items are cleared successfuly'
        ]);
    }
}
