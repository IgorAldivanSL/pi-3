<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Painel Cliente — Café Premium</title>
  <link rel="stylesheet" href="{{ asset('css/cliente.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="client-shell">
    <aside class="client-sidebar">
      <a class="brand" href="{{ route('site.home') }}">
        <img src="{{ asset('img/Logo.png') }}" alt="Logo">
        <span>Café Premium</span>
      </a>

      <nav class="nav">
        <button onclick="carregarCliente('{{ route('cliente.assinaturas') }}')">Minhas assinaturas</button>
        <button onclick="carregarCliente('{{ route('cliente.edit') }}')">Meu perfil</button>
      </nav>

      <form method="POST" action="{{ route('cliente.logout') }}" class="logout-form">
        @csrf
        <button type="submit">Sair</button>
      </form>
    </aside>

    <main class="client-main">
      <header class="client-header">
       
        
      </header>

      <section id="cliente-conteudo" class="client-content">
        @yield('conteudo')
      </section>
    </main>
  </div>

<script>
  function carregarCliente(url) {
    fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" }})
      .then(r => r.text())
      .then(html => document.getElementById('cliente-conteudo').innerHTML = html)
      .catch(()=> document.getElementById('cliente-conteudo').innerHTML = '<p>Erro ao carregar conteúdo.</p>');
  }

  // expose
  window.carregarCliente = carregarCliente;
</script>
</body>
</html>
