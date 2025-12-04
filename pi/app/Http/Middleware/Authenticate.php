<?php

namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Obter a URL para redirecionar usuários não autenticados.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // Redireciona os clientes para a página de login do cliente
            if ($request->is('cliente/*')) {
                return route('cliente.loginView');
            }

            // Redireciona os admins para a página de login do admin
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            // Caso geral (opcional)
            // return route('login'); 
        }
    }
}
