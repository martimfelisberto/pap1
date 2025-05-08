<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Categoria;



class ProdutoController extends Controller
{
    // No ProdutoController.php
    public function index(Request $request)
    {
        $query = Produto::query();

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', $request->preco_min);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        $genero = $request->genero;

        $query = Produto::query();

        if ($genero) {
            $query->where('genero', $genero);
        }

        $produtos = $query->latest()->paginate(12);

        return view('produtos.index', compact('produtos', 'genero'));
    }

    // Método para mostrar o formulário de criação
    public function create()
    {
        return view('produtos.create');
    }
    public function edit(Produto $produto)
    {
        if (Auth::id() != $produto->autor_id) {
            return redirect()->route('produtos.show', $produto->id)
                ->with('error', 'Não tens permissão para editar este produto.');
        }

        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        if (Auth::id() != $produto->autor_id) {
            return redirect()->route('produtos.show', $produto->id)
                ->with('error', 'Não tens permissão para editar este produto.');
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'marca' => 'required|string',
            'categoria' => 'required|string',
            'genero' => 'required|in:homem,mulher,criança',
            'estado' => 'required|in:novo,usado,semi-novo',
            'tamanho' => 'required|string',
            'cores' => 'required|array',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'especificacoes' => 'array'
        ]);

        // Get specifications based on category
        $especificacoes = $this->getEspecificacoesByCategoria($request);

        // Update basic product info
        $produto->nome = $validated['nome'];
        $produto->descricao = $validated['descricao'];
        $produto->preco = $validated['preco'];
        $produto->marca = $validated['marca'];
        $produto->categoria = $validated['categoria'];
        $produto->genero = strtolower($validated['genero']);
        $produto->estado = strtolower($validated['estado']);
        $produto->tamanho = $validated['tamanho'];
        $produto->cores = $validated['cores'];
        $produto->especificacoes = $especificacoes;

        // Handle image upload if new image is provided
        if ($request->hasFile('imagem')) {
            // Delete old image
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }

            // Store new image
            $imagePath = $request->file('imagem')->store('produtos', 'public');
            $produto->imagem = $imagePath;
        }

        $produto->save();

        return redirect()->route('produtos.show', $produto->id)
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        if (Auth::id() != $produto->autor_id) {
            return redirect()->route('produtos.show', $produto->id)
                ->with('error', 'Não tens permissão para eliminar este produto.');
        }

        // Delete product image
        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            Storage::disk('public')->delete($produto->imagem);
        }

        // Delete related favorites
        DB::table('favorites')->where('produto_id', $produto->id)->delete();

        // Delete the product
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto eliminado com sucesso!');
    }

    public function userFavorites($userId)
    {
        $user = User::findOrFail($userId);
        $favorites = $user->favoriteProdutos()->paginate(12);

        return view('produtos.favorites', compact('user', 'favorites'));
    }

    public function homem($tipo = null)
    {
        $query = Produto::where('genero', 'homem');
        
        if ($tipo) {
            $query->where('tipo', $tipo);
        }
        
        $produtos = $query->latest()->paginate(12);
    }
    
    public function mulher($tipo = null)
    {
        $query = Produto::where('genero', 'mulher');
        
        if ($tipo) {
            $query->where('tipo', $tipo);
        }
        
        $produtos = $query->latest()->paginate(12);
    }
    
    public function criança($tipo = null)
    {
        $query = Produto::where('genero', 'criança');
        
        if ($tipo) {
            $query->where('tipo', $tipo);
        }
        
        $produtos = $query->latest()->paginate(12);
    }
    
    public function produtosPorGenero($genero)
    {
        $validGeneros = ['homem', 'mulher', 'criança', 'unissex'];
        
        if (!in_array($genero, $validGeneros)) {
            abort(404);
        }

        $produtos = Produto::where('genero', $genero)->get();
        return view('produtos.index', compact('produtos', 'genero'));
    }

    public function categoria($categoria, $genero)
    {
        // Validar categoria e gênero
        $validCategorias = ['casacos', 'tshirts', 'camisolas', 'calcas', 'sapatilhas'];
        $validGeneros = ['homem', 'mulher', 'criança'];

        if (!in_array($categoria, $validCategorias) || !in_array($genero, $validGeneros)) {
            abort(404);
        }

        $query = Produto::query()
            ->where('categoria', $categoria)
            ->where('genero', $genero);

        // Aplicar filtros se existirem
        if (request()->filled('preco_min')) {
            $query->where('preco', '>=', request('preco_min'));
        }

        if (request()->filled('preco_max')) {
            $query->where('preco', '<=', request('preco_max'));
        }

        if (request()->filled('marca')) {
            $query->where('marca', request('marca'));
        }

        if (request()->filled('estado')) {
            $query->where('estado', request('estado'));
        }

        if (request()->filled('tamanho')) {
            $query->where('tamanho', request('tamanho'));
        }

        // Buscar produtos com paginação
        $produtos = $query->latest()->paginate(12);
        
        // Buscar marcas disponíveis para esta categoria/gênero
        $marcas = Produto::where('categoria', $categoria)
                        ->where('genero', $genero)
                        ->distinct('marca')
                        ->pluck('marca');

        return view('produtos.categoria', compact('produtos', 'categoria', 'genero', 'marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'marca' => 'required|string',
            'categoria' => 'required|string',
            'genero' => 'required|in:homem,mulher,criança',
            'estado' => 'required|in:novo,usado,semi-novo',
            'tamanho' => 'required|string',
            'cores' => 'required|array',
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'especificacoes' => 'array'
        ]);
    
        // Handle image upload
        $imagePath = $request->file('imagem')->store('produtos', 'public');
    
        // Get specifications based on category
        $especificacoes = $this->getEspecificacoesByCategoria($request);
    
        $produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'marca' => $request->marca,
            'categoria' => $request->categoria,
            'genero' => strtolower($request->genero),
            'estado' => strtolower($request->estado),
            'tamanho' => $request->tamanho,
            'cores' => $request->cores,
            'imagem' => $imagePath,
            'especificacoes' => $especificacoes,
            'user_id' => Auth::id(),
        ]);
    
        return redirect()->route('produtos.categoria', [
            'categoria' => strtolower($produto->categoria),
            'genero' => strtolower($produto->genero)
        ])->with('success', 'Produto adicionado com sucesso!');
    }
    
    private function getEspecificacoesByCategoria(Request $request)
    {
        $especificacoes = [];
    
        switch ($request->categoria) {
            case 'casacos':
                $especificacoes = [
                    'tipo' => $request->tipo_casaco,
                    'forro' => $request->forro,
                    'capuz' => $request->has('capuz'),
                    'fechamento' => $request->fechamento,
                    'material' => $request->material
                ];
                break;
    
            case 'sapatilhas':
                $especificacoes = [
                    'tipo_sola' => $request->tipo_sola,
                    'material' => $request->material,
                    'fechamento' => $request->fechamento,
                    'tecnologia' => $request->tecnologia
                ];
                break;
    
            case 'calcas':
                $especificacoes = [
                    'tipo' => $request->tipo_calca,
                    'cintura' => $request->cintura,
                    'comprimento' => $request->comprimento,
                    'material' => $request->material
                ];
                break;
    
            case 'tshirts':
            case 'camisolas':
                $especificacoes = [
                    'gola' => $request->gola,
                    'manga' => $request->manga,
                    'material' => $request->material,
                    'estampa' => $request->has('estampa')
                ];
                break;
        }
    
        return $especificacoes;
    

        // Processar upload da imagem
        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('public/produtos');
            $validated['imagem'] = str_replace('public/', 'storage/', $path);
        }

        // Converter array de cores para string
        if (isset($validated['cores'])) {
            $validated['cores'] = implode(', ', $validated['cores']);
        }

        Produto::create($validated);
        
        return redirect()->route('produtos.index', ['genero' => $request->genero])
            ->with('success', 'Produto criado com sucesso!');
    }

    public function userProducts()
    {
        $produtos = Auth::produtos()
            ->latest()
            ->paginate(12);
            
        return view('produtos.meus', compact('produtos'));
    }
}