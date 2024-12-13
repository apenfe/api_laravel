<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\v2\ProductResource;
use App\Models\Product;


class ProductController extends Controller
{
    // filtrar productos por categorioa
    // ampliar atributos de productos y categorias
    // permisos con los tokens can-...
    // precios especiales de descuento a categorias por navidad
    // subir y descragar imagenes
    // uno o varios comentarios a productos
    // etiquetas de productos n a n

    public function index()
    {
        $products = Product::with('category')->paginate(9);
        return ProductResource::collection($products);
    }

}
