<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->get('isLogged') !== null && session()->get('userId') !== null) {
            return redirect()->route('user-dashboard', ['id' => session()->get('userId')])
                             ->with('info', 'Anda sudah login.');
        }

        return $next($request);
    }
}
