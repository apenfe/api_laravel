<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CategoryTest extends TestCase
{
   use RefreshDatabase;

    public function test_api_returns_categories_list(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('categories.index'));

        $response->assertStatus(200)
            ->assertJsonCount(1,'data')
            ->assertJson([
                'data' => [Arr::only($category->toArray(), ['id', 'name'])]
            ]);
    }

    // genera los test
    public function test_api_category_store_successful(){

        $user = User::factory()->create();
        $category = [
            'id' => 1,
            'name' => 'category 1',
            'description' => 'description 1'
        ];

        $response = $this->actingAs($user)
            ->postJson(route('categories.store'), $category);

        $response->assertStatus(201)
            ->assertJson([
                'data' => Arr::only($category, ['id', 'name'])
            ]);

    }

}
