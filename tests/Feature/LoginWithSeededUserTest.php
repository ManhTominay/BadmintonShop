<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Middleware\UpdateUserLastActivity;
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

    public function test_admin_can_log_out(): void
    {
        $this->withoutMiddleware(UpdateUserLastActivity::class);

        $this->actingAs(new User(['vai_tro' => 'admin']))
            ->post(route('admin.logout'))
            ->assertRedirect('/login');

        $this->assertGuest();
    }
}
