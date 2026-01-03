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
    $response = $next($request);

if (! $request->cookie('client_id')) {
    $response->withCookie(
        cookie('client_id', (string) Str::uuid(), 60 * 24 * 365)
    );
}

return $response;
}

}
