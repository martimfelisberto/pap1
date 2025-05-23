<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Produto $produto)
    {
        $carrinho = session()->get('carrinho', []);
        $total = array_reduce($carrinho, function ($carry, $item) {
            return $carry + ($item['preco'] * $item['quantidade']);
        }, 0);

        return view('checkout.index', compact('carrinho', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'morada' => 'required|string|max:255',
            'localidade' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|regex:/^[0-9]{4}-[0-9]{3}$/',
            'telefone' => 'required|string|regex:/^\+351-[0-9]{9}$/',
            'metodo_pagamento' => 'required|string|max:50',
        ]);

        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('error', 'O carrinho está vazio.');
        }

        foreach ($carrinho as $produtoId => $item) {
            \App\Models\Checkout::create([
                'produto_id' => $produtoId,
                'nome_completo' => $request->input('nome_completo'),
                'morada' => $request->input('morada'),
                'localidade' => $request->input('localidade'),
                'cidade' => $request->input('cidade'),
                'codigo_postal' => $request->input('codigo_postal'),
                'telefone' => $request->input('telefone'),
                'pais' => 'Portugal', // Ajuste conforme necessário
                'email' => 'sem-email@example.com', // Ajuste conforme necessário
                'metodo_pagamento' => $request->input('metodo_pagamento'),
                'preco' => $item['preco'] * $item['quantidade'],
                'user_id' => Auth::id(),
            ]);
        }

        // Limpa o carrinho após a compra
        session()->forget('carrinho');

        return redirect()->route('produtos.index')->with('success', 'Compra realizada com sucesso!');
    }
}
