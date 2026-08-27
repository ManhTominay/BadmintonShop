<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateUserLastActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            DB::table('nguoi_dung')
                ->where('id', auth()->id())
                ->update(['last_activity' => now()]);
        }

        return $next($request);
    }
}