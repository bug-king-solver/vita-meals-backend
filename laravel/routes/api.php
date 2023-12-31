<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('signin', 'signin');
    Route::post('signup', 'signup');
});

Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'index');
    Route::get('/{product_id}', 'show');
    Route::post('/', 'search');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::post('signout', 'signout');
        Route::post('refresh', 'refresh');
    });

    Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::get('/{userId}', 'index');
        Route::post('/store', 'store');
        Route::post('/update', 'updateQty');
        Route::post('/removeitem', 'destroyACartItem');
        Route::post('/checkout', 'checkout');
        Route::post('/remove', 'destroy');
    });
});