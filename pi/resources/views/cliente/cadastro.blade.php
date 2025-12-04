<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>

    <link rel="stylesheet" href="{{ asset('css/cadastro_cliente.css') }}">
</head>

<body>

<div class="cadastro-container">

    <a href="{{ url('/') }}">
        <img class="logo" src="{{ asset('img/Logo.png') }}" alt="Logo">
    </a>

    <h2>Cadastro de Cliente</h2>

    @if(session('success'))
        <p class="mensagem-sucesso">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="mensagem-erro">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULÁRIO PARA O CLIENTE --}}
    <form action="{{ route('cliente.store') }}" method="POST">
        @csrf

        <div class="input-group">
            <input type="text" name="nome" placeholder="Nome" value="{{ old('nome') }}" required>
        </div>

        <div class="input-group">
            <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
        </div>

        <div class="input-group">
            <input type="text" name="cpf" placeholder="CPF" value="{{ old('cpf') }}" required>
        </div>

        <div class="input-group">
            <input type="text" name="telefone" placeholder="Telefone" value="{{ old('telefone') }}" required>
        </div>

        {{-- CAMPOS DE SENHA AGORA SEPARADOS --}}
        <div class="input-group">
            <input type="password" name="senha" placeholder="Senha" required>
        </div>
        <div class="input-group">
            <input type="password" name="senha_confirmation" placeholder="Confirmar senha" required>
        </div>

        <button type="submit" class="botao-principal">Cadastrar</button>
    </form>

    <p class="link-secundario">
        Já possui conta?
        <a href="{{ route('cliente.loginView') }}">Faça login aqui</a>
    </p>

</div>

</body>
</html>