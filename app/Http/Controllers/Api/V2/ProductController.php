<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\api\v2\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Str;

class ProductController extends Controller
{
    // *** filtrar productos por categorioa
    // ***ampliar atributos de productos y categorias
    // ***permisos con los tokens can-...
    // ***precios especiales de descuento a categorias por navidad
    // ***solucionar recursos para v1 y v2, tambien ver como sacar un json de categoria dentro de producto
    // ***subir y descragar imagenes
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
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image'); // get the file, con todos los datos y metadatos
            $name = Str::uuid() . '.' . $file->extension(); // get the name of the file
            $file->storeAs('products', $name, 'public'); // save the file in the storage
            $data['image'] = $name; // set the name of the file in the database
        }

        $product = Product::create($data);

        return new ProductResource($product);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $data = $request->all(); // Inicializar $data con los datos del request

        // Verificar si se subió una imagen guardarla y borra la anterior
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // get the file, con todos los datos y metadatos
            $name = Str::uuid() . '.' . $file->extension(); // get the name of the file
            $file->storeAs('products', $name, 'public'); // save the file in the storage
            $data['image'] = $name; // set the name of the file in the database
            // Borrar la imagen anterior
            $oldImage = $product->image;
            Storage::disk('public')->delete('products/' . $oldImage);
        }

        $product->update($data);
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Borrar la imagen del producto
        $image = $product->image;
        Storage::disk('public')->delete('products/' . $image);

        // Borrar el producto
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    // filtrar productos por categorias
    public function category($id)
    {
        $category = Category::find($id)->first();
        $products = Product::where('category_id', $id)->with('category')->get();

        // Verificar si se obtuvieron productos
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found in this category'], 404);
        }

        // Verificar si es Navidad
        $today = Carbon::now();
        if ($today->month == 12 && $category->name == 'Christmas') {
            $products = $this->applyChristmasDiscount($products);
        }

        return ProductResource::collection($products);
    }

    // Método para aplicar descuento navideño
    private function applyChristmasDiscount($products)
    {
        $discountRate = 0.10; // 10% de descuento

        if ($products instanceof Collection) {
            foreach ($products as $product) {
                $product->price = $product->price * (1 - $discountRate);
            }
        } elseif ($products instanceof Product) {
            $products->price = $products->price * (1 - $discountRate);
        }

        return $products;
    }

}
