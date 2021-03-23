<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\CatalogueController;
use App\Http\Controllers\Api\v1\ArrivalController;
use App\Http\Controllers\Api\v1\ProductRangeController;
use App\Http\Controllers\Api\v1\RangeController;
use App\Http\Controllers\Api\v1\ImageController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\OrderDetailController;
use App\Http\Controllers\Api\v1\PaymentController;
use App\Http\Controllers\Api\v1\MeasureController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::get('catalogues-availables', [CatalogueController::class, 'availables']);
    
    // Las siguientes rutas además del prefijo requieren que el usuario tenga un token válido
    Route::group(['middleware' => ['cors', 'auth:api', 'json.response']], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::put('user-update', [AuthController::class, "update"]);
        Route::get('user-order', [AuthController::class, "orderByUser"]);

        // Route::apiResource('users', UserController::class);
        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);
        
        // Route::apiResource('products', ProductController::class);
        Route::get('products', [ProductController::class, 'index']);
        Route::post('products', [ProductController::class, 'store']);
        Route::get('products/{product}', [ProductController::class, 'show']);
        Route::put('products/{product}', [ProductController::class, 'update']);
        Route::delete('products/{product}', [ProductController::class, 'destroy']);
        
        // Route::apiResource('categories', CategoryController::class);
        Route::get('categories', [CategoryController::class, 'index']);
        Route::post('categories', [CategoryController::class, 'store']);
        Route::get('categories/{category}', [CategoryController::class, 'show']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

        // Route::apiResource('catalogues', CatalogueController::class);
        Route::get('catalogues', [CatalogueController::class, 'index']);
        Route::post('catalogues', [CatalogueController::class, 'store']);
        Route::get('catalogues/{catalogue}', [CatalogueController::class, 'show']);
        Route::put('catalogues/{catalogue}', [CatalogueController::class, 'update']);
        Route::delete('catalogues/{catalogue}', [CatalogueController::class, 'destroy']);
        
        // Route::apiResource('product-ranges', ProductRangeController::class);
        Route::get('product-ranges', [ProductRangeController::class, 'index']);
        Route::post('product-ranges', [ProductRangeController::class, 'store']);
        Route::get('product-ranges/{product_range}', [ProductRangeController::class, 'show']);
        Route::put('product-ranges/{product_range}', [ProductRangeController::class, 'update']);
        Route::delete('product-ranges/{product_range}', [ProductRangeController::class, 'destroy']);

        // Measure
        Route::get('measures', [MeasureController::class, 'index']);
        Route::post('measures', [MeasureController::class, 'store']);
        Route::get('measures/{measure}', [MeasureController::class, 'show']);
        Route::put('measures/{measure}', [MeasureController::class, 'update']);
        Route::delete('measures/{measure}', [MeasureController::class, 'destroy']);

        Route::post('products-massive', [ProductController::class, 'createMassive']);
        Route::post('product-ranges-massive', [ProductRangeController::class, 'createMassive']);
        
        Route::get('list-catalogues', [CatalogueController::class, 'list']);
        Route::get('list-categories', [CategoryController::class, 'list']);
        Route::post('catalogues/{catalogue}/arrivals', [ArrivalController::class, 'store']);
        // Route::post('catalogues/{catalogue}/arrivals/multiple', [ArrivalController::class, 'create']);
        // Route::put('arrivals/{arrival}', [ArrivalController::class, 'update']);
        Route::delete('arrivals', [ArrivalController::class, 'destroy']);
        Route::post('product-ranges/{product_range}/ranges', [RangeController::class, 'store']);
        // Route::put('ranges/{range}', [RangeController::class, 'update']);
        // Route::delete('ranges/{range}', [RangeController::class, 'destroy']);
        Route::delete('ranges', [RangeController::class, 'destroy']);
        // Route::delete('catalogues/{catalogue}/arrivals/{arrival}', [ArrivalController::class, 'destroy']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::put('orders/{order}', [OrderController::class, 'update']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::post('orders/{order}/order-details', [OrderDetailController::class, 'store']);
        Route::post('orders/{order}/payments', [PaymentController::class, 'store']);
        Route::delete('order-details', [OrderDetailController::class, 'destroy']);
        Route::post('uploads', [ImageController::class, 'store']);
    });
});
