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
use App\Http\Controllers\Api\v1\BankEntityController;
use App\Http\Controllers\Api\v1\StateOrderController;
use App\Http\Controllers\Api\v1\PaymentConceptController;
use App\Http\Controllers\Api\v1\AdviserController;

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
    Route::get('banks', [BankEntityController::class, 'index']);
    Route::get('advisers', [AdviserController::class, 'index']);
    
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

        // BankEntity
        Route::post('banks', [BankEntityController::class, 'store']);
        Route::get('banks/{bank}', [BankEntityController::class, 'show']);
        Route::put('banks/{bank}', [BankEntityController::class, 'update']);
        Route::delete('banks/{bank}', [BankEntityController::class, 'destroy']);

        // StateOrder
        Route::get('state-orders', [StateOrderController::class, 'index']);
        Route::post('state-orders', [StateOrderController::class, 'store']);
        Route::get('state-orders/{state_order}', [StateOrderController::class, 'show']);
        Route::put('state-orders/{state_order}', [StateOrderController::class, 'update']);
        Route::delete('state-orders/{state_order}', [StateOrderController::class, 'destroy']);

        // PaymentConcept
        Route::apiResource('payment-concepts', 'Api\v1\PaymentConceptController');
        // Route::get('payment-concepts', [PaymentConceptController::class, 'index']);
        // Route::post('payment-concepts', [PaymentConceptController::class, 'store']);
        // Route::get('payment-concepts/{payment_concept}', [PaymentConceptController::class, 'show']);
        // Route::put('payment-concepts/{payment_concept}', [PaymentConceptController::class, 'update']);
        // Route::delete('payment-concepts/{payment_concept}', [PaymentConceptController::class, 'destroy']);
        
        // Product and Product Range massive
        Route::post('products-massive', [ProductController::class, 'createMassive']);
        Route::post('product-ranges-massive', [ProductRangeController::class, 'createMassive']);

        // Advisers 
        // Route::apiResource('advisers', 'Api\v1\AdviserController');
        Route::post('advisers', [AdviserController::class, 'store']);
        Route::get('advisers/{adviser}', [AdviserController::class, 'show']);
        Route::put('advisers/{adviser}', [AdviserController::class, 'update']);
        Route::delete('advisers/{adviser}', [AdviserController::class, 'destroy']);

        // List
        Route::get('list-catalogues', [CatalogueController::class, 'list']);
        Route::get('list-categories', [CategoryController::class, 'list']);

        
        Route::post('catalogues/{catalogue}/arrivals', [ArrivalController::class, 'store']);
        // Route::post('catalogues/{catalogue}/arrivals/multiple', [ArrivalController::class, 'create']);
        // Route::put('arrivals/{arrival}', [ArrivalController::class, 'update']);
        Route::delete('arrivals', [ArrivalController::class, 'destroy']);
        // Route::put('ranges/{range}', [RangeController::class, 'update']);
        // Route::delete('ranges/{range}', [RangeController::class, 'destroy']);

        // Ranges
        Route::post('product-ranges/{product_range}/ranges', [RangeController::class, 'store']);
        Route::delete('ranges', [RangeController::class, 'destroy']);
        
        // Orders
        Route::get('orders', [OrderController::class, 'index']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::put('orders/{order}', [OrderController::class, 'update']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::delete('orders/{order}', [OrderController::class, 'destroy']);


        // Payments
        Route::post('orders/{order}/payments', [PaymentController::class, 'store']);
        Route::delete('payments', [PaymentController::class, 'destroy']);
        
        // Order Details
        Route::post('orders/{order}/order-details', [OrderDetailController::class, 'store']);
        Route::delete('order-details', [OrderDetailController::class, 'destroy']);
        
        // Image
        Route::post('uploads', [ImageController::class, 'store']);
    });
});
