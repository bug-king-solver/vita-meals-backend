<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Cart;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cart = Cart::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();
        return [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => rand(1, 10),
        ];
    }
}
