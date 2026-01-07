<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $routeName = $request->route()->getName();

        if (
            $user->is_employer &&   
            $user->email_verified_at === null && 
            $routeName !== 'employer.profile.index' &&
            $routeName !== 'employer.profile.store'
        ) {
            return redirect()->route('employer.profile.index');
        }

        if (
            $user->is_candidate &&
            $user->email_verified_at === null && 
            $routeName !== 'candidate.profile.index' &&
            $routeName !== 'candidate.profile.store'
        ) {
            return redirect()->route('candidate.profile.index');
        }

        if($user->is_employer && $routeName === 'candidate.dashboard') {
            return redirect()->route('employer.dashboard');
        }

        return $next($request);
    }

}
