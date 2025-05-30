<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        $contacts = Contacto::paginate(10);
        return view('contactos.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'mensagem' => 'required|string',
        ]);
        
        Contacto::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'mensagem' => $validated['mensagem'],
            'lido' => false,
        ]);
        
        return redirect()->route('contactos.index')->with('success', 'Mensagem enviada com sucesso! Entraremos em contacto brevemente.');
    }
}
