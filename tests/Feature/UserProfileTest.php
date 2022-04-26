<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\AccountType;
use App\Models\Profile;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_retrieve_user_profile()
    {        
        $accountType = AccountType::create(['type' => 'individual']);
        
        Sanctum::actingAs(
            User::create([
                'email' => 'hello@bookstars.co',
                'password' => 'password',
                'account_type_id' => $accountType->id
            ]),
        );

        $user = auth()->user();

        Profile::create(['user_id' => $user->id]);

        $response = $this->get('/api/user/profile');

        $response->assertOk();
        $response->assertSee('first_name');
    }

    /**
     * @test
     */
    public function can_update_user_profile()
    {
        $accountType = AccountType::create(['type' => 'individual']);

        Sanctum::actingAs(
            User::create([
                'email' => 'hello@bookstars.co',
                'password' => 'password',
                'account_type_id' => $accountType->id
            ]),
        );

        Profile::create(['user_id' => auth()->user()->id]);

        $response = $this->put('/api/user/profile', [
            'first_name'    => 'john',
            'last_name'     => 'doe'
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('profiles', ['user_id' => auth()->user()->id, 'first_name' => 'john', 'last_name' => 'doe']);
    }
}
