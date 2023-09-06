<?php

namespace Tests\Unit;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartItemModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a cart item can be created.
     *
     * @return void
     */
    public function testCartItemCanBeCreated()
    {
        // Create a Cart
        $cart = Cart::factory()->create();

        // Create a Product
        $product = Product::factory()->create();

        $cartItemData = [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ];

        $cartItem = CartItem::factory()->create($cartItemData);

        $this->assertInstanceOf(CartItem::class, $cartItem);
        $this->assertEquals($cartItemData['cart_id'], $cartItem->cart_id);
        $this->assertEquals($cartItemData['product_id'], $cartItem->product_id);
        $this->assertEquals($cartItemData['quantity'], $cartItem->quantity);
    }

    /**
     * Test that a cart item belongs to a cart.
     *
     * @return void
     */
    public function testCartItemBelongsToCart()
    {
        // Create a Cart
        $cart = Cart::factory()->create();

        // Create a Product
        $product = Product::factory()->create();

        // Create a CartItem associated with the Cart and Product
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertInstanceOf(Cart::class, $cartItem->cart);
        $this->assertEquals($cart->id, $cartItem->cart->id);
    }

    /**
     * Test that a cart item belongs to a product.
     *
     * @return void
     */
    public function testCartItemBelongsToProduct()
    {
        // Create a Cart
        $cart = Cart::factory()->create();

        // Create a Product
        $product = Product::factory()->create();

        // Create a CartItem associated with the Cart and Product
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertInstanceOf(Product::class, $cartItem->product);
        $this->assertEquals($product->id, $cartItem->product->id);
    }
}
