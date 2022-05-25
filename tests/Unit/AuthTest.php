<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test: register new user
     *
     * @return void
     */
    public function test_register()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/register', [
            'name' => 'John',
            'surname' => 'Bibi',
            'phone' => '432432432',
            'email' => 'BibiJ@test.com',
            'password' => 'testpass123',
            'password_confirmation' => 'testpass123'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test: login user
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create();
        
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/login', [
            'email' => 'test@test.com',
            'password' => 'testABC'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test: logout user
     *
     * @return void
     */
    public function test_logout()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/logout');

        $response->assertStatus(200);
    }
}
