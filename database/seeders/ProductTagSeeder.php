<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductTagSeeder extends Seeder {
    public function run(): void {
        // cargar todos los productos
        $products = Product::all();
        // cargar todos los tags
        $tags = Tag::all();

        // verificar que hay al menos 3 tags
        if ($tags->count() < 3) {
            throw new \InvalidArgumentException('You need at least 3 tags to run this seeder.');
        }

        // para cada producto asignarle 3 tags aleatorios
        $products->each(function ($product) use ($tags) {
            $product->tags()->attach(
                $tags->random(3)->pluck('id')->toArray()
            );
        });

        // para cada relacion producto-tag asignarle un usuario aleatorio
        $products->each(function ($product) {
            $product->tags->each(function ($tag) use ($product) {
                $product->tags()->updateExistingPivot(
                    $tag->id,
                    ['added_by' => rand(1, 10)]
                );
            });
        });
    }
}
