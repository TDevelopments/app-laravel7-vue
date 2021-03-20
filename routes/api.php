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

        Route::apiResource('users', UserController::class);
        Route::apiResource('products', ProductController::class);
        Route::post('products-massive', [ProductController::class, 'createMassive']);
        Route::post('product-ranges-massive', [ProductRangeController::class, 'createMassive']);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('catalogues', CatalogueController::class);
        
        Route::get('list-catalogues', [CatalogueController::class, 'list']);
        Route::get('list-categories', [CategoryController::class, 'list']);
        Route::post('catalogues/{catalogue}/arrivals', [ArrivalController::class, 'store']);
        // Route::post('catalogues/{catalogue}/arrivals/multiple', [ArrivalController::class, 'create']);
        // Route::put('arrivals/{arrival}', [ArrivalController::class, 'update']);
        Route::delete('arrivals', [ArrivalController::class, 'destroy']);
        Route::apiResource('product-ranges', ProductRangeController::class);
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
