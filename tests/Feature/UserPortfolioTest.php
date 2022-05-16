<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Portfolio;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPortfolioTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function can_add_a_portfolio()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );
        
        $user = auth()->user();

        $response = $this->post(route('portfolios.store'), [
            'title'     => $this->faker()->sentence(3),
            'details'   => $this->faker()->text(),
            'link'      => $this->faker()->url()
        ]);

        $portfolio = Portfolio::first();
        
        $response->assertCreated();
        $this->assertEquals($portfolio->user_id, $user->id);
        $this->assertEquals(Portfolio::count(), 1);
    }

    /**
     * @test
     */
    public function can_fetch_portfolio()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );
        
        $portfolio = Portfolio::factory()
            ->for(auth()->user())
            ->create();

        $response = $this->get(route('portfolios.list'));

        $response->assertOk();
        $this->assertEquals(Portfolio::count(), 1);
    }
}
