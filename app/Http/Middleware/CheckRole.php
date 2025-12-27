<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $mode, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Acesso negado.');
        }

        if ($mode === 'allow') {
            // Só passa se tiver a role
            if (! in_array($user->role, $roles)) {
                abort(403, 'Acesso negado.');
            }
        }

        if ($mode === 'deny') {
            // Bloqueia se tiver a role
            if (in_array($user->role, $roles)) {
                abort(403, 'Acesso negado.');
            }
        }

        return $next($request);
    }

}
