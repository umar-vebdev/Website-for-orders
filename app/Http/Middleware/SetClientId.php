<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class SetClientId
{
    public function handle($request, Closure $next)
    {
        if (! $request->cookie('client_id')) {
            Cookie::queue('client_id', Str::uuid(), 60 * 24 * 365); // 1 год
        }

        return $next($request);
    }
}
