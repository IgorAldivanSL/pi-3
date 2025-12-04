<link rel="stylesheet" href="{{ asset('css/listar_administrador.css') }}">

<div class="admin-content-wrapper">
    <div class="container-table">
        <h2>Administradores Cadastrados</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>

            @foreach($administradores as $adm)
                <tr>
                    <td>{{ $adm->id }}</td>
                    <td>{{ $adm->adm_nome }}</td>
                    <td>{{ $adm->adm_email }}</td>
                    <td>********</td>
                    <td class="status-{{ $adm->ativo ? 'ativo' : 'inativo' }}">{{ $adm->ativo ? 'Sim' : 'Não' }}</td>

                    <td class="acoes-admin">
                        {{-- BOTÃO EDITAR VIA AJAX --}}
                        <a href="#" 
                           onclick="carregarPagina('{{ route('admin.usuarios.editar', $adm->id) }}')" 
                           class="botao-editar">
                            Editar
                        </a>

                        {{-- BOTÃO EXCLUIR --}}
                        <a href="#" 
                           onclick="excluirAdmin('{{ route('admin.usuarios.delete', $adm->id) }}')"
                           class="botao-excluir">
                            Excluir
                        </a>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>