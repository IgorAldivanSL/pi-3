<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cafés</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/listar_produtos.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- CSRF para fetch --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="admin-content-wrapper">
    <div class="cafe-listagem">

        <h2>Cafés Cadastrados</h2>

        <div class="cafes-container">

            @foreach ($produtos as $produto)
                <div class="cafe-card">

                    {{-- Imagem --}}
                    <div class="cafe-imagem">
                        <img src="{{ $produto->imagem ? Storage::url($produto->imagem) : asset('img/default.png') }}" 
                             alt="{{ $produto->nome }}">
                        <div class="cafe-preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                    </div>

                    {{-- Nome --}}
                    <h3>{{ $produto->nome }}</h3>

                    {{-- Descrição --}}
                    <p>{{ $produto->descricao }}</p>

                    {{-- Informações (Usando o estilo de grid da Home) --}}
                    <div class="cafe-info">
                        <span>Categoria:</span>
                        <span class="info-dado">{{ $produto->categoria ?: '—' }}</span>

                        <span>Peso:</span>
                        <span class="info-dado">{{ $produto->peso ? $produto->peso.'g' : '—' }}</span>

                        <span>Torra:</span>
                        <span class="info-dado">{{ ucfirst($produto->tipo_torra) }}</span>
                    </div>

                    {{-- Botões --}}
                    <div class="card-botoes">
                        <a 
                            href="#" 
                            onclick="carregarPagina('{{ route('admin.produtos.edit', $produto->id) }}')" 
                            class="botao-editar">
                            Editar
                        </a>

                        <a href="javascript:void(0);"
                           onclick="event.stopPropagation(); event.preventDefault(); excluirProduto('{{ route('admin.produtos.delete', $produto->id) }}')"
                           class="botao-excluir">
                           Excluir
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

{{-- O script de AJAX deve continuar após o HTML principal --}}
<script>
/* expõe a função no escopo global (window) para que onclick inline veja */
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
</script>
</body>
</html>


