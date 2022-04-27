<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Experience;
use App\Models\AccountType;
use App\Models\EmploymentType;
use App\Models\Industry;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExperienceTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function can_store_experience()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $employmentType = EmploymentType::factory()->create();
        $industry = Industry::factory()->create();
        
        $response = $this->post(route('experience.store'), [
            'user_id'           => auth()->user()->id,
            'title'             => $this->faker->text(),
            'employment_type'   => $employmentType->id,
            'industry_type'     => $industry->id,
            'start_date'        => $this->faker->date(),
            'end_date'          => $this->faker->date(),
            'location'          => $this->faker->city(),
            'description'       => $this->faker->paragraph()
        ]);

        $response->assertStatus(201);
        $this->assertCount(1, Experience::all());
    }

    /**
     * @test
     */
    public function can_get_user_experiences()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $user = auth()->user();

        $experiences = Experience::factory()
            ->count(3)
            ->for($user)
            ->create();

        $response = $this->get(route('experience.index'));

        $response->assertOk();
        $this->assertCount(3, $experiences);
    }

    /**
     * @test
     */
    public function can_update_an_experience()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $experience = Experience::factory()
            ->for(auth()->user())
            ->create();

        $response = $this->put(route('experience.update', $experience), [
            'title' => $this->faker->word()
        ]);

        $response->assertSuccessful();
        $response->assertOk();
    }

    /**
     * @test
     */
    public function can_delete_an_experience()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $experience = Experience::factory()
            ->for(auth()->user())
            ->create();

        $response = $this->delete(route('experience.destroy', $experience));

        $this->assertModelMissing($experience);
        $response->assertOk();
    }
}
