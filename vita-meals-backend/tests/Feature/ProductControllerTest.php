<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // Make a GET request to the /products endpoint
        $response = $this->get('/api/products');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the expected JSON structure
        $response->assertJsonStructure([
            'products',
        ]);
    }

    public function testShow()
    {
        $productId = 1; // Replace with a valid product ID
        // Make a GET request to the /products/{product_id} endpoint
        $response = $this->get("/api/products/{$productId}");

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the expected JSON structure
        $response->assertJsonStructure([
            'product',
        ]);
    }

    public function testSearch()
    {
        $keyword = 'sample_keyword'; // Replace with a valid search keyword
        // Make a POST request to the /products/search endpoint
        $response = $this->post('/api/products', ['keyword' => $keyword]);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the expected JSON structure
        $response->assertJsonStructure([
            'products',
        ]);
    }
}
