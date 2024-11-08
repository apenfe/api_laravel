<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('lists/categories', [CategoryController::class, 'list']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('categories', CategoryController::class);

    Route::get('products', [ProductController::class, 'index']);
});


