<x-kaira-layout>
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
        <title>Vender Produto</title>
        <style>
            .form-container {
                max-width: 800px;
                margin: auto;
            }

            .image-preview {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 0.5rem;
            }

            .image-placeholder {
                width: 100%;
                height: 200px;
                background-color: #f3f4f6;
                border-radius: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">


    <body class="flex items-center justify-center min-h-screen p-4 bg-gray-100">
        <div class="w-full overflow-hidden bg-white rounded-lg shadow-md form-container">
            <h1 class="py-6 text-3xl font-bold text-center text-blue-600">Vender um Produto</h1>

           <!-- Expanded Filter Section -->
<div class="container mx-auto mt-8">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl font-bold text-blue-600">
                <i class="bi bi-funnel-fill mr-2"></i>Filtros
            </h4>
            @if(request()->anyFilled(['search', 'marca', 'categoria', 'genero', 'estado', 'preco_min', 'preco_max']))
            <a href="{{ route('produtos.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                <i class="bi bi-x-circle mr-1"></i>Limpar filtros
            </a>
            @endif
        </div>

        <form method="GET" action="{{ route('produtos.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Pesquisar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="bi bi-search mr-1"></i>Pesquisar
                    </label>
                    <input type="text" name="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="Nome do produto" value="{{ request()->get('search') }}">
                </div>

                <!-- Marca -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="bi bi-tag-fill mr-1"></i>Marca
                    </label>
                    <select name="marca" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas as marcas</option>
                        <option value="Nike" {{ request()->get('marca') == 'Nike' ? 'selected' : '' }}>Nike</option>
                        <option value="Adidas" {{ request()->get('marca') == 'Adidas' ? 'selected' : '' }}>Adidas</option>
                        <option value="Puma" {{ request()->get('marca') == 'Puma' ? 'selected' : '' }}>Puma</option>
                        <option value="Reebok" {{ request()->get('marca') == 'Reebok' ? 'selected' : '' }}>Reebok</option>
                        <option value="Outros" {{ request()->get('marca') == 'Outros' ? 'selected' : '' }}>Outros</option>
                    </select>
                </div>

                <!-- Categoria -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="bi bi-collection-fill mr-1"></i>Categoria
                    </label>
                    <select name="categoria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas as categorias</option>
                        <option value="Casacos" {{ request()->get('categoria') == 'Casacos' ? 'selected' : '' }}>Casacos</option>
                        <option value="Camisolas" {{ request()->get('categoria') == 'Camisolas' ? 'selected' : '' }}>Camisolas</option>
                        <option value="Calças e Calções" {{ request()->get('categoria') == 'Calças e Calções' ? 'selected' : '' }}>Calças e Calções</option>
                        <option value="Tops e T-shirts" {{ request()->get('categoria') == 'Tops e T-shirts' ? 'selected' : '' }}>Tops e T-shirts</option>
                        <option value="Sapatilhas" {{ request()->get('categoria') == 'Sapatilhas' ? 'selected' : '' }}>Sapatilhas</option>
                    </select>
                </div>

                <!-- Gênero -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="bi bi-gender-ambiguous mr-1"></i>Gênero
                    </label>
                    <select name="genero" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos os gêneros</option>
                        <option value="homem" {{ request()->get('genero') == 'homem' ? 'selected' : '' }}>Homem</option>
                        <option value="mulher" {{ request()->get('genero') == 'mulher' ? 'selected' : '' }}>Mulher</option>
                        <option value="crianca" {{ request()->get('genero') == 'crianca' ? 'selected' : '' }}>Criança</option>
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="bi bi-stars mr-1"></i>Estado
                    </label>
                    <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos os estados</option>
                        <option value="Novo" {{ request()->get('estado') == 'Novo' ? 'selected' : '' }}>Novo</option>
                        <option value="Usado" {{ request()->get('estado') == 'Usado' ? 'selected' : '' }}>Usado</option>
                        <option value="Semi-novo" {{ request()->get('estado') == 'Semi-novo' ? 'selected' : '' }}>Semi-novo</option>
                    </select>
                </div>

                <!-- Faixa de Preço -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="bi bi-currency-euro mr-1"></i>Faixa de Preço
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="preco_min" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                               placeholder="Min" value="{{ request()->get('preco_min') }}" min="0" step="0.01">
                        <input type="number" name="preco_max" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                               placeholder="Max" value="{{ request()->get('preco_max') }}" min="0" step="0.01">
                    </div>
                </div>

            </div>

            <!-- Botão Aplicar -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="bi bi-funnel mr-2"></i>Aplicar Filtros
                </button>
            </div>
        </form>
    </div>
</div>
<!-- End Filter Section -->
 
<!-- Results Summary -->
<div class="container mx-auto px-4 mt-8">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <div class="w-full lg:w-auto">
            @if(request()->anyFilled(['search', 'marca', 'categoria', 'genero', 'estado', 'preco_min', 'preco_max']))
                <h5 class="text-gray-600 text-lg">
                    <i class="bi bi-list-ul mr-2"></i>Resultados da pesquisa:
                    <span class="text-blue-600 font-bold">{{ $produtos->count() }} produtos encontrados</span>
                </h5>
                <div class="flex flex-wrap gap-2 mt-2">
                    @if(request('search'))
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full border flex items-center">
                            <i class="bi bi-search mr-1"></i>{{ request('search') }}
                        </span>
                    @endif

                    @if(request('marca'))
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full border flex items-center">
                            <i class="bi bi-tag-fill mr-1"></i>{{ request('marca') }}
                        </span>
                    @endif

                    @if(request('categoria'))
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full border flex items-center">
                            <i class="bi bi-collection-fill mr-1"></i>{{ request('categoria') }}
                        </span>
                    @endif

                    @if(request('genero'))
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full border flex items-center">
                            <i class="bi bi-gender-ambiguous mr-1"></i>{{ ucfirst(request('genero')) }}
                        </span>
                    @endif

                    @if(request('estado'))
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full border flex items-center">
                            <i class="bi bi-stars mr-1"></i>{{ request('estado') }}
                        </span>
                    @endif

                    @if(request('preco_min') || request('preco_max'))
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full border flex items-center">
                            <i class="bi bi-currency-euro mr-1"></i>
                            @if(request('preco_min') && request('preco_max'))
                                {{ request('preco_min') }}€ - {{ request('preco_max') }}€
                            @elseif(request('preco_min'))
                                Min: {{ request('preco_min') }}€
                            @else
                                Max: {{ request('preco_max') }}€
                            @endif
                        </span>
                    @endif
                </div>
            @else
                <h5 class="text-gray-600 text-lg">
                    <i class="bi bi-list-ul mr-2"></i>Mostrando todos os produtos:
                    <span class="text-blue-600 font-bold">{{ $produtos->count() }} produtos</span>
                </h5>
            @endif
        </div>

        <div class="mt-4 lg:mt-0">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 active:bg-gray-200 focus:outline-none" id="grid-view">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </button>
                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-l-0 border-gray-200 rounded-r-lg hover:bg-gray-100 active:bg-gray-200 focus:outline-none" id="list-view">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </div>
</div>

            <!-- Products List Section -->
<div class="container mx-auto px-4 mt-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="products-container">
        @forelse ($produtos as $produto)
        <div class="product-item">
            <div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col">
                <div class="relative">
                    <img src="{{ asset('storage/' . $produto->imagem) }}" 
                         class="w-full h-48 object-cover"
                         alt="{{ $produto->nome }}">
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                            <i class="bi bi-tag-fill mr-1"></i>{{ $produto->marca }}
                        </span>
                    </div>
                    @if($produto->estado)
                    <div class="absolute bottom-2 left-2">
                        <span class="px-2 py-1 text-xs font-semibold 
                            {{ $produto->estado == 'Novo' ? 'bg-green-100 text-green-800' : 
                               ($produto->estado == 'Semi-novo' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-gray-100 text-gray-800') }} rounded-full">
                            {{ $produto->estado }}
                        </span>
                    </div>
                    @endif
                </div>

                <div class="p-4 flex-grow flex flex-col">
                    <div class="flex justify-between items-center mb-2">
                        <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                            <i class="bi bi-collection-fill mr-1"></i>{{ $produto->categoria }}
                        </span>
                        <span class="text-sm text-gray-600">
                            <i class="bi bi-gender-ambiguous mr-1"></i>{{ ucfirst($produto->genero) }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $produto->nome }}</h3>

                    <div class="mb-3">
                        <span class="text-sm text-gray-600">
                            <i class="bi bi-person-fill mr-1"></i>Vendedor: 
                            <strong>{{ $produto->user->name }}</strong>
                        </span>
                    </div>

                    <p class="text-gray-600 text-sm flex-grow mb-4">
                        {{ Str::limit($produto->descricao, 100) }}
                    </p>

                    <div class="flex justify-between items-center mb-4">
                        @if($produto->tamanho)
                        <span class="text-sm text-gray-600">
                            <i class="bi bi-rulers mr-1"></i>Tamanho: {{ $produto->tamanho }}
                        </span>
                        @endif

                        <span class="text-xl font-bold text-blue-600">
                            {{ number_format($produto->preco, 2) }}€
                        </span>
                    </div>

                    <div class="flex justify-between gap-2">
                        <a href="{{ route('produtos.show', $produto->id) }}" 
                           class="flex-1 px-4 py-2 bg-blue-600 text-white text-center font-semibold rounded-md hover:bg-blue-700 transition-colors">
                            Ver Detalhes <i class="bi bi-arrow-right-short ml-1"></i>
                        </a>
                        <button type="button" 
                                class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 transition-colors">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-blue-50 text-center p-8 rounded-lg">
                <i class="bi bi-info-circle text-4xl text-blue-500 mb-4"></i>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Nenhum produto encontrado</h4>
                <p class="text-gray-600 mb-4">Tente ajustar os filtros ou pesquise por outro termo.</p>
                <a href="{{ route('produtos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50">
                    <i class="bi bi-arrow-repeat mr-2"></i>Ver todos os produtos
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

            <!-- Pagination -->
            <div class="container mx-auto px-4 mt-8">
                <div class="flex justify-center">
                    {{ $produtos->links() }}
                </div>
            </div>

        <!-- Scripts -->
        <script>
            function toggleDropdown(id) {
                document.getElementById(id).classList.toggle('hidden');
            }

            // Fechar dropdowns ao clicar fora
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.relative')) {
                    document.getElementById('categoriaDropdown').classList.add('hidden');
                    document.getElementById('corDropdown').classList.add('hidden');
                }
            });

            function updateSelectedCategory(categoria) {
                document.getElementById('selectedCategories').textContent = categoria;
            }

            function updateSelectedColors() {
                const checkboxes = document.querySelectorAll('input[name="cores[]"]:checked');
                const selectedColors = Array.from(checkboxes).map(cb => cb.nextElementSibling.textContent).join(', ');
                document.getElementById('selectedColors').textContent = selectedColors || 'Selecione as cores';
            }

            function updateTamanhoOptions(categoria) {
                const tamanhoContainer = document.getElementById("tamanhoContainer");
                const tamanhoSelect = document.getElementById("tamanho");

                // Limpa as opções anteriores, mantendo apenas a primeira opção
                while (tamanhoSelect.options.length > 1) {
                    tamanhoSelect.remove(1);
                }

                // Mostra o container de tamanhos
                tamanhoContainer.classList.remove('hidden');

                // Adiciona os tamanhos específicos para cada categoria
                if (['Casacos', 'Camisolas', 'Calças e Calções', 'Tops e T-shirts'].includes(categoria)) {
                    const tamanhos = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                    tamanhos.forEach(tamanho => {
                        const option = new Option(tamanho, tamanho);
                        tamanhoSelect.add(option);
                    });
                } else if (categoria === 'Sapatilhas') {
                    // Gera tamanhos de 36 a 46
                    for (let i = 36; i <= 46; i += 0.5) {
                        const option = new Option(i.toString(), i.toString());
                        tamanhoSelect.add(option);
                    }
                } else {
                    // Para outras categorias sem tamanho específico
                    tamanhoContainer.classList.add('hidden');
                }
            }

            // Preview da imagem
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('imagePlaceholder');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
            }
        </script>
    </body>

    </html>
</x-kaira-layout>
