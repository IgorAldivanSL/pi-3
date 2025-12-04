{{-- resources/views/admin/produtos/create.blade.php --}}

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="{{ asset('css/cadastrar_produto.css') }}">
<title>Cadastrar Produto (Café)</title>

<div class="admin-content-wrapper">
    <div class="produto-container">
        <h2>Cadastro de Café</h2>

        {{-- Exibe mensagens --}}
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <p style="color: red;">
                @foreach ($errors->all() as $erro)
                    • {{ $erro }} <br>
                @endforeach
            </p>
        @endif

        <br>

        <form action="{{ route('admin.produtos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- IMAGEM --}}
            <div class="input-group">
                <label for="imagem" class="input-file-label">Escolher Imagem</label>
                <input type="file" name="imagem" id="imagem" accept="image/*" required style="display:none;">
            </div>

            {{-- NOME --}}
            <div class="input-group">
                <input type="text" name="nome" placeholder="Nome do Café" required>
            </div>

            {{-- PRECO --}}
            <div class="input-group">
                <input type="number" step="0.01" name="preco" placeholder="Preço (R$)" required>
            </div>

            {{-- PESO --}}
            <div class="input-group">
                <input type="number" name="peso" placeholder="Peso (em gramas)">
            </div>

            {{-- CATEGORIA --}}
            <div class="input-group">
                <input type="text" name="categoria" placeholder="Categoria (ex: Gourmet, Especial)">
            </div>

            {{-- TIPO DE TORRA --}}
            <div class="input-group-cadastro1">
                <select name="tipo_torra" required>
                    <option value="">Tipo de Torra</option>
                    <option value="clara">Clara</option>
                    <option value="média">Média</option>
                    <option value="escura">Escura</option>
                </select>
            </div>

            {{-- DESCRIÇÃO --}}
            <div class="descriçao">
                <textarea name="descricao" rows="5" placeholder="Descrição do Café"></textarea>
            </div>

            <button type="submit" class="botao-principal">Publicar</button>

        </form>
    </div>
</div>
