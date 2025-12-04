<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [

        // Login padrão do cliente (visitante do site)
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
            'session' => 'web_session',
        ],

        // Login do administrador (painel)
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
            'session' => 'admin_session',
        ],

        // Login do cliente autenticado
        'cliente' => [
            'driver' => 'session',
            'provider' => 'clientes',
            'session' => 'cliente_session',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        // Usuários padrão
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Administradores
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // Clientes do site
        'clientes' => [
            'driver' => 'eloquent',
            'model' => App\Models\Cliente::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    */

    'passwords' => [

        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 30,
            'throttle' => 30,
        ],

        'clientes' => [
            'provider' => 'clientes',
            'table' => 'password_reset_tokens',
            'expire' => 30,
            'throttle' => 30,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Login Redirects
    |--------------------------------------------------------------------------
    */

    'redirects' => [
        'admin' => 'admin.login',
        'cliente' => 'cliente.loginView',
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => 10800,

];
