<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder {

    public function run(): void {

        // Create 10 tags
        Tag::factory(20)->create();

    }
}
