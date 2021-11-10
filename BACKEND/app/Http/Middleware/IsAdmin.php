<?php

namespace App\Http\Middleware;
use Auth;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->rol_id == 1) {
            return $next($request);
        }
        abort(403);
    }
    
}
