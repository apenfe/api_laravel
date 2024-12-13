<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\api\v2\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    // *** filtrar productos por categorioa
    // ***ampliar atributos de productos y categorias
    // ***permisos con los tokens can-...
    // precios especiales de descuento a categorias por navidad
    // ***solucionar recursos para v1 y v2, tambien ver como sacar un json de categoria dentro de producto
    // subir y descragar imagenes ***
    // uno o varios comentarios a productos
    // etiquetas de productos n a n

    public function index()
    {
        if(!auth()->user()->tokenCan('v2')){
            return response()->json(['message' => 'Not authorized to v2'], 403);
        }

        $products = Product::with('category')->paginate(9);
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        return new ProductResource($product);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    // filtrar productos por categorias
    public function category($category)
    {
        $products = Product::where('category_id', $category)->get();
        return ProductResource::collection($products);
    }

}
