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
            $routeName !== 'employer.dados-da-empresa.index' &&
            $routeName !== 'employer.dados-da-empresa.store'
        ) {
            return redirect()->route('employer.dados-da-empresa.index');
        }

        // if (
        //     $user->is_candidate &&
        //     $user->email_verified_at === null && 
        //     $routeName !== 'employer.dados-da-empresa.index' &&
        //     $routeName !== 'employer.dados-da-empresa.store'
        // ) {
        //     return redirect()->route('employer.dados-da-empresa.index');
        // }

        if($user->is_employer && $routeName === 'candidate.dashboard') {
            return redirect()->route('employer.dashboard');

        }

        return $next($request);
    }

}
