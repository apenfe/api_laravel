<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {

    public function run(): void {
        // CRear 10 categorias
        Category::factory(10)->create();
    }
}
