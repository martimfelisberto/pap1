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
        // Log para debug
        Log::info('Recebendo requisição para criar produto');
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'marca' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'tamanho' => 'required|string',
            'tipo_produto' => 'required|string|in:Sapatilhas,Roupas',
            'categoria' => 'required|exists:categorias,id',
            'genero' => 'required|string',
            'estado' => 'required|string|in:novo,usado,semi-novo',
            'cores' => 'required|array',
            'imagem' => 'required|image|max:2048', // Alterado para obrigatório
            // Condicionais
            'tamanhosapatilhas' => 'nullable|required_if:tipo_produto,Sapatilhas|string',
            'tipo_sola' => 'nullable|string',
            'medidas' => 'nullable|string',
        ]);
        
        try {
            $produto = new Produto();
            $produto->nome = $request->nome;
            $produto->descricao = $request->descricao;
            $produto->marca = $request->marca;
            $produto->preco = $request->preco;
            $produto->tamanho = $request->tamanho;
            $produto->tipo_produto = $request->tipo_produto;
            $produto->categoria_id = $request->categoria;
            $produto->genero = $request->genero;
            $produto->estado = $request->estado;
            $produto->user_id = Auth::id();
            
            // Processamento de campos condicionais
            if ($request->filled('tamanhosapatilhas')) {
                $produto->tamanhosapatilhas = $request->tamanhosapatilhas;
            }
            
            if ($request->filled('tipo_sola')) {
                $produto->tipo_sola = $request->tipo_sola;
            }
            
            if ($request->filled('medidas')) {
                $produto->medidas = $request->medidas;
            }
            
            // Converter cores de array para JSON
            if ($request->has('cores')) {
                $produto->cores = json_encode($request->cores);
            }
            
            // Processamento da imagem
            if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
                $imagePath = 'produtos'; // Pasta de destino
                $imageName = time() . '_' . $request->file('imagem')->getClientOriginalName();
                
                // Armazenar imagem
                $path = $request->file('imagem')->storeAs($imagePath, $imageName, 'public');
                $produto->imagem = $imageName;
                Log::info('Imagem salva: ' . $path);
            } else {
                Log::error('Problema com a imagem do produto');
                return back()->withInput()->withErrors(['imagem' => 'A imagem é obrigatória e deve ser válida.']);
            }
            
            // Salvar produto
            $produto->save();
            Log::info('Produto salvo com sucesso. ID: ' . $produto->id);
            
            return redirect()->route('produtos.index')
                ->with('success', 'Produto anunciado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao salvar produto: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ocorreu um erro: ' . $e->getMessage()]);
        }



    }
    public function show(Produto $produto)
    {
       // Adicionar marcas para o filtro
    $marcas = [
        'Nike', 'Adidas', 'Puma', 'Reebok', 'New Balance', 
        'Under Armour', 'Converse', 'Vans', 'Fila', 'Asics', 
        'Skechers', 'Tommy Hilfiger', 'Lacoste', 'Ralph Lauren', 'Outros'
    ];
    
    // Produtos relacionados (opcional, se quiser manter algum tipo de listagem)
    $produtosRelacionados = Produto::where('categoria_id', $produto->categoria_id)
        ->where('id', '!=', $produto->id)
        ->limit(3)
        ->get();
    
    return view('produtos.show', compact('produto', 'marcas', 'produtosRelacionados'));
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
       // Verifica se o usuário tem permissão para editar o produto
    if (Auth::id() !== $produto->user_id && !Auth::user()->is_admin) {
        return back()->with('error', 'Não tem permissão para editar este produto.');
    }

    // Validação dos dados
    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'nullable|string',
        'preco' => 'required|numeric|min:0',
        'categoria_id' => 'required|exists:categorias,id',
        'marca' => 'nullable|string|max:255',
        'tamanho' => 'nullable|string|max:255',
        'estado' => 'nullable|string|in:Novo,Semi-novo,Usado',
        'imagem' => 'nullable|image|max:2048',
    ]);

    try {
        // Atualizar os dados do produto
        $produto->update($request->only([
            'nome', 'descricao', 'preco', 'categoria_id', 'marca', 'tamanho', 'estado'
        ]));

        // Atualizar a imagem, se fornecida
        if ($request->hasFile('imagem')) {
            // Exclui a imagem antiga, se existir
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }

            // Salva a nova imagem
            $path = $request->file('imagem')->store('produtos', 'public');
            $produto->imagem = $path;
            $produto->save();
        }

        // Redireciona com mensagem de sucesso
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');
    } catch (\Exception $e) {
        // Log do erro
        Log::error('Erro ao atualizar produto: ' . $e->getMessage());

        // Redireciona com mensagem de erro
        return back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao atualizar o produto.']);
    }
}

    public function destroy(Produto $produto)
    {
        // Exclui o produto
        $produto->delete();

        // Redireciona para a lista de produtos com uma mensagem de sucesso
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso.');
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