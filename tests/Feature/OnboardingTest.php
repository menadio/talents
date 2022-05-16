<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\AccountType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnboardingTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function can_signup_an_individual()
    {        
        $accountType = AccountType::create(['type' => 'individual']);

        $response = $this->post(route('register'), [
            'account_type_id'   => $accountType->id,
            'email'             => 'hello@bookstars.co',
            'password'          => 'password'
        ]);

        $user = User::first();
        
        $response->assertCreated();
        $this->assertCount(1, User::all());
        $this->assertEquals('Individual', $user->accountType->type);
    }

    /**
     * @test
     */
    public function can_signup_a_business()
    {
        $accountType = AccountType::create(['type' => 'business']);

        $response = $this->post(route('register'), [
            'account_type_id'   => $accountType->id,
            'email'             => 'hello@bookstars.co',
            'password'          => 'password'
        ]);

        $user = User::first();

        $response->assertCreated();
        $this->assertCount(1, User::all());
        $this->assertEquals('Business', $user->accountType->type);
    }
}
