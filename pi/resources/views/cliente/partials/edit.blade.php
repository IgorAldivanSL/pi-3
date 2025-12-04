<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Informações</title>
    
    {{-- LINK PARA O CSS DE CADASTRO/EDIÇÃO --}}
    <link rel="stylesheet" href="{{ asset('css/editar_cliente.css') }}">
</head>
<body>

<div class="cadastro-container">


    <h2>Editar Informações</h2>

    {{-- Exibe mensagens de sucesso/erro --}}
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
    
    <form action="{{ route('cliente.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NOME --}}
        <div class="input-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $cliente->cli_nome) }}" required>
        </div>

        {{-- CPF --}}
        <div class="input-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $cliente->cli_cpf) }}" required>
        </div>

        {{-- TELEFONE --}}
        <div class="input-group">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $cliente->cli_telefone) }}" required>
        </div>

        {{-- E-MAIL --}}
        <div class="input-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $cliente->cli_email) }}" required>
        </div>

        {{-- SENHA --}}
        <div class="input-group">
            <label for="senha">Senha (deixe em branco para não alterar):</label>
            <input type="password" id="senha" name="senha">
        </div>

        {{-- CONFIRMAR SENHA --}}
        <div class="input-group">
            <label for="senha_confirmation">Confirmar Senha:</label>
            <input type="password" id="senha_confirmation" name="senha_confirmation">
        </div>

        <button type="submit" class="botao-principal">Atualizar</button>
    </form>
</div>

</body>
</html>