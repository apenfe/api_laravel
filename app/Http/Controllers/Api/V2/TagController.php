<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\v2\TagResource;
use App\Models\Product;
use Illuminate\Http\Request;

class TagController extends Controller {

    public function index(Product $product) {

        $tags = $product->tags;

        return new TagResource($tags);

    }

    public function store(Request $request) {
    }

    public function show($id) {
    }

    public function update(Request $request, $id) {
    }

    public function destroy($id) {
    }
}
