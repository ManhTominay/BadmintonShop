<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateUserLastActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            DB::table('nguoi_dung')
                ->where('id', Auth::id())
                ->update(['last_activity' => now()]);
        }

        return $next($request);
    }
}