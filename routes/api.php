<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Http\Request;
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
    Route::apiResource('/', UserController::class);

    Route::put('/{user}/salesperson', [UserController::class, 'makingSalesperson']);
    Route::put('/{user}/reset-password', [UserController::class, 'resetPassword']);
});

Route::prefix('products')->group(function () {
    Route::apiResource('/', ProductController::class);
    Route::put('/{product}/change-image', [ProductController::class, 'updateProductImage']);
});
