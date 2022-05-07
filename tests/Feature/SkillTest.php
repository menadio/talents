<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Skill;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkillTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function can_get_skills()
    {
        Skill::factory()->create();

        $response = $this->get('/api/skills');

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->hasAll(['success', 'message', 'data']) 
            )
            ->assertJsonCount(1, 'data');
    }

    /**
     * @test
     */
    public function can_add_skill()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $skills = Skill::factory()->count(5)->create();

        $skillsArray = $skills->pluck('id')->toArray();

        $response = $this->post(route('skills.store'), [
            'skills' => $skillsArray
        ]);

        $response->assertCreated();
    }

    /**
     * @test
     */
    public function can_get_user_skills()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $skills = Skill::factory()->count(5)->create();

        $skillsArray = $skills->pluck('id')->toArray();

        $this->post(route('skills.store'), [
            'skills' => $skillsArray
        ]);

        $response = $this->get(route('user.skills'));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function can_delete_skill()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );
        
        $response = $this->delete(route('delete.skill', Skill::factory()->create()));

        $response->assertNoContent();
    }
}
