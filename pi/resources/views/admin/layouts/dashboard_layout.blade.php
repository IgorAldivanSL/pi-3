<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Painel Admin — Café Premium</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="admin-shell">
    <aside class="admin-sidebar">
      <a class="brand" href="{{ route('site.home') }}">
        <img src="{{ asset('img/Logo.png') }}" alt="Logo">
        <span>Café Premium</span>
      </a>

      <nav class="nav">
        <button onclick="carregarPagina('{{ route('admin.produtos.create') }}')">Cadastrar Produto</button>
        <button onclick="carregarPagina('{{ route('admin.produtos.index') }}')">Produtos</button>
        <button onclick="carregarPagina('{{ route('admin.usuarios.listar') }}')">Administradores</button>
        <button onclick="carregarPagina('{{ route('admin.usuarios.create') }}')">Cadastrar Administrador</button>
        <button onclick="carregarPagina('{{ route('admin.clientes.listar') }}')">Clientes</button>
      </nav>

      <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
        @csrf
        <button type="submit">Sair</button>
      </form>
    </aside>

    <main class="admin-main">
     

      <section id="painel-conteudo" class="admin-content">
        {{-- Conteúdo AJAX será carregado aqui --}}
        <div class="welcome">
          <h1>Bem-vindo ao Painel</h1>
        </div>
      </section>
    </main>
  </div>

 <script>
// =========================
//   FUNÇÃO: Carregar páginas no painel
// =========================
function carregarPagina(url) {
    fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" }})
    .then(res => res.text())
    .then(html => {
        document.getElementById('painel-conteudo').innerHTML = html;
    })
    .catch(() => {
        document.getElementById('painel-conteudo').innerHTML =
            '<p>Erro ao carregar o conteúdo.</p>';
    });
}


// =========================
//   FUNÇÃO GLOBAL: Excluir item (admin, usuário, etc.)
// =========================
window.excluirAdmin = function(url) {
    if (!confirm("Tem certeza que deseja excluir este registro?")) return;

    fetch(url, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "application/json"
        }
    })
    .then(async res => {
        const data = await res.json().catch(() => ({}));

        if (!res.ok) {
            alert(data.error || "Erro ao excluir.");
            return;
        }

        alert(data.message || "Registro excluído!");
        carregarPagina("{{ route('admin.usuarios.listar') }}"); // 🔧 altere a rota caso necessário
    })
    .catch(err => {
        console.error(err);
        alert("Erro inesperado ao excluir.");
    });
};

// =========================
//   FUNÇÃO GLOBAL: Excluir Cliente
// =========================
window.excluirCliente = function(url) {

    if (!confirm("Tem certeza que deseja excluir este cliente?")) {
        return;
    }

    fetch(url, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "application/json"
        }
    })
    .then(async res => {
        const data = await res.json().catch(() => ({}));

        if (!res.ok) {
            alert(data.error || "Erro ao excluir o cliente.");
            return;
        }

        alert(data.message || "Cliente excluído com sucesso!");

        // 🔥 Recarregar a listagem de clientes
        carregarPagina("{{ route('admin.clientes.listar') }}");

    })
    .catch(err => {
        console.error(err);
        alert("Erro inesperado ao excluir cliente.");
    });
};

window.excluirProduto = function(url) {
// ... (seu código JavaScript aqui) ...
    if (!confirm("Tem certeza que deseja excluir este produto?")) return;

    fetch(url, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        credentials: 'same-origin'
    })
    .then(async res => {
        if (!res.ok) {
            const text = await res.text().catch(()=> '');
            console.error('Erro resposta:', text || res.status);
            alert('Erro ao excluir produto.');
            return;
        }

        const data = await res.json().catch(()=> ({}));
        alert(data.message || data.mensagem || 'Produto excluído!');
        // Atualiza a listagem:
        
        // Chamando a função global do painel para recarregar a página
        if (window.carregarPagina) {
             // O ideal é recarregar a listagem, não a página inteira
            window.carregarPagina("{{ route('admin.produtos.index') }}");
        } else {
            location.reload();
        }
       
    })
    .catch(err => {
        console.error('Erro fetch:', err);
        alert('Erro ao excluir produto.');
    });
};


// =========================
//   INTERCEPTAR FORMULÁRIOS VIA AJAX
// =========================
document.getElementById("painel-conteudo").addEventListener("submit", async function(event) {

    event.preventDefault();

    const form = event.target;
    const formData = new FormData();

    // Captura todos os campos corretamente
    form.querySelectorAll("input, textarea, select").forEach(field => {
        if (!field.name) return;

        if (field.type === "checkbox") {
            formData.append(field.name, field.checked ? (field.value || "1") : "0");
            return;
        }

        if (field.type === "radio") {
            if (field.checked)
                formData.append(field.name, field.value);
            return;
        }

        if (field.type === "file") {
            Array.from(field.files).forEach(file => formData.append(field.name, file));
            return;
        }

        formData.append(field.name, field.value);
    });

    try {
        const response = await fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        });

        const contentType = response.headers.get("content-type");

        // Se o backend enviou JSON (sucesso ou erro)
        if (contentType?.includes("application/json")) {
            const json = await response.json();

            if (!response.ok) {
                let msgs = "";
                if (json.errors) {
                    Object.values(json.errors).forEach(err => msgs += err + "\n");
                }
                alert(msgs || json.message || "Erro ao salvar.");
                return;
            }

            alert(json.message || "Alterações salvas!");
            carregarPagina("{{ route('admin.usuarios.listar') }}");
            return;
        }

        // Se o backend devolveu HTML (por exemplo, formulário completo novamente)
        const html = await response.text();
        document.getElementById("painel-conteudo").innerHTML = html;

    } catch (error) {
        console.error(error);
        alert("Erro inesperado ao enviar formulário.");
    }
});
</script>

</body>
</html>
