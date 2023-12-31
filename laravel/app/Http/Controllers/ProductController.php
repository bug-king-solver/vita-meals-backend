<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function index()
    {        
        return response()->json([
            'products' => $this->service->all()
        ]);
    }

    public function show(int $product_id)
    {
        return response()->json([
            'product' => $this->service->findById($product_id)
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        return response()->json([
            'products' => $this->service->filter($keyword)
        ]);
    }
}
