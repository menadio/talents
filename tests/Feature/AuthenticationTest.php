<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\AccountType;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function can_sign_in()
    {        
        // create an  account  type
        $accountType = AccountType::create(['type' => 'individual']);

        // register new user
        $response = $this->post(route('register'), [
            'email' => 'hello@bookstars.co',
            'password' => 'password',
            'account_type_id' => $accountType->id
        ]);

        $response->assertCreated();

        // user sign in attempt
        $response = $this->post(route('login'), [
            'email' => 'hello@bookstars.co',
            'password' => 'password'
        ]);

        $response->assertSee('accessToken');
        $response->assertOk();
    }

    /**
     * @test
     */
    public function can_sign_out()
    {
        $accountType = AccountType::create(['type' => 'individual']);
        
        Sanctum::actingAs(
            User::create([
                'email' => 'hello@bookstars.co',
                'password' => 'password',
                'account_type_id' => $accountType->id
            ]),
        );

        $response = $this->get(route('logout'));
        $response->assertOk();
    }
}
