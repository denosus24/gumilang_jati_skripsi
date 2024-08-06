<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        if (empty(auth()->user()) || (!empty(auth()->user()) && auth()->user()->role !== 'customer')) {
            return redirect()->route('frontpage.auth.login');
        }

        return $next($request);
    }
}
