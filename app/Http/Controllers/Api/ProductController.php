<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @group Products
 *
 * APIs for managing products
 *
 * @queryParam page int The page number. Example: 1
 */
class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')->paginate(9);
        return ProductResource::collection($products);
    }

}
