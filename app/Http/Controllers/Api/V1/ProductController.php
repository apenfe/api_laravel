<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;


class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')->paginate(9);
        return ProductResource::collection($products);
    }

}
