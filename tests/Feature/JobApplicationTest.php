<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use App\Models\Position;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function can_apply_for_job_position()
    {
        $status = Status::create(['name' => 'pending review']);

        Sanctum::actingAs(
            User::factory()->create(),
        );

        $position = Position::factory()
            ->for(auth()->user())
            ->create();

        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->post(route('positions.apply', $position));

        $response->assertStatus(201);
    }
}
