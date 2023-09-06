<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a product can be created.
     *
     * @return void
     */
    public function testProductCanBeCreated()
    {
        $productData = [
            'title' => 'Sample Product',
            'description' => 'A sample product description.',
            'image_url' => 'sample.jpg',
            'price' => 10.99,
        ];

        $product = Product::factory()->create($productData);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($productData['title'], $product->title);
        $this->assertEquals($productData['description'], $product->description);
        $this->assertEquals($productData['image_url'], $product->image_url);
        $this->assertEquals($productData['price'], $product->price);
    }

    /**
     * Test that a product has many cart items.
     *
     * @return void
     */
    public function testProductHasManyCartItems()
    {
        // Create a Product
        $product = Product::factory()->create();
    
        // Create a Cart
        $cart = Cart::factory()->create();
    
        // Create CartItems associated with the Cart and Product
        $cartItem1 = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    
        // Create a different Cart
        $cart2 = Cart::factory()->create();
    
        // Create CartItems associated with the second Cart and Product
        $cartItem3 = CartItem::factory()->create([
            'cart_id' => $cart2->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    
        // Assertions
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $product->cartItems);
        $this->assertTrue($product->cartItems->contains($cartItem1));
        $this->assertTrue($product->cartItems->contains($cartItem3));
    }
}
