<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Se não estiver autenticado, redireciona para login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Se estiver autenticado mas não for admin, aborta
        if (!Auth::user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores.');
        }

        return $next($request);
    }
}
