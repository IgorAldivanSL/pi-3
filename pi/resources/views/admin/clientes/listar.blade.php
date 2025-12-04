<link rel="stylesheet" href="{{ asset('css/listar_administrador.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="admin-content-wrapper">
    <div class="container-table">
        <h2>Clientes Cadastrados</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>

            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->cli_nome }}</td>
                    <td>{{ $cliente->cli_cpf }}</td>
                    <td>{{ $cliente->cli_email }}</td>
                    <td>{{ $cliente->cli_telefone }}</td>

                    <td class="acoes-admin">
                        {{-- Excluir Cliente --}}
                        <a href="#"
                           onclick="excluirCliente('{{ route('admin.clientes.delete', $cliente->id) }}')"
                           class="botao-excluir">
                           Excluir
                        </a>
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
</div>
