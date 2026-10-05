<?php

namespace Tests\Feature;

use App\Http\Middleware\UpdateUserLastActivity;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardRevenueChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_each_day_of_the_current_month(): void
    {
        $this->withoutMiddleware(UpdateUserLastActivity::class);

        $response = $this->actingAs(new User(['vai_tro' => 'admin']))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Doanh thu từng ngày trong tháng');

        foreach (CarbonPeriod::create(now()->startOfMonth(), now()->endOfMonth()) as $date) {
            $response->assertSee($date->format('d/m/Y') . ':');
        }
    }
}