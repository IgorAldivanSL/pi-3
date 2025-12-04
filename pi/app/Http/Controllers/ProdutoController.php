<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{

    // Página inicial do site (cliente)
    public function home()
    {
        $produtos = Produto::orderBy('id', 'desc')->limit(6)->get();
        return view('index', compact('produtos'));
    }

    // Lista produtos no painel admin
    public function indexAdmin()
    {
        $produtos = Produto::orderBy('id', 'desc')->get();
        return view('admin.produtos.index', compact('produtos'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        return view('admin.produtos.create');
    }

    // Salva um novo produto
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required|numeric',
            'descricao' => 'required',
            'peso' => 'required',
            'categoria' => 'required',
            'tipo_torra' => 'required',
            'imagem' => 'nullable|image',
        ]);

        $produto = new Produto($request->all());

        if ($request->hasFile('imagem')) {
            $produto->imagem = $request->file('imagem')->store('produtos', 'public');
        }

        $produto->save();

        return redirect()->route('admin.produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit(Produto $produto)
    {
        return view('admin.produtos.edit', compact('produto'));
    }

    // Atualiza o produto
    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required|numeric',
            'descricao' => 'required',
            'peso' => 'required',
            'categoria' => 'required',
            'tipo_torra' => 'required',
            'imagem' => 'nullable|image',
        ]);

        $produto->update($request->all());

        if ($request->hasFile('imagem')) {

            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $produto->imagem = $request->file('imagem')->store('produtos', 'public');
        }

        $produto->save();

        return redirect()->route('admin.produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    // Abre a tela de confirmação de exclusão
    public function confirmDelete(Produto $produto)
    {
        return view('admin.produtos.delete', compact('produto'));
    }

    // Exclui o produto definitivamente (AJAX)
    public function destroy(Request $request, Produto $produto)
    {
        // Remove imagem do storage
        if ($produto->imagem) {
            Storage::disk('public')->delete($produto->imagem);
        }

        // Remove do banco
        $produto->delete();

        // Retorno para o fetch()
        return response()->json([
            'mensagem' => 'Produto excluído com sucesso!'
        ], 200);
    }
}
