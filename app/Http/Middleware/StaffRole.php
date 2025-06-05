<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user('staff');
        
        if (!$user || $user->role !== $role) {
            abort(403, 'Unauthorized access for this role');
        }

        return $next($request);
    }
}