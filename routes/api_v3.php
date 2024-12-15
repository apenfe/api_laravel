<?php

use App\Http\Controllers\Api\V3\AuthController;
use App\Http\Controllers\Api\V3\CategoryController;
use App\Http\Controllers\Api\V3\CommentController;
use App\Http\Controllers\Api\V3\ProductController;
use App\Http\Controllers\Api\V3\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function(){

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class)->middleware('throttle:products');
    Route::get('products-filter/{id}', [ProductController::class, 'category']);
    Route::apiResource('products.comments', CommentController::class)->shallow();
    Route::get('products/{product}/comments/{comment}', [CommentController::class, 'show']);
    Route::delete('products/{product}/comments/{comment}', [CommentController::class, 'destroy']);
    Route::apiResource('products.tags', TagController::class)->shallow();
    Route::get('products/{product}/tags/{tag}', [TagController::class, 'show']);
    Route::delete('products/{product}/tags/{tag}', [TagController::class, 'destroy']);

    Route::get('lists/categories', [CategoryController::class, 'list']);
});
