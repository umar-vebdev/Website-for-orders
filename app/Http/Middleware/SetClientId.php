<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class SetClientId
{
    public function handle(Request $request, Closure $next)
{
    if (! $request->cookie('client_id')) {
        Cookie::queue('client_id', Str::uuid(), 60 * 24 * 365); // 1 год
    }

    $response = $next($request);

    return $response; 
}

}
