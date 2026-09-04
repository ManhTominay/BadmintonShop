<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginWithSeededUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_customer_can_login_with_demo_credentials(): void
    {
        $this->seed(\Database\Seeders\UserSeeder::class);

        $response = $this->from('/login')->post('/login', [
            'email' => 'tuan@gmail.com',
            'password' => '123456',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs(User::where('email', 'tuan@gmail.com')->first());
    }
}
