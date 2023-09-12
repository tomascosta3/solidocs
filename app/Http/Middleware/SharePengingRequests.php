<?php

namespace App\Http\Middleware;

use App\Models\DayRequest;
use App\Models\Organization;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SharePengingRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        /**
         * If the user is authenticated, they belong to the 'Solido Connecting Solutions'
         * organization and have an access level of 8.
         */
        if($user && $user->belongs_to('Solido Connecting Solutions')) {

            $organization_id = Organization::where('business_name', 'Solido Connecting Solutions')
                ->where('active', true)
                ->first()
                ->id;

            $access_level = $user->access_level_in_organization($organization_id);

            if($access_level && $access_level >= 8) {

                // Get the number of pending requests.
                $pending_requests = DayRequest::where('status', 'Pending')
                    ->where('active', true)
                    ->count();

                // Share it with all views.
                view()->share('pending_requests', $pending_requests);
            }

        }

        return $next($request);
    }
}
