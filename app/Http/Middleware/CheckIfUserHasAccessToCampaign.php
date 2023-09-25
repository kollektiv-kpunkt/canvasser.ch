<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfUserHasAccessToCampaign
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $campaign = $request->route()->parameter("campaign");
        if (!$campaign) {
            return $next($request);
        }
        if (!in_array(auth()->user()->id, $campaign->admins)) {
            abort(403);
        }
        return $next($request);
    }
}
