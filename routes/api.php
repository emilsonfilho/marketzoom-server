<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
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

/** SANCTUM MIDDLEWARE */
Route::middleware('auth:sanctum')->group(function () {
    Route::put('users/{user}/salesperson', [UserController::class, 'makingSalesperson']);

    Route::prefix('shops')->group(function () {
        Route::put('/{shop}/change-image', [ShopController::class, 'changeShopImage']);
        Route::put('/{shop}/change-admin', [ShopController::class, 'updateAdmin']);
        Route::put('/{shop}/enable', [ShopController::class, 'enable']);
        Route::put('/{shop}/disable', [ShopController::class, 'disable']);
    });

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/add-item/{product}', [CartController::class, 'addItem']);
        Route::delete('/remove-item/{product}', [CartController::class, 'removeItem']);
        Route::delete('/remove-product/{product}', [CartController::class, 'removeProduct']);

        Route::prefix('checkout')->group(function () {
            Route::put('/all', [CartController::class, 'checkout']);
            Route::put('/product/{product}', [CartController::class, 'checkoutProduct']);
            Route::put('/item/{product}', [CartController::class, 'checkoutItem']);
        });
    });

    Route::apiResource('/users', UserController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::apiResource('/products', ProductController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/comments', CommentController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('/shops', ShopController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/banners', BannerController::class)->only(['store', 'destroy']);
    Route::apiResource('/product-images', ProductImageController::class)->only(['store', 'udpate', 'destroy']);
    Route::apiResource('/user_types', UserTypeController::class);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

// ---------------------------------------------------------------------------------

/** PERMITIDAS PARA TODOS OS USERS */
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'store']);
});

Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword']);
Route::get('/products/search/{search?}', [ProductController::class, 'search']);
Route::get('/categories/available', [CategoryController::class, 'available']);

Route::apiResource('/users', UserController::class)->only(['show']);
Route::apiResource('/comments', CommentController::class)->only(['show']);
Route::apiResource('/products', ProductController::class)->only(['index', 'show']);
Route::apiResource('/categories', CategoryController::class)->only(['show']);
Route::apiResource('/shops', ShopController::class)->only(['index', 'show']);
Route::apiResource('/banners', BannerController::class)->only(['index']);
Route::apiResource('/product-images', ProductImageController::class)->only(['show']);
