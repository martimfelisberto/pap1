<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Produto $produto)
    {
        return view('checkout.index', compact('produto'));
        
    }

    public function process(Request $request, Produto $produto)
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

        // Salvar os dados do checkout
        \App\Models\Checkout::create([
            'produto_id' => $produto->id,
            'nome_completo' => $request->nome_completo,
            'morada' => $request->morada,
            'localidade' => $request->localidade,
            'cidade' => $request->cidade,
            'codigo_postal' => $request->codigo_postal,
            'telefone' => $request->telefone,
            'pais' => 'Portugal',
            'email' => $request->email ?? 'sem-email@example.com',
            'metodo_pagamento' => $request->metodo_pagamento,
            'preco' => $produto->preco,
            'user_id' => Auth::id(),
        ]);

        // Marcar o produto como indisponível
        $produto->update(['disponivel' => false]);

        return redirect()->route('produtos.index')->with('success', 'Compra realizada com sucesso!');
    }
}
