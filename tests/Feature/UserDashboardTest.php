<?php

namespace Tests\Feature;

use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\Profile;
use App\Models\Skill;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_get_user_dashboard_data()
    {
        Sanctum::actingAs(
            User::factory()
                ->has(Profile::factory())
                ->has(Experience::factory()->count(3))
                ->has(Skill::factory(3))
                ->has(Portfolio::factory(3))    
                ->create()
        );
        
        
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
    }
}
