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
        if ($request->user()->ativo || $request->user()->hasAnyRoles(['Administrador'])) {
            if ($request->route()->getName() != 'invalid') {
                return $next($request);
            } else {
                return redirect()->route('home');
            }
        }

        return redirect()->route('invalid');
    }
}
