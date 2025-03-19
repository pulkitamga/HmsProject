<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$permission): Response
    {
        $user=Auth::user();

        if($user && $user->role_id==1)
        {
            return $next($request);
        }
        if(!Auth::check() || !Auth::user()->hasPermission($permission))
        {
            return $this->unauthorizedResponse($request);
        }
        return $next($request);
    }

    
    /**
     * Handle unauthorized response.
     */
    private function unauthorizedResponse($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'You do not have permission to access this resource.'], 403);
        }

        return redirect()->back()->with('error', 'You do not have permission to access this resource.');
    }
}
