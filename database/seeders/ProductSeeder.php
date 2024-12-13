<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    public function run(): void {
        // Crear 20 productos por cada categoria
         $categories = Category::all();
         foreach ($categories as $category) {
             Product::factory(20)->create([
                 'category_id' => $category->id
             ]);
         }
    }
}
