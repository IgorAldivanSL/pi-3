<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | Controla o driver de sessão padrão. Para persistência em DB usamos 'database'.
    |
    */
    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Tempo de vida da sessão
    |--------------------------------------------------------------------------
    |
    | Número de minutos antes da sessão expirar.
    |
    */
    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Criptografia de Sessão
    |--------------------------------------------------------------------------
    |
    | Caso queira criptografar os dados da sessão.
    |
    */
    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Localização dos arquivos de sessão (caso driver seja file)
    |--------------------------------------------------------------------------
    */
    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Conexão de banco (caso driver seja database)
    |--------------------------------------------------------------------------
    */
    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Cache store (para Redis ou outros)
    |--------------------------------------------------------------------------
    */
    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nome do cookie
    |--------------------------------------------------------------------------
    |
    | Aqui usamos o cookie default, mas será sobrescrito dinamicamente
    | no AppServiceProvider para admin / cliente / web.
    |
    */
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Path e domínio do cookie
    |--------------------------------------------------------------------------
    */
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS, HTTP Only, Same-Site
    |--------------------------------------------------------------------------
    */
    'secure' => env('SESSION_SECURE_COOKIE'),
    'http_only' => env('SESSION_HTTP_ONLY', true),
    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies (opcional)
    |--------------------------------------------------------------------------
    */
    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),
];
