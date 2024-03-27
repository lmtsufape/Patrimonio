<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckServidorValido
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($request->user()->servidor) && $request->user()->servidor->ativo || $request->user()->hasAnyRoles(['Administrador'])) {
            return $next($request);
        }

        return abort(403, 'Acesso Negado');
    }
}
