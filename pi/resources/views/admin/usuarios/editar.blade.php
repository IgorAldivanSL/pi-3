<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/editar_admin.css') }}">
<title>Editar Administrador</title>

<div class="editadm-container">
    <h2>Editar administrador</h2>

    <form id="form-editar-admin" action="{{ route('admin.usuarios.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="input-group">
            <input type="text" name="nome" placeholder="Nome" value="{{ $admin->nome ?? old('nome') }}" required>
        </div>
        
        <div class="input-group">
            <input type="email" name="email" placeholder="E-mail" value="{{ $admin->email ?? old('email') }}" required>
        </div>

    
        {{-- Deixei a senha com old() caso queira manter o valor em caso de erro de validação --}}
        <div class="input-group">
            <input type="password" name="senha" placeholder="Nova Senha (opcional)">
        </div>
        <div class="input-group">
            <input type="password" name="senha_confirmation" placeholder="Confirmar nova senha">
        </div>

        <div class="checkbox-container">
             <label for="ativo">
                <input type="checkbox" id="ativo" name="ativo" value="1" {{ ($admin->ativo ?? true) ? 'checked' : '' }}>
                Ativo
             </label>
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>


