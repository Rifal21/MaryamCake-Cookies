<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track requests that are not coming from the admin panel (optional)
        if (!$request->is('admin*')) {
            try {
                \App\Models\SiteVisit::updateOrCreate(
                    ['session_id' => session()->getId()], // Updated to session ID
                    [
                        'ip_address' => $request->ip(), // Now just a tracked attribute
                        'user_agent' => $request->userAgent(),
                        'last_activity_at' => now(),
                    ]
                );
            } catch (\Exception $e) {
                // Silently fail if tracking fails to not break the site
            }
        }

        return $next($request);
    }
}
