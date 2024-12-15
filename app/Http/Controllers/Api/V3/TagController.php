<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\api\v2\CommentResource;
use App\Http\Resources\api\v2\TagResource;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller {

    public function index(Product $product) {
        $tags = $product->tags()->withPivot('added_by')->get();
        return TagResource::collection($tags);
    }

    public function store(TagRequest $request, Product $product) {

            $data = $request->validated();
            // ver si tiene campo added_by
            if ($request->has('added_by')) {
                $data['added_by'] = $request->added_by;
            }
            $tag = $product->tags()->create($data);

            // agregar el added_by al pivot
            $product->tags()->updateExistingPivot($tag->id, ['added_by' => $data['added_by']]);

            return new TagResource($tag);

    }

    public function show(Product $product, Tag $tag)
    {
        // Primero, obtener la relación específica con el pivote
        $productTag = $product->tags()
            ->withPivot('added_by')
            ->where('tag_id', $tag->id)
            ->first();

        if (!$productTag) {
            return response()->json(['message' => 'Tag not found for this product'], 404);
        }

        // Crear un nuevo TagResource con la información del pivot
        return new TagResource($productTag); // Note que pasamos $productTag en lugar de $tag
    }

    public function destroy(Product $product, Tag $tag) {

        if (!$product->tags->contains($tag)) {
            return response()->json(['message' => 'Tag not found for this product'], 404);
        }

        $product->tags()->detach($tag);

        return response()->json(['message' => 'Tag deleted'], 200);
    }
}
