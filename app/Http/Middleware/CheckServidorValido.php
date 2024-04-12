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
    public function handle(Request $request, Closure $next, $validate)
    {
        if ($request->user()->hasAnyRoles(['Administrador'])) return $next($request);
        
        if ($validate == 'true') { // Se o usuário precisa ser válido
            if ($request->user()->ativo) {
                return $next($request);
            }
            
            return redirect()->route('invalid');
        } else { // Se o usuário precisa ser inválido
            if (! $request->user()->ativo) {
                return $next($request);
            }
            
            return redirect()->route('home');
        }
    }
}
