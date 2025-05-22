<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->isUser() || Auth::user()->isAdmin()) ) { // Admin juga bisa akses halaman user
            return $next($request);
        }
        // abort(403, 'Unauthorized action.'); // Atau redirect
        return redirect('/login')->with('error', 'Akses ditolak.');
    }
}