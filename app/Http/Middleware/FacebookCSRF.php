<?php

namespace BandManager\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacebookCSRF
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query->get('state');
        $request->headers->set('X-CSRF-TOKEN', $token);

        return $next($request);
    }
}
