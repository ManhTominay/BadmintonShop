<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\GioHang;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tự động chia sẻ số lượng giỏ hàng cho TOÀN BỘ các file Blade
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = GioHang::validCartCount(Auth::id());
            }
            $view->with('cartCount', $cartCount);
        });
    }
}