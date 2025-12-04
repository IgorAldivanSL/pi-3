<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="login-container">

    <a href="{{ url('/') }}">
        <img class="logo" src="{{ asset('img/Logo.png') }}" alt="Logo">
    </a>

    <h2>Login de Administrador</h2>

    @if ($errors->any())
        <div class="mensagem-erro">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.login.submit') }}" method="POST">

        @csrf

        <div class="input-group">
            <input type="email" name="email" placeholder="E-mail" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Senha" required>

        </div>

        <button type="submit" class="botao-principal">ENTRAR</button>
    </form>

    <a href="{{ route('site.home') }}" style="display:block; margin-top:15px; text-align:center; color:#6b4f3f; text-decoration:none;">
            ←  Voltar para a página inicial
    </a>

    

</div>


</body>
</html>