<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoles
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if (!Auth::user()->hasRole($role)) {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
