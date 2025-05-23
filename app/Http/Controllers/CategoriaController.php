<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Routing\Controller as BaseController;

class CategoriaController extends BaseController
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $categorias = Categoria::withCount('produtos')
            ->orderBy('genero')
            ->orderBy('categoria')
            
            ->get();
            

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:50',
            
        ]);

        Categoria::create([
            'titulo' => $request->titulo,
            'slug' => Str::slug($request->titulo),
            'genero' => $request->genero,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }


    public function edit(Categoria $categoria)
    {
        
    }

    public function show($genero, $categoria)
    {
        $produtos = Produto::with('user')
            ->where('genero', $genero)
            ->where('categoria', $categoria)
            ->when(request('preco_min'), function($query) {
                return $query->where('preco', '>=', request('preco_min'));
            })
            ->when(request('preco_max'), function($query) {
                return $query->where('preco', '<=', request('preco_max'));
            })
            ->when(request('marca'), function($query) {
                return $query->where('marca', request('marca'));
            })
            ->when(request('estado'), function($query) {
                return $query->where('estado', request('estado'));
            })
            ->when(request('tamanho'), function($query) {
                return $query->where('tamanho', request('tamanho'));
            })
            ->paginate(12)
            ->withQueryString();

        // Get unique brands for filter
        $marcas = Produto::where('genero', $genero)
            ->where('categoria', $categoria)
            ->distinct()
            ->pluck('marca')
            ->sort();

        return view('categorias.show', compact('produtos', 'marcas', 'genero', 'categoria'));
    }

    public function destroy(Categoria $categoria)
    {
        // Check if category has products
        if ($categoria->produtos()->count() > 0) {
            return back()->with('error', 'Não é possível eliminar uma categoria com produtos.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria eliminada com sucesso!');
    }

    public function porGenero($genero)
    {
        return Categoria::where('genero', $genero)
            ->orderBy('titulo')
            ->get(['id', 'titulo as nome', 'slug']);
    }

    public function getNavbarCategories()
    {
        return Categoria::select('genero', 'categoria', 'slug')
            ->orderBy('genero')
            ->orderBy('categoria')
            ->get()
            ->groupBy('genero');
    }
}