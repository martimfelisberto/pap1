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
        // Verifica se existem categorias disponíveis
        $categorias = Categoria::count();

        if ($categorias === 0) {
            // Redireciona para a página inicial com uma mensagem de erro
            return redirect('/')->with('error', 'Não é possível anunciar um produto porque não existem categorias disponíveis.');
        }

        // Caso existam categorias, exibe o formulário de criação
        return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'marca' => 'required|string',
            'tamanho' => 'required|string',
            'estado' => 'required|string|in:novo,semi-novo,usado',
            'imagem' => 'required|image|max:2048',
            'cores' => 'required|array|min:1',
            'tamanhosapatilhas' => 'nullable|string',
            'tipo_produto' => 'required|string',
            'genero' => 'required|string',
        ]);

        // Salvar a imagem
        $path = null;
        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('produtos', 'public');
        }

        // Criar o produto
        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'categoria_id' => $request->categoria_id,
            'marca' => $request->marca,
            'tamanho' => $request->tamanho,
            'estado' => $request->estado,
            'imagem' => $path,
            'cores' => json_encode($request->cores),
            'tamanhosapatilhas' => $request->tamanhosapatilhas ?? null,
            'tipo_produto' => $request->tipo_produto,
            'genero' => $request->genero,
            'disponivel' => true, // Certifique-se de definir como disponível
   
            'user_id' => Auth::id(), // Adicione o ID do usuário autenticado
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
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

        return view('produtos.myproducts', compact('produtos'));
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
    public function myProducts()
{
    // Obtenha os produtos do usuário autenticado
    $produtos = Produto::where('user_id', Auth::id())->get();

    // Retorne a view com os produtos
    return view('produtos.myproducts', compact('produtos'));
}
}