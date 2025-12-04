@extends('cliente.layouts.dashboard_layout')

@section('conteudo')

<div class="pagina-assinaturas">
    <h2 style="margin-bottom: 15px;">Minhas Assinaturas</h2>

    {{-- Inclui a partial que você já tem --}}
    @include('cliente.partials.assinaturas')

</div>

<style>
    .pagina-assinaturas h2 {
        text-align: center;
    }
</style>

<script>
document.addEventListener('click', async function (e) {
    if (!e.target.classList.contains('btn-cancelar')) return;

    const id = e.target.dataset.id;
    if (!id) return;

    if (!confirm("Tem certeza que deseja cancelar sua assinatura?")) return;

    const url = `/cliente/assinaturas/${id}/cancelar`;

    try {

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const text = await response.text();

        let data;
        try {
            data = JSON.parse(text);
        } catch {
            console.error(text);
            alert("Erro inesperado no servidor.");
            return;
        }

        if (!response.ok) {
            alert(data.message ?? "Erro ao cancelar assinatura.");
            return;
        }

        // PEGA EXATAMENTE SEU CONTÊINER
        const container = document.querySelector('.assinaturas-container');

        if (!container) {
            console.error("Container .assinaturas-container não encontrado!");
            location.reload();
            return;
        }

        // Troca o HTML renderizado pelo controller
        container.innerHTML = data.html;

        alert("Assinatura cancelada com sucesso!");

    } catch (err) {
        console.error(err);
        alert("Erro inesperado ao cancelar.");
    }
});

document.addEventListener('click', async function (e) {
    if (!e.target.classList.contains('btn-excluir')) return;

    const id = e.target.dataset.id;
    if (!id) return;

    if (!confirm("Tem certeza que deseja excluir esta assinatura? Esta ação é permanente.")) return;

    const url = `/cliente/assinaturas/${id}/deletar`;

    try {
        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const text = await response.text();
        let data;

        try {
            data = JSON.parse(text);
        } catch {
            console.error(text);
            alert("Erro inesperado no servidor.");
            return;
        }

        if (!response.ok) {
            alert(data.message ?? "Erro ao excluir assinatura.");
            return;
        }

        const container = document.querySelector('.assinaturas-container');
        if (!container) {
            console.error("Container .assinaturas-container não encontrado!");
            location.reload();
            return;
        }

        container.innerHTML = data.html;

        alert("Assinatura removida com sucesso!");

    } catch (err) {
        console.error(err);
        alert("Erro inesperado ao excluir.");
    }
});




</script>


@endsection
