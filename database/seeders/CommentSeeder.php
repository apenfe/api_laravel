<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder {

    public function run(): void {

        $products = Product::all();

        $products->each(function (Product $product) {
            $product->comments()->createMany([
                ['content' => 'This is the first comment'],
                ['content' => 'This is the second comment'],
                ['content' => 'This is the third comment'],
            ]);
        });

    }
}
