<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTypeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function can_get_account_type()
    {
        $response = $this->json('GET', '/api/account-types');

        $response->assertStatus(200);
    }
}
