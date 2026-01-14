<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SetClientId
{
    public function handle(Request $request, Closure $next)
    {
        $clientId = $request->cookie('client_id');
        $isNew = false;

        if (!$clientId) {
            $clientId = (string) Str::uuid();
            $request->cookies->set('client_id', $clientId);
            $isNew = true;
        }

        $response = $next($request);

        if ($isNew && method_exists($response, 'withCookie')) {
            $response->withCookie(
                cookie('client_id', $clientId, 60 * 24 * 365)
            );
        }

        return $response;
    }
}