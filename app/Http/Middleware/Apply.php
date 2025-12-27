<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Apply
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if(!$user) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para se candidatar a uma vaga.');
        }

        if ($user->email_verified_at === null) {
            return redirect()->back()->with('error', 'Por favor, finalize seu cadastro antes de se candidatar a uma vaga.');
        }

        return $next($request);
    }

}
