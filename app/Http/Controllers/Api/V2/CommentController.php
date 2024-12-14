<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\api\v2\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller {

    public function index(Product $product) {
        $comments = $product->comments()->get();
        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request, Product $product) {

        $data = $request->validated();
        $data['product_id'] = $product->id;

        $comment = Comment::create($data);

        return new CommentResource($comment);
    }

    public function show(Product $product, Comment $comment) {

        if ($comment->product_id !== $product->id) {
            return response()->json(['message' => 'Comment not found for this product'], 404);
        }

        return new CommentResource($comment);
    }

    public function destroy(Product $product, Comment $comment) {

        if ($comment->product_id !== $product->id) {
            return response()->json(['message' => 'Comment not found for this product'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted'], 200);
    }
}
