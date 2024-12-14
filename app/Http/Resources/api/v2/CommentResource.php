<?php

namespace App\Http\Resources\api\v2;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Comment */
class CommentResource extends JsonResource {

    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'content' => $this->content,
            'product' => $this->product,
        ];
    }
}
