<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check() ||  !in_array(auth()->user()->role_id,[1,2]))
        {
            return response()->json(['error' => 'You do not have permission to access this resource.'], 403);
        }
        return $next($request);
    }
}
