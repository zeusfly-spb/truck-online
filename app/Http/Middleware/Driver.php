<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Driver
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if (Auth::user() &&  Auth::user()->hasRole('driver') || Auth::user()->hasRole('super-admin'))
        return $next($request);

      return response('Access Denied', 200);
    }
}
