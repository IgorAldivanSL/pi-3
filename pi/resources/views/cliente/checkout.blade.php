@extends('cliente.layouts.dashboard_layout')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

<div class="checkout-wrap">
  <div class="checkout-card">
    <div class="checkout-left">
      <h2>Finalizar assinatura</h2>

      <div class="product-summary">
        <img src="{{ $produto->imagem ? Storage::url($produto->imagem) : asset('img/default.png') }}" alt="{{ $produto->nome }}">
        <div>
          <h3 style="margin:0;">{{ $produto->nome }}</h3>
          <p class="small-muted" style="margin:6px 0 0 0;">{{ $produto->descricao }}</p>
          <strong style="display:block;margin-top:8px;">R$ {{ number_format($produto->preco,2,',','.') }} / mês</strong>
        </div>
      </div>

      <form id="checkout-form" action="{{ route('cliente.assinaturas.store', $produto) }}" method="POST">
        @csrf
        <div class="group"> <label for="endereco">Endereço</label> <input id="endereco" name="endereco" type="text" placeholder="Rua, nº, complemento" required> </div> <div class="row"> <div class="col"> <label for="cidade">Cidade</label> <input id="cidade" name="cidade" type="text" placeholder="Cidade" required> </div> <div class="col"> <label for="estado">Estado</label> <input id="estado" name="estado" type="text" placeholder="Estado" required> </div> </div> <div class="group"> <label for="cep">CEP</label> <input id="cep" name="cep" type="text" placeholder="00000-000" required> </div>

        
        <div class="group">
            <label for="numero_cartao">Número do cartão</label>
            <input id="numero_cartao" name="numero_cartao" type="text" maxlength="19"
                placeholder="1234 5678 9012 3456" required>
        </div>

        <div class="group">
            <label for="nome_cartao">Nome impresso no cartão</label>
            <input id="nome_cartao" name="nome_cartao" type="text" placeholder="Como no cartão" required>
        </div>

        <div class="row">
            <div class="col">
                <label for="validade_mes">Validade (Mês)</label>
                <input id="validade_mes" name="validade_mes" type="text" maxlength="2"
                    placeholder="MM" required>
            </div>

            <div class="col">
                <label for="validade_ano">Validade (Ano)</label>
                <input id="validade_ano" name="validade_ano" type="text" maxlength="2"
                    placeholder="AA" required>
            </div>
        </div>

        <div class="group">
            <label for="cvv">CVV</label>
            <input id="cvv" name="cvv" type="text" maxlength="3" placeholder="123" required>
        </div>

        {{-- Campo oculto onde salvamos só os 4 últimos dígitos --}}
        <input type="hidden" id="cartao_final" name="cartao_final">


        
      

    </div>

    <aside class="checkout-right">
      <div class="summary">
        <h4>Resumo</h4>
        <div class="line">
          <span>{{ $produto->nome }}</span>
          <strong>R$ {{ number_format($produto->preco,2,',','.') }}</strong>
        </div>
        <div class="line">
          <span>Tipo</span>
          <span>Mensal</span>
        </div>
        <div class="total">
          <span>Total inicial</span>
          <strong>R$ {{ number_format($produto->preco,2,',','.') }}</strong>
        </div>
        <div style="margin-top:12px" class="small-muted">Pagamento simulado — dados fictícios (projeto acadêmico).</div>
        <div class="actions">
          <button id="payButton" class="btn-primary" type="submit">Pagar e assinar</button>
      </div>
      </div>

     </form> 
    </aside>
  </div>
</div>

<script>
const form = document.getElementById('checkout-form');
const container = document.querySelector('.checkout-wrap');

// -----------------------------------------------------
// Máscara para o número do cartão (1234 5678 9012 3456)
// -----------------------------------------------------
const numeroCartao = document.getElementById('numero_cartao');

numeroCartao.addEventListener('input', () => {
    let value = numeroCartao.value.replace(/\D/g, "");
    value = value.substring(0, 16);

    // Formatação em blocos de 4 dígitos
    numeroCartao.value = value.replace(/(\d{4})(?=\d)/g, "$1 ");
});

// -----------------------------------------------------
// Validar e salvar apenas os últimos 4 dígitos no campo oculto
// -----------------------------------------------------
function prepararUltimosDigitos() {
    const digits = numeroCartao.value.replace(/\D/g, ""); // remove espaços
    if (digits.length < 16) return false;

    const ultimos4 = digits.substring(digits.length - 4);
    document.getElementById('cartao_final').value = ultimos4;
    return true;
}

// -----------------------------------------------------
// Envio do checkout AJAX
// -----------------------------------------------------
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Antes de enviar → extrair últimos 4 dígitos
    if (!prepararUltimosDigitos()) {
        alert("Número de cartão inválido. Certifique-se de digitar os 16 dígitos.");
        return;
    }

    // Limpa mensagens antigas
    const errosExistentes = container.querySelector('.mensagem-erro');
    if (errosExistentes) errosExistentes.remove();

    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        });

        const data = await response.json();

        if (response.ok) {
            // Substitui todo o conteúdo pelo HTML de sucesso
            container.innerHTML = data.html;
        } else {
            let errosHtml = '<div class="mensagem-erro"><ul>';
            if (data.errors) {
                Object.values(data.errors).forEach(err => {
                    errosHtml += `<li>${err}</li>`;
                });
            } else {
                errosHtml += `<li>${data.message || 'Erro inesperado.'}</li>`;
            }
            errosHtml += '</ul></div>';

            container.insertAdjacentHTML('afterbegin', errosHtml);
        }
    } catch (err) {
        console.error(err);
        alert("Erro inesperado ao enviar o formulário.");
    }
});
</script>


@endsection
