<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="{{ asset('css/editar_produto.css') }}">
<title>Editar Produto (Café)</title>

<div class="admin-content-wrapper">
    <div class="produto-container">

        <h2>Editar Café</h2>

        {{-- Exibe mensagens --}}
        @if (session('success'))
            <p class="mensagem-sucesso">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <p class="mensagem-erro">
                @foreach ($errors->all() as $erro)
                    • {{ $erro }} <br>
                @endforeach
            </p>
        @endif

        <br>

        <form action="{{ route('admin.produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- IMAGEM ATUAL E ALTERAR IMAGEM --}}
            <div class="input-group">

                @if($produto->imagem)
                    <div class="imagem-preview">
                        <img src="{{ asset('storage/' . $produto->imagem) }}" 
                             alt="Imagem do produto">
                    </div>
                @endif
                
                {{-- CAMPO DE ARQUIVO ESTILIZADO --}}
                <label for="imagem" class="input-file-label">Escolher Nova Imagem</label>
                <input type="file" name="imagem" id="imagem" accept="image/*" style="display:none;">
            </div>

            {{-- NOME --}}
            <div class="input-group">
                <input type="text" name="nome" placeholder="Nome do Café" value="{{ $produto->nome }}" required>
            </div>

            {{-- PREÇO --}}
            <div class="input-group">
                <input type="number" step="0.01" name="preco" placeholder="Preço (R$)" value="{{ $produto->preco }}" required>
            </div>

            {{-- PESO --}}
            <div class="input-group">
                <input type="number" name="peso" placeholder="Peso (em gramas)" value="{{ $produto->peso }}">
            </div>

            {{-- CATEGORIA --}}
            <div class="input-group">
                <input type="text" name="categoria" placeholder="Categoria (ex: Gourmet, Especial)" value="{{ $produto->categoria }}">
            </div>

            {{-- TIPO DE TORRA --}}
            <div class="input-group-cadastro1">
                <select name="tipo_torra" required>
                    <option value="">Tipo de Torra</option>
                    <option value="clara"  {{ $produto->tipo_torra == "clara" ? "selected" : "" }}>Clara</option>
                    <option value="média"  {{ $produto->tipo_torra == "média" ? "selected" : "" }}>Média</option>
                    <option value="escura" {{ $produto->tipo_torra == "escura" ? "selected" : "" }}>Escura</option>
                </select>
            </div>

            {{-- DESCRIÇÃO --}}
            <div class="descriçao">
                <textarea name="descricao" rows="5" placeholder="Descrição do Café">{{ $produto->descricao }}</textarea>
            </div>

            <button type="submit" class="botao-principal">Atualizar</button>

        </form>
    </div>
</div>