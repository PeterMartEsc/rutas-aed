<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response{
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->role) {
            if ($user->role->name === 'Admin' && $user->role->name === $role) {
                return $next($request); 
            }
    
            if ($user->role->name === 'User' && $user->role->name === $role) {
                return redirect('/user-dashboard');
            }
        }

        abort(403, 'You do not have permission to access this page'); 
    }
}
