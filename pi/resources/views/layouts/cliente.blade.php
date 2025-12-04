<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Café' }}</title>

    {{-- CSS global do cliente --}}
    <link rel="stylesheet" href="{{ asset('css/login_cliente.css') }}">
</head>
<body>

    {{-- Conteúdo da página --}}
    @yield('conteudo')

</body>
</html>
