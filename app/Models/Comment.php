<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = ['content', 'product_id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
