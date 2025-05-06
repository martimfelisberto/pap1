<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;


class CarrinhoController extends Controller

{
    public function index()
    {
        $carrinho = session()->get('carrinho', []);
    
        $total = 0;
        foreach ($carrinho as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
    
        if (request()->ajax()) {
            return response()->json([
                'items' => $carrinho,
                'total' => $total
            ]);
        }
    
        return view('carrinho.index', compact('carrinho', 'total'));
    
    }

    public function adicionar(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:produtos,id',
            'quantidade' => 'nullable|integer|min:1'
        ]);

        $produto = Produto::findOrFail($request->id);
    $quantidade = $request->quantidade ?? 1;

    $carrinho = session()->get('carrinho', []);

    if (isset($carrinho[$produto->id])) {
        $carrinho[$produto->id]['quantidade'] += $quantidade;
    } else {
        $carrinho[$produto->id] = [
            "id" => $produto->id,
            "nome" => $produto->nome,
            "quantidade" => $quantidade,
            "preco" => $produto->preco,
            "imagem" => $produto->imagem,
            "marca" => $produto->marca
        ];
        }

        session()->put('carrinho', $carrinho);

        // Calcula o total
        $total = 0;
        foreach ($carrinho as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
    
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$produto->nome} adicionado ao carrinho!",
                'cart' => [
                    'items' => $carrinho,
                    'total' => $total
                ]
            ]);
        }

        return redirect()->back()
            ->with('success', "{$produto->nome} adicionado ao carrinho!");
    }

    public function remover($id)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $nomeProduto = $carrinho[$id]['nome'];
            unset($carrinho[$id]);
            session()->put('carrinho', $carrinho);
            
            return redirect()->back()
                ->with('success', "{$nomeProduto} removido do carrinho!");
        }

        return redirect()->back()
            ->with('error', 'Produto não encontrado no carrinho!');
    }

    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1'
        ]);

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $carrinho[$id]['quantidade'] = $request->quantidade;
            session()->put('carrinho', $carrinho);
            
            return redirect()->back()
                ->with('success', 'Quantidade atualizada!');
        }

        return redirect()->back()
            ->with('error', 'Produto não encontrado no carrinho!');
    }

    public function limpar()
    {
        session()->forget('carrinho');
        
        return redirect()->back()
            ->with('success', 'Carrinho esvaziado com sucesso!');
    }

    public function count()
{
    $count = 0;
    $carrinho = session()->get('carrinho', []);
    
    foreach ($carrinho as $item) {
        $count += $item['quantidade'];
    }

    return response()->json(['count' => $count]);
}
}