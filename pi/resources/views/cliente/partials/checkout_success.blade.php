<div class="checkout-success">
    <h2>Pagamento realizado com sucesso!</h2>
    <p>Sua assinatura para <strong>{{ $assinatura->produto->nome }}</strong> foi confirmada.</p>
    <p>Valor: R$ {{ number_format($assinatura->valor_assinatura, 2, ',', '.') }}</p>
    <p>Início da assinatura: {{ \Carbon\Carbon::parse($assinatura->data_inicio)->format('d/m/Y H:i') }}</p>

    <a href="{{ route('cliente.assinaturas') }}">
        <button class="botao-principal">Ver minhas assinaturas</button>
    </a>
</div>

<style>
<style>
/* Cores do Tema (para referência, se o estilo não estiver importado) */
:root {
    --cor-primaria: #A0522D;        /* Sienna - Marrom escuro */
    --cor-primaria-hover: #8B4513;  /* Saddle Brown - Marrom mais profundo */
    --cor-secundaria: #3D2D2D;      /* Texto escuro */
    --cor-fundo-card: #FFFFFF;      /* Fundo Card Branco */
    
    /* Cores de Sucesso (mantendo o verde, mas mais suave/premium) */
    --success-bg: #EDF7ED;      /* Verde muito claro, quase branco (sucesso) */
    --success-border: #C8E6C9;  /* Verde suave para borda */
    --success-text: #388E3C;    /* Verde escuro para texto */
}

.checkout-success {
    text-align: center;
    padding: 2.5rem 2rem; /* Mais padding interno */
    
    /* Usando cores de sucesso harmonizadas */
    background-color: var(--success-bg);
    border: 1px solid var(--success-border);
    border-radius: 12px; /* Arredondamento suave */
    
    max-width: 550px; /* Levemente mais largo */
    margin: 2.5rem auto; /* Mais espaçamento superior */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Sombra sutil */
}

/* Título de Confirmação */
.checkout-success h2 {
    font-family: 'Playfair Display', serif; /* Consistência com outros títulos */
    color: var(--success-text); /* Verde de sucesso */
    font-size: 2.2rem;
    margin-bottom: 1.5rem;
}

.checkout-success p {
    margin: 0.7rem 0;
    font-size: 1.1rem;
    color: var(--cor-secundaria);
}

.checkout-success strong {
    color: var(--cor-primaria); /* Destaque em marrom (Sienna) */
    font-weight: 600;
}

/* Botão de Ação (CTA) - Usa a cor primária do tema */
.checkout-success .botao-principal {
    margin-top: 2rem;
    padding: 0.8rem 2rem;
    
    /* Usa o Sienna (Marrom Café) */
    background-color: var(--cor-primaria);
    color: white;
    border: none;
    border-radius: 50px; /* Botão arredondado (padrão da Home) */
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 600;
    transition: background-color 0.2s;
}

.checkout-success .botao-principal:hover {
    background-color: var(--cor-primaria-hover); /* Marrom mais escuro */
}
</style>
</style>
