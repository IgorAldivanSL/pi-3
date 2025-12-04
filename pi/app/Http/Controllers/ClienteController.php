<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    // Tela de login
    public function loginView()
    {
        return view('cliente.login');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'cli_email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('cliente')->attempt($credentials)) {
            // AGORA FUNCIONA O FLUXO login → checkout
            return redirect()->intended(route('cliente.dashboard'));
        }

        return back()->withErrors(['email' => 'Email ou senha incorretos.']);
    }



    // Tela de cadastro
    public function create()
    {
        return view('cliente.cadastro');
    }

    // Cadastro do cliente
    public function store(Request $request)
    {
        $request->validate([
            'nome'     => 'required',
            'cpf'      => 'required|unique:clientes,cli_cpf',
            'telefone' => 'required',
            'email'    => 'required|email|unique:clientes,cli_email',
            'senha'    => 'required|min:6|confirmed'
        ]);

        Cliente::create([
            'cli_nome'     => $request->nome,
            'cli_cpf'      => $request->cpf,
            'cli_telefone' => $request->telefone,
            'cli_email'    => $request->email,
            'cli_senha'    => Hash::make($request->senha),
        ]);

        return redirect()->route('cliente.loginView')->with('success', 'Conta criada com sucesso!');
    }

    // Dashboard do cliente (após login)
    // Dashboard do cliente
    public function dashboard()
    {
        $cliente = Auth::guard('cliente')->user();
        $assinaturas = $cliente->assinaturas()->with('produto')->get();
        return view('cliente.dashboard', compact('cliente', 'assinaturas'));

    }

    // Atualizar informações do cliente
    // Atualizar informações do cliente
    public function update(Request $request)
    {
        $cliente = Auth::guard('cliente')->user();

        // Validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,cli_email,' . $cliente->id,
            'telefone' => 'nullable|string|max:20',
            'senha' => 'nullable|min:6|confirmed',
        ]);

        // Atualizando dados
        $cliente->cli_nome = $request->nome;
        $cliente->cli_email = $request->email;
        $cliente->cli_telefone = $request->telefone;

        if ($request->filled('senha')) {
            $cliente->cli_senha = Hash::make($request->senha); // campo do banco cli_senha
        }

        $cliente->save();

        // Retorno JSON se for AJAX
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Perfil atualizado com sucesso!',
                'cliente' => [
                    'nome' => $cliente->cli_nome,
                    'email' => $cliente->cli_email,
                    'telefone' => $cliente->cli_telefone,
                ]
            ]);
        }

        // Redirecionamento normal
        return redirect()->route('cliente.dashboard')
                        ->with('success', 'Perfil atualizado com sucesso!');
    }




    public function index()
    {
        $clientes = Cliente::orderBy('id', 'DESC')->get();

        return view('admin.clientes.listar', compact('clientes'));
    }


    // Logout do cliente
    public function logout()
    {
        Auth::guard('cliente')->logout();
        return redirect()->route('cliente.loginView');
    }

    // Listar assinaturas (conteúdo AJAX)
    public function listarAssinaturas()
    {
        $assinaturas = Auth::guard('cliente')->user()->assinaturas()->with('produto')->get();
        return view('cliente.partials.assinaturas', compact('assinaturas'));
    }

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();

            return response()->json([
                'message' => 'Cliente excluído com sucesso!'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Erro ao excluir cliente: ' . $e->getMessage()
            ], 500);
        }
    }


    // Editar informações (conteúdo AJAX)
    public function edit()
    {
        $cliente = Auth::guard('cliente')->user();
        return view('cliente.partials.edit', compact('cliente'));
    }

}
