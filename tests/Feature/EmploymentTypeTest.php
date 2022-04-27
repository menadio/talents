<?php

namespace Tests\Feature;

use App\Models\EmploymentType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmploymentTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_employment_types()
    {
        EmploymentType::factory()->create();

        $response = $this->get('/api/employment-types');

        $this->assertCount(1, EmploymentType::all());
        $response->assertOk();
    }
}
