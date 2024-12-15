<?php

namespace App\Http\Resources\api\v3;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Tag */
class TagResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'added_by' => $this->pivot ? $this->pivot->added_by : null,
        ];
    }
}
