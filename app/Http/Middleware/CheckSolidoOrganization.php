<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSolidoOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->belongs_to('Solido Connecting Solutions')) {

            $organization_id = Organization::where('business_name', 'Solido Connecting Solutions')
                ->where('active', true)
                ->first()
                ->id;

            $access_level = $user->access_level_in_organization($organization_id);

            return $next($request);
        }
        
        return to_route('home');
    }
}
