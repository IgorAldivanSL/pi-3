<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador</title>

    <link rel="stylesheet" href="{{ asset('css/cadastro_admin.css') }}">
</head>

<body>

<div class="admin-content-wrapper">
    <div class="cadastro-container">

        <img class="logo" src="{{ asset('assets/logo.png') }}" alt="Logo">

        <h2>Cadastro de Administrador</h2>

        {{-- Mensagens de sucesso/erro --}}
        @if(session('success'))
            <p class="mensagem-sucesso">{{ session('success') }}</p>
        @endif
        
        @if ($errors->any())
            <p class="mensagem-erro">
                @foreach ($errors->all() as $erro)
                    • {{ $erro }} <br>
                @endforeach
            </p>
        @endif

        <form action="{{ route('admin.usuarios.store') }}" method="POST">
            @csrf

            {{-- NOME e TELEFONE - Agora separados --}}
            <div class="input-group">
                <input type="text" name="nome" placeholder="Nome" value="{{ old('nome') }}" required>
            </div>
            
            <div class="input-group">
                <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
            </div>

        
            {{-- SENHA e CONFIRMAR SENHA - Agora separados --}}
            <div class="input-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <div class="input-group">
                <input type="password" name="senha_confirmation" placeholder="Confirmar senha" required>
            </div>

            <div class="checkbox-container">
                 <label for="ativo">
                    <input type="checkbox" id="ativo" name="ativo" value="1" checked>
                    Ativo
                 </label>
            </div>
           

            <button type="submit" class="botao-principal">Cadastrar</button>
        </form>
    </div>
</div>

</body>
</html>
