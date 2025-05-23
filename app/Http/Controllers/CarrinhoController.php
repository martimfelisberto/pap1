<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $produtoId = $request->input('produto_id');

        // Verifica se o produto existe
        $produto = Produto::find($produtoId);
        if (!$produto) {
            return redirect()->back()->with('error', 'Produto não encontrado.');
        }

        // Adiciona o produto ao carrinho na base de dados
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$produtoId])) {
            // Incrementa a quantidade se o produto já estiver no carrinho
            $carrinho[$produtoId]['quantidade']++;
        } else {
            // Adiciona o produto ao carrinho
            $carrinho[$produtoId] = [
                'nome' => $produto->nome,
                'preco' => $produto->preco,
                'imagem' => $produto->imagem,
                'marca' => $produto->marca,
                'quantidade' => 1,
            ];
        }

        session()->put('carrinho', $carrinho);
        // Salva no banco de dados (opcional)
        DB::table('carrinhos')->updateOrInsert(
            ['user_id' => Auth::check() ? Auth::id() : null, 'produto_id' => $produtoId],
            ['quantidade' => $carrinho[$produtoId]['quantidade']]
        );
        

        return redirect()->route('carrinho.index')->with('success', 'Produto adicionado ao carrinho!');
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
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $carrinho[$id]['quantidade'] = $request->quantidade;
            session()->put('carrinho', $carrinho);
        }

        return redirect()->back()->with('success', 'Quantidade atualizada com sucesso!');
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