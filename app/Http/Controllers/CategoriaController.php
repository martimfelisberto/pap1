<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Doctrine\Inflector\InflectorFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



use Illuminate\Routing\Controller as BaseController;

class CategoriaController extends BaseController
{
    public function porGenero($genero)
    {
        $categorias = Categoria::where('genero', $genero)
                             ->orWhere('genero', 'unissex')
                             ->get(['id', 'nome']);
                             
        return response()->json($categorias);
    }
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Show the form for creating a new clothing category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('categorias.create');
    }

    /**
     * Store a newly created clothing category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Create inflector for singular/plural handling
        $inflector = InflectorFactory::create()->build();
        $nome = strtolower($request->nome);
        $singular = strtolower($inflector->singularize($nome));
        $plural = strtolower($inflector->pluralize($nome));

        // Custom validation for duplicate categories
        $request->validate([
            'nome' => [
                'required',
                'string',
                'min:3',
                'max:255',
                function ($attribute, $value, $error) use ($singular, $plural) {
                    // Check if category exists in singular or plural form
                    $existingCategory = Categoria::whereRaw('LOWER(nome) = ?', [$singular])
                        ->orWhereRaw('LOWER(nome) = ?', [$plural])
                        ->exists();

                    if ($existingCategory) {
                        $error($attribute, '❌ Esta categoria de vestuário já existe.');
                    }
                },
            ],
            'genero' => 'required|in:homem,mulher,crianca',
            'descricao' => 'nullable|string|max:500',
        ]);

        // Create the category with slug
        Categoria::create([
            'nome' => $request->nome,
            'slug' => Str::slug($request->nome),
            'genero' => $request->genero,
            'descricao' => $request->descricao,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Categoria de vestuário criada com sucesso!');
    }

    /**
     * Display a listing of clothing categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categorias = Categoria::with('produtos')
            ->withCount('produtos')
            ->orderBy('nome')
            ->get();
            
        return view('categorias.index', compact('categorias'));
    }
    
    /**
     * Show the specified clothing category.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $categoria = Categoria::where('slug', $slug)
            ->with(['produtos' => function($query) {
                $query->where('status', 'ativo')
                    ->orderBy('created_at', 'desc');
            }])
            ->firstOrFail();

        return view('categorias.show', compact('categoria'));
    }
    
    /**
     * Delete a clothing category
     * 
     * @param Categoria $categoria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Categoria $categoria)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Check if category has products
        if ($categoria->produtos()->count() > 0) {
            return back()->with('error', 'Não é possível eliminar uma categoria que contém produtos.');
        }
        
        $categoria->delete();
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Categoria eliminada com sucesso!');
    }
}