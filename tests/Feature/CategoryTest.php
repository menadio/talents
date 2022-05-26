<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_categories_collection()
    {
        Category::factory()->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $this->assertCount(1, Category::all());
    }
}
