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

Route::apiResource('/users', UserController::class);
// Route::apiResource('/user_types', UserTypeController::class);
Route::apiResource('/products', ProductController::class);

Route::put('/users/{user}/salesperson', [UserController::class, 'makingSalesperson']);
Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword']);

Route::put('/products/{product}/change-image', [ProductController::class, 'updateProductImage']);
