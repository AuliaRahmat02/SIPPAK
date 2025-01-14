<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isEkonomi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guest() || ((auth()->user()->jft != 1 ) AND (auth()->user()->kabag != 1) AND (auth()->user()->kabiro != 1))) {
            abort(403);
        }
        return $next($request);
    }
}
