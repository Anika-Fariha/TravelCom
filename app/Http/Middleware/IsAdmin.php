<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role != 1) {
            return redirect('/home'); // Redirect non-admin users to the homepage or a different route
        }

        return $next($request);
    }
}

