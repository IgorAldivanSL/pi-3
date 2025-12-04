<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Assinatura;
use Illuminate\Support\Facades\Auth;

class AssinaturaController extends Controller
{
    // Página de checkout
    public function checkout(Produto $produto)
    {
        return view('cliente.checkout', compact('produto'));
    }

    // Finalizar compra / criar assinatura
    public function store(Request $request, Produto $produto)
    {
        $request->validate([
            'endereco' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'cep' => 'required',
            'cartao_final' => 'required|min:4|max:4',
        ]);

        $assinatura = Assinatura::create([
            'cliente_id' => auth('cliente')->id(),
            'produto_id' => $produto->id,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
            'cartao_final' => '**** ' . $request->cartao_final,
            'valor_assinatura' => $produto->preco,
            'tipo' => 'mensal',
            'status' => 'ativa',
            'data_inicio' => now(),
        ]);

        // Retorna a tela de sucesso renderizada
        $html = view('cliente.partials.checkout_success', compact('assinatura'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function cancelar(Assinatura $assinatura)
    {
        // Garantir que só o dono pode cancelar
        if ($assinatura->cliente_id !== auth('cliente')->id()) {
            return response()->json(['message' => 'Ação não permitida.'], 403);
        }

        // Atualiza o status
        $assinatura->update([
            'status' => 'cancelada'
        ]);

        // Retorna a lista atualizada (para AJAX)
        $assinaturas = auth('cliente')->user()->assinaturas()->with('produto')->get();

        return response()->json([
            'message' => 'Assinatura cancelada com sucesso.',
            'html' => view('cliente.partials.assinaturas', compact('assinaturas'))->render()
        ]);
    }

   public function deletar(\App\Models\Assinatura $assinatura)
    {
        $cliente = auth('cliente')->user();

        if (!$cliente || $assinatura->cliente_id !== $cliente->id) {
            return response()->json(['message' => 'Ação não permitida.'], 403);
        }

        if ($assinatura->status === 'ativa') {
            return response()->json(['message' => 'Você não pode excluir uma assinatura ativa.'], 400);
        }

        // apaga do banco
        $assinatura->delete();

        // recarrega listagem
        $assinaturas = $cliente->assinaturas()->with('produto')->get();
        $html = view('cliente.partials.assinaturas', compact('assinaturas'))->render();

        return response()->json([
            'message' => 'Assinatura removida com sucesso.',
            'html' => $html
        ]);
    }



    // Listagem de assinaturas
    public function index()
    {
        $cliente = auth('cliente')->user();
        $assinaturas = $cliente->assinaturas()->with('produto')->get();

        if (request()->ajax()) {
            return view('cliente.partials.assinaturas', compact('assinaturas'))->render();
        }

        return view('cliente.assinaturas', compact('assinaturas'));
    }
}
