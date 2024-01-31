<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('/users', [UserController::class, 'store']);
// Route::get('/users/{user}',);
Route::prefix('users')->group(function () {
    Route::put('/{user}/salesperson', [UserController::class, 'makingSalesperson']);
    Route::put('/{user}/reset-password', [UserController::class, 'resetPassword']);
});

Route::prefix('products')->group(function () {
    Route::get('/search/{search?}', [ProductController::class, 'search']);
    Route::put('/{product}/change-image', [ProductController::class, 'updateProductImage']);
});

Route::prefix('categories')->group(function () {
    Route::get('/available', [CategoryController::class, 'available']);
});

Route::apiResource('/users', UserController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/comments', CommentController::class);
Route::apiResource('/user_types', UserTypeController::class);
Route::apiResource('/categories', CategoryController::class);


