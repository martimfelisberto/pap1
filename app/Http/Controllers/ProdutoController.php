<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ProdutoController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Produto::query()->with('categoria');

        // Apply filters if they exist
        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $produtos = $query->latest()->paginate(12);
        $categorias = Categoria::orderBy('titulo')->get();

        return view('produtos.index', compact('produtos', 'categorias'));
        
    }

    public function create()
    {
        $categorias = Categoria::orderBy('titulo')->get();
        return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'marca' => 'required|string',
            'preco'=> ' required|numeric|min:0',
            'tamanho' => 'required|string',
            'tamanhosapatilhas' => 'required|string',
            'tipo_sola' => 'nullable|string',
            'tipo_produto'=> 'required|string|in:Sapatilhas,Roupas',
            'categoria' => 'required|exists:categorias,id',
            'genero' => 'required|string',
            'estado' => 'required|in:novo,usado,semi-novo',
            'cores' => 'required|array',
            'imagem' => 'nullable|image|max:2048',
            'medidas' => 'nullable|string',
        ]);

        try {
            $produto = new Produto($validated);
            $produto->user_id = Auth::id();

            if ($request->hasFile('imagem')) {
                $imagem = $request->file('imagem');
                $nomeImagem = time() . '_' . $imagem->getClientOriginalName();
                $imagem->storeAs('produtos', $nomeImagem, 'public');
                $produto->imagem = $nomeImagem;
            }

            $produto->save();

            return redirect()->route('produtos.index  ', $produto)
                ->with('success', 'Produto criado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao criar produto: ' . $e->getMessage());
        }




    }
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        if (Auth::id() !== $produto->user_id && !Auth::user()->is_admin) {
            return back()->with('error', 'Não tem permissão para editar este produto.');
        }

        $categorias = Categoria::orderBy('titulo')->get();
        return view('produtos.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, Produto $produto)
    {
        
    }

    public function destroy(Produto $produto)
    {
        if (Auth::id() !== $produto->user_id && !Auth::user()->is_admin) {
            return back()->with('error', 'Não tem permissão para eliminar este produto.');
        }

        try {
            if ($produto->imagem) {
                Storage::disk('public')->delete('produtos/' . $produto->imagem);
            }
            
            $produto->delete();
            return redirect()->route('produtos.index')
                ->with('success', 'Produto eliminado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao eliminar produto.');
        }
    }

    public function userProducts()
    {
        $produtos = Produto::where('user_id', Auth::id())
            ->with('categoria')
            ->latest()
            ->paginate(12);

        return view('produtos.meus', compact('produtos'));
    }
    public function welcome()
    {
        $produtosDestaque = Produto::withCount('favorites')
            ->where('disponivel', true)
            ->orderByDesc('favorites_count')
            ->limit(5)
            ->get();

        return view('welcome', compact('produtosDestaque'));
    }
}