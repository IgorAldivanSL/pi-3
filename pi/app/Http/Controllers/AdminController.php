<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginView()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'adm_email' => $request->email,
            'password'  => $request->password
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais não conferem.'
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'  => 'required',
            'email' => 'required|email|unique:usuarios_adm,adm_email',
            'senha' => 'required|min:6|confirmed',
        ]);

        Admin::create([
            'adm_nome'  => $request->nome,
            'adm_email' => $request->email,
            'password'  => Hash::make($request->senha),  // AGORA É password
            'ativo'     => 1,
        ]);

        return redirect()->route('admin.usuarios.listar');
    }

    public function index()
    {
        $administradores = Admin::orderBy('id', 'desc')->get();
        return view('admin.usuarios.listar', compact('administradores'));
    }

    public function edit(Admin $admin)
    {
        return view('admin.usuarios.editar', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'nome'  => 'required',
            'email' => 'required|email|unique:usuarios_adm,adm_email,' . $admin->id,
        ]);

        $admin->adm_nome  = $request->nome;
        $admin->adm_email = $request->email;

        if ($request->filled('senha')) {
            $request->validate(['senha' => 'min:6|confirmed']);
            $admin->password = Hash::make($request->senha);   // AGORA É password
        }

        $admin->save();

        return response()->json([
            'message' => 'Administrador atualizado com sucesso!'
        ]);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['error' => 'Administrador não encontrado.'], 404);
        }

        if (Auth::guard('admin')->id() == $admin->id) {
            return response()->json(['error' => 'Você não pode excluir seu próprio usuário.'], 403);
        }

        $admin->delete();

        return response()->json(['message' => 'Administrador excluído com sucesso!']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
