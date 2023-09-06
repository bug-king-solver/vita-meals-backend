<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testAllProducts()
    {
        // Create some dummy products (you can customize this as needed)
        Product::factory()->count(3)->create();

        // Instantiate the ProductService
        $productService = new ProductService();

        // Call the all method
        $products = $productService->all();

        // Assert that the returned value is a collection of products
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $products);

        // You can add more specific assertions based on your data and requirements
    }

    public function testFindProductById()
    {
        // Create a dummy product (you can customize this as needed)
        $product = Product::factory()->create();

        // Instantiate the ProductService
        $productService = new ProductService();

        // Call the findById method
        $foundProduct = $productService->findById($product->id);

        // Assert that the returned product matches the created product
        $this->assertEquals($product->title, $foundProduct->title);
        $this->assertEquals($product->description, $foundProduct->description);

        // You can add more specific assertions based on your data and requirements
    }

    public function testFilterProducts()
    {
        // Create some dummy products with specific titles and descriptions
        Product::factory()->create(['title' => 'Product 1', 'description' => 'Description 1']);
        Product::factory()->create(['title' => 'Product 2', 'description' => 'Description 2']);
        Product::factory()->create(['title' => 'Another Product', 'description' => 'Another Description']);
    
        // Instantiate the ProductService
        $productService = new ProductService();
    
        // Call the filter method with a keyword
        $filteredProducts = $productService->filter('Product');
    
        // Define the expected titles of filtered products
        $expectedTitles = ['Product 1', 'Product 2', 'Another Product'];
    
        // Assert that the count of filtered products matches the expected count
        $this->assertCount(count($expectedTitles), $filteredProducts);
    
        // Loop through the filtered products and assert that their titles are in the expected titles array
        foreach ($filteredProducts as $product) {
            $this->assertContains($product->title, $expectedTitles);
        }
    }
    
}
