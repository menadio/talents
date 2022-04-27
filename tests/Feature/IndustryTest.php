<?php

namespace Tests\Feature;

use App\Models\Industry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndustryTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_industries()
    {
        Industry::factory()->create();
        
        $response = $this->get('/api/industries');

        $response->assertStatus(200);
        $this->assertCount(1, Industry::all());
    }
}
