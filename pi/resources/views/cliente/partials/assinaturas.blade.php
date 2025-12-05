<div class="assinaturas-container">
  @forelse($assinaturas as $assinatura)
  
    <div class="assinatura-card">
        
      <div class="assinatura-imagem">
        <img src="{{ $assinatura->produto->imagem ? Storage::url($assinatura->produto->imagem) : asset('img/default.png') }}" alt="{{ $assinatura->produto->nome }}">
      </div>
      <div class="assinatura-info">
        <h4>{{ $assinatura->produto->nome }}</h4>
        <p class="small-muted">R$ {{ number_format($assinatura->valor_assinatura ?? $assinatura->produto->preco, 2, ',', '.') }}</p>
        <p>Status: <strong>{{ ucfirst($assinatura->status) }}</strong></p>
        <p>Início: {{ $assinatura->data_inicio ? date('d/m/Y', strtotime($assinatura->data_inicio)) : '-' }}</p>
        @if($assinatura->status === 'ativa')
            <button class="btn-cancelar" data-id="{{ $assinatura->id }}">Cancelar</button>
        @else
            <span class="status-cancelada">Cancelada</span>
                <button class="btn-excluir" data-id="{{ $assinatura->id }}">Excluir</button>
        @endif
      </div>
    </div>
  @empty
    <p>Você ainda não possui assinaturas.</p>
  @endforelse
</div>

<style>
 /* ===========================
   CSS Assinaturas (Meus Cafés)
=========================== */

/* Variáveis de Cores (Ajuste se não estiverem disponíveis globalmente) */
:root {
    --cor-primaria: #A0522D;        /* Sienna - Marrom escuro */
    --cor-primaria-hover: #8B4513;  /* Saddle Brown */
    --cor-secundaria: #3D2D2D;      /* Texto escuro */
    --cor-fundo-claro: #F9F7F4;     /* Fundo Creme Suave */
    --cor-fundo-card: #FFFFFF;      /* Branco puro para cards */
    --cor-destaque: #D4AF37;        /* Ouro Velho (para preço) */
    --sombra-card: 0 5px 15px rgba(0, 0, 0, 0.05); 
    --font-serif: 'Playfair Display', serif;
}

/* Importação das fontes */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');


/* Container Principal */
.assinaturas-container {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    padding: 20px 0;
    justify-content: center; /* Centraliza os cards */
    max-width: 1200px;
    margin: 0 auto;
}
.assinaturas-container h2{
    text-align: center;
    width: 100%;
    font-family: var(--font-serif);
    color: var(--cor-secundaria);
    font-size: 2.5rem;
    margin-bottom: 30px;
}

/* Card de Assinatura */
.assinatura-card {
    background: var(--cor-fundo-card);
    border-radius: 10px;
    box-shadow: var(--sombra-card);
    display: flex;
    max-width: 380px; /* Limita a largura do card */
    width: 100%;
    overflow: hidden;
    transition: transform 0.2s;
    border: 1px solid #eee; /* Borda sutil */
    font-family: 'Poppins', sans-serif;
}

.assinatura-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

/* Imagem do Produto - Usando Proporção (Aspect Ratio) */
.assinatura-imagem {
    /* Define a largura mínima e máxima */
    width: 120px;
    min-width: 120px;
    height: 120px;
    
    /* Usa a proporção 1/1 (quadrado) para garantir que não haja cortes indesejados */
    overflow: hidden;
    /* Adiciona um fundo para imagens transparentes */
    background-color: var(--cor-fundo-claro);
    display: flex;
    align-items: center;
    justify-content: center;
}

.assinatura-imagem img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* Informações do Card */
.assinatura-info {
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex-grow: 1;
    text-align: left;
}

.assinatura-info h4 {
    font-family: var(--font-serif);
    font-size: 1.25rem;
    color: var(--cor-primaria); /* Título em cor primária */
    margin: 0 0 5px 0;
    font-weight: 700;
}

.assinatura-info p {
    margin: 3px 0;
    font-size: 0.95rem;
    color: var(--cor-secundaria);
}

.small-muted {
    font-weight: 600;
    color: var(--cor-destaque); /* Preço em Ouro Velho */
    font-size: 1rem;
    margin-bottom: 8px !important;
}

/* Status Ativa */
.assinatura-info strong {
    font-weight: 700;
}

.assinatura-info p:nth-child(3) strong { /* Especificamente a linha de Status */
    color: var(--cor-secundaria); 
}

/* Cor específica para status ativa */
.assinatura-info strong:has(+ p:nth-child(3)[data-status="ativa"]) {
    color: #4CAF50; /* Verde para Ativa */
}
/* Cor específica para status cancelada */
.assinatura-info strong:has(+ p:nth-child(3)[data-status="cancelada"]) {
    color: #E57373;
}


/* ===========================
   BOTÕES E AÇÕES
=========================== */

/* Botão de Ação Padrão */
.btn-cancelar, .btn-excluir {
    margin-top: 10px;
    padding: 8px 15px;
    border-radius: 50px; /* Mais arredondado */
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 600;
    transition: 0.2s;
    border: none;
    align-self: flex-start; /* Alinha o botão à esquerda */
}

/* Botão Cancelar (Primário Invertido/Perigo) */
.btn-cancelar {
    background: transparent;
    border: 2px solid #E57373; /* Tom de vermelho */
    color: #E57373;
}

.btn-cancelar:hover {
    background: #E57373;
    color: white;
}

/* Botão Excluir (Secundário/Perigo) */
.btn-excluir {
    background: #D32F2F; /* Vermelho mais forte */
    color: white;
}

.btn-excluir:hover {
    background: #B71C1C;
}

/* Tag de Status Cancelada */
.status-cancelada {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    background: #eee;
    color: #777;
    font-size: 0.85rem;
    font-weight: 500;
    margin-right: 10px;
}

/* Alinhamento de botões quando há status cancelada */
.assinatura-info .status-cancelada + .btn-excluir {
    margin-left: 0;
}

/* Ajuste Responsivo */
@media (max-width: 600px) {
    .assinatura-card {
        flex-direction: column;
        max-width: 95%; /* Ocupa quase a largura total */
    }
    .assinatura-imagem {
        width: 100%;
        height: 180px; /* Um pouco mais alto no mobile */
    }
    .assinatura-info {
        gap: 5px;
    }
    .assinatura-info h4 {
        font-size: 1.15rem;
    }
}
</style>

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
    if (e.target.classList.contains("btn-deletar")) {
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

