<?php

use App\Http\Controllers\Api\V2\AuthController;
use App\Http\Controllers\Api\V2\CategoryController;
use App\Http\Controllers\Api\V2\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::get('lists/categories', [CategoryController::class, 'list']);

Route::middleware('auth:sanctum')->group(function(){

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class)->middleware('throttle:products');
    Route::get('products-filter/{id}', [ProductController::class, 'category']);
});
