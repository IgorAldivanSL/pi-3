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
/* checkout.css — harmonizado com o tema Café Premium */
:root{
  /* Cores do tema da Home (para consistência) */
  --cor-primaria: #A0522D;        /* Sienna - Marrom escuro */
  --cor-destaque: #D4AF37;        /* Ouro Velho/Amarelo */
  --cor-secundaria: #3D2D2D;      /* Texto escuro */
  --cor-primaria-hover: #8B4513;  /* Saddle Brown - Marrom mais profundo (Novo) */

  /* Cores do Layout */
  --bg: #F9F7F4;                 /* Fundo Creme Suave da Home */
  --card: #fff;                   /* Fundo Card Branco */
  --accent: var(--cor-primaria);  /* Ação principal (botão) */
  --muted: #7c8087;               /* Texto auxiliar */
  --radius: 10px;                 /* Arredondamento */
  --shadow: 0 8px 20px rgba(0, 0, 0, 0.08); /* Sombra mais suave */

  /* Cores de Feedback */
  --success-color: #4CAF50; /* Mantido para compatibilidade, mas os novos são mais específicos abaixo */
  --error-color: #D32F2F;

  /* Cores de Sucesso Harmonizadas (Novo) */
  --success-bg: #EDF7ED;
  --success-border: #C8E6C9;
  --success-text: #388E3C;
}

/* Importação de Fontes (Para garantir a Playfair para títulos) */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

/* ===========================
   BASE & LAYOUT
=========================== */
*{
    box-sizing:border-box;
    font-family:'Poppins', sans-serif; /* Consistência com a Home */
}
/* O body aqui não é necessário, pois o layout é injetado, mas mantive as variáveis */

.checkout-wrap{
    padding: 40px 28px; /* Mais padding para respirar */
    display:flex;
    justify-content:center;
}
.checkout-card{
    width:100%;
    max-width:1000px;
    display:flex;
    gap:30px; /* Mais espaço entre as colunas */
}
.checkout-left{
    flex:1;
    background:var(--card);
    padding:30px; /* Mais padding interno */
    border-radius:var(--radius);
    box-shadow:var(--shadow);
}
.checkout-right{
    width:350px; /* Ligeiramente mais largo que 320px */
}

/* ===========================
   RESUMO DO PRODUTO
=========================== */
.product-summary{
    display:flex;
    gap:15px;
    align-items:center;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom:20px;
}
.product-summary img{
    width:90px;
    height:70px;
    object-fit:cover;
    border-radius:var(--radius);
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.product-summary strong{
    color: var(--accent); /* Preço em destaque */
    font-size: 1.1rem;
}
h2 {
    font-family: 'Playfair Display', serif;
    color: var(--cor-secundaria);
    font-size: 2rem;
    margin-bottom: 25px;
}


/* ===========================
   FORMULÁRIO & INPUTS
=========================== */
.group{margin-bottom:18px}
.row{display:flex;gap:15px}
.col{flex:1}
input[type="text"], input[type="email"], input[type="tel"]{
  width:100%;
  padding:12px;
  border-radius:8px;
  border:1px solid #ddd;
  background:#fff; /* Fundo branco puro */
  transition: border-color 0.2s;
}
input:focus {
    border-color: var(--accent);
    outline: none;
    box-shadow: 0 0 0 1px var(--accent);
}

label{
    display:block;
    font-size:14px;
    font-weight: 500;
    margin-bottom:6px;
    color:var(--cor-secundaria); /* Labels em cor escura */
}

/* ===========================
   BOTÃO DE AÇÃO
=========================== */
.actions {
    margin-top: 30px;
}

.btn-primary{
    background:var(--accent);
    color:#fff;
    padding:14px 20px;
    border-radius:50px; /* Canto arredondado do botão */
    border:0;
    cursor:pointer;
    width: 100%;
    font-size: 1.1rem;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-primary:hover:not(:disabled){
    background: #8B4513; /* Tom de hover mais escuro */
}
.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* ===========================
   RESUMO LATERAL
=========================== */
.summary{
    background:var(--card);
    padding:20px;
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    border: 1px solid #f0f0f0;
}
.summary h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    color: var(--cor-secundaria);
    margin-bottom: 10px;
}

.line{
    display:flex;
    justify-content:space-between;
    padding:10px 0;
    border-bottom:1px dashed #e0e0e0;
    font-size: 0.95rem;
}
.total{
    display:flex;
    justify-content:space-between;
    padding-top:15px;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--accent);
}
.total strong {
    font-size: 1.4rem;
}

.small-muted{
    color:var(--muted);
    font-size:13px;
}

/* ===========================
   PROCESSAMENTO (SPINNER)
=========================== */
.processing{
    display:flex;
    align-items:center;
    gap:10px;
    justify-content: center;
}
.spinner{
    width:18px;
    height:18px;
    border-radius:50%;
    border:3px solid rgba(255,255,255,0.3);
    border-top-color:rgba(255,255,255,1);
    animation:spin .9s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg)}}

/* ===========================
   FEEDBACK: ERRO E SUCESSO
=========================== */
.mensagem-erro {
    background: #FFEBEE; /* Fundo vermelho claro */
    color: var(--error-color);
    border: 1px solid var(--error-color);
    padding: 15px;
    border-radius: var(--radius);
    margin-bottom: 25px;
}
.mensagem-erro ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}
.mensagem-erro li {
    margin-bottom: 5px;
}

/* Estilo para a tela de Sucesso (Nova versão, mais detalhada) */
.checkout-success {
    text-align: center;
    padding: 2.5rem 2rem; 
    
    /* Usando cores de sucesso harmonizadas */
    background-color: var(--success-bg);
    border: 1px solid var(--success-border);
    border-radius: 12px;
    
    max-width: 550px; 
    margin: 2.5rem auto; 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); 
}

/* Título de Confirmação */
.checkout-success h2 {
    font-family: 'Playfair Display', serif;
    color: var(--success-text); 
    font-size: 2.2rem;
    margin-bottom: 1.5rem;
}

.checkout-success p {
    margin: 0.7rem 0;
    font-size: 1.1rem;
    color: var(--cor-secundaria);
}

.checkout-success strong {
    color: var(--cor-primaria);
    font-weight: 600;
}

/* Botão de Ação (CTA) - Usa a cor primária do tema */
.checkout-success .botao-principal {
    margin-top: 2rem;
    padding: 0.8rem 2rem;
    
    background-color: var(--cor-primaria);
    color: white;
    border: none;
    border-radius: 50px; 
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 600;
    transition: background-color 0.2s;
}

.checkout-success .botao-principal:hover {
    background-color: var(--cor-primaria-hover); 
}

/* Ícone de check (se usar Font Awesome ou similar) */
.success-icon {
    color: var(--success-text);
    font-size: 4rem;
}


/* ===========================
   CARTÃO DE CRÉDITO VISUAL
=========================== */
.card-input-group {
    position: relative; 
}

.card-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 30px; 
    height: 20px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    pointer-events: none;
    opacity: 0.5; 
    transition: opacity 0.2s;
}

.card-input-group input {
    padding-right: 45px !important; 
}


/* ===========================
   RESPONSIVO
=========================== */
@media(max-width:900px){
    .checkout-wrap {
        padding: 20px 15px;
    }
    .checkout-card{
        flex-direction:column;
        gap: 20px;
    }
    .checkout-right{
        width:100%
    }
}
@media(max-width:500px){
    h2 { font-size: 1.5rem; }
    .row { flex-direction: column; gap: 0; }
    .group { margin-bottom: 15px; }
}
</style>
