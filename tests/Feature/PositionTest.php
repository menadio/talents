<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\EmploymentType;
use App\Models\Position;
use App\Models\Status;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function can_post_position()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $category = Category::factory()->create();
        $employmentType = EmploymentType::factory()->create();
        $status = Status::create(['name' => 'pending']);

        $response = $this->post(route('positions.store'), [
            'title' => $this->faker->word(),
            'category_id' => $category->id,
            'salary'    => $this->faker->randomFloat(2, 10000, 1000000),
            'employment_type_id' => $employmentType->id,
            'location' => $this->faker->state(),
            'description' => $this->faker->realTextBetween($minNbChars = 160, $maxNbChars = 250, $indexSize = 2),
        ]);

        $response->assertCreated();
        $this->assertCount(1, auth()->user()->positions);
    }

    /**
     * @test
     */
    public function can_list_positions()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $user = auth()->user();

        $positions = Position::factory()
            ->count(3)
            ->for($user)
            ->create();

        $response = $this->get(route('positions.index'));

        $response->assertOk();
        $this->assertCount(3, $positions);
    }

    /**
     * @test
     */
    public function can_show_position()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $position = Position::factory()
            ->for(auth()->user())
            ->create();

        $response = $this->get(route('positions.show', $position));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function can_delete_position()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $position = Position::factory()
            ->for(auth()->user())
            ->create();

        $response = $this->delete(route('positions.delete', $position));

        $response->assertNoContent();
        $this->assertModelMissing($position);
    }

    /**
     * @test
     */
    public function can_update_position()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $category = Category::factory()->create();
        $employmentType = EmploymentType::factory()->create();

        $position = Position::factory()
            ->for(auth()->user())
            ->create();

        $response = $this->put(route('positions.update', $position), [
            'title' => $this->faker->word(),
            'category_id' => $category->id,
            'salary'    => $this->faker->randomFloat(2, 10000, 1000000),
            'employment_type_id' => $employmentType->id,
            'location' => $this->faker->state(),
            'description' => $this->faker->realTextBetween($minNbChars = 160, $maxNbChars = 250, $indexSize = 2),
        ]);

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_fetch_all_users_job_positions()
    {
        User::factory()
            ->has(Position::factory()->count(5))
            ->count(5)->create();

        $response = $this->get(route('positions.fetch'));

        $response->assertStatus(200);
        $this->assertCount(25, Position::all());
    }
}
