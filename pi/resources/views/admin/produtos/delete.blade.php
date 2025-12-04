<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="{{ asset('css/delete_produto.css') }}">
<title>Excluir Produto</title>

<div class="delete-container">

    <h2>Excluir Produto</h2>

    <p>Você realmente deseja excluir o produto abaixo?</p>

    <div class="produto-info">
        <img src="{{ Storage::url($produto->imagem) }}" alt="{{ $produto->nome }}">
        
        <h3>{{ $produto->nome }}</h3>
        <p>{{ $produto->descricao }}</p>
    </div>

    <div class="botoes">
        <button class="btn-cancelar" onclick="carregarPagina('{{ route('admin.produtos.index') }}')">
            Cancelar
        </button>

        <button class="btn-excluir" onclick="confirmarExclusao('{{ route('admin.produtos.delete', $produto->id) }}')">
            Excluir definitivamente
        </button>
    </div>

</div>

<script>
function confirmarExclusao(url) {

    if (!confirm("Tem certeza? Esta ação não poderá ser desfeita.")) return;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.mensagem);
        carregarPagina("{{ route('admin.produtos.index') }}");
    })
    .catch(() => alert("Erro ao excluir produto."));
}
</script>
