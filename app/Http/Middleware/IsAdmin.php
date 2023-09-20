<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }
    
        // Check if the user is not a administrator redirect him to home.
        if (Auth::user()->access_level_in_organization(session('organization_id')) < 8) {
            
            return redirect('home')->with('problem', 'No tienes acceso de administrador.');
        }

        return $next($request);
    }
}
