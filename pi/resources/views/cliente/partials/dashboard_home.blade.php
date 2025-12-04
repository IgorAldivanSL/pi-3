<div class="cliente-home">
    <h1>Olá, {{ auth('cliente')->user()->cli_nome }} </h1>
    <p>Bem-vindo ao seu painel de controle.</p>

    

<script>
document.addEventListener("click", async function (e) {
    // CANCELAR
    if (e.target.classList.contains("btn-cancelar")) {
        const id = e.target.dataset.id;

        if (!confirm("Tem certeza que deseja cancelar esta assinatura?")) return;

        try {
            const response = await fetch(`/cliente/assinaturas/${id}/cancelar`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const data = await response.json();

            if (response.ok) {
                alert("Assinatura cancelada com sucesso!");
                location.reload(); // recarrega a lista
            } else {
                alert(data.message || "Erro ao cancelar assinatura.");
            }
        } catch (error) {
            console.error(error);
            alert("Erro inesperado ao cancelar assinatura.");
        }
    }

    // DELETAR
    if (e.target.classList.contains("btn-excluir")) {
        const id = e.target.dataset.id;

        if (!confirm("Tem certeza que deseja excluir esta assinatura?")) return;

        try {
            const response = await fetch(`/cliente/assinaturas/${id}/deletar`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const data = await response.json();

            if (response.ok) {
                alert("Assinatura removida da lista!");
                location.reload();
            } else {
                alert(data.message || "Erro ao remover assinatura.");
            }
        } catch (error) {
            console.error(error);
            alert("Erro inesperado ao excluir assinatura.");
        }
    }
});
</script>
