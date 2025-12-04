<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Registrar aliases de middleware corretamente
        $middleware->alias([
            // Middleware Admin
            'admin' => \App\Http\Middleware\AdminAuth::class,
            'guest.admin' => \App\Http\Middleware\AdminGuest::class,

            // Middleware Cliente
            'cliente.auth' => \App\Http\Middleware\ClienteAuth::class,
            'guest.cliente' => \App\Http\Middleware\ClienteGuest::class, // opcional se você tiver
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Configuração de tratamento de exceções (opcional)
    })
    ->create();
