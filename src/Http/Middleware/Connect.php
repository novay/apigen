<?php

namespace Novay\Apigen\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class Connect
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('api_data')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
