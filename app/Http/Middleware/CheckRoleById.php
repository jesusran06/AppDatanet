<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckRoleById
{
    public function handle(Request $request, Closure $next, ...$roleIds)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        foreach ($roleIds as $roleId) {
            if ($user->roles()->where('id', $roleId)->exists()) {
               
                return $next($request);
            }
        }

        return redirect('/');
    }
}
