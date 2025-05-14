<x-kaira-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ ucfirst($categoria) }} {{ ucfirst($genero) }}
            </h1>
            <p class="text-gray-600">
                Explore nossa coleção de {{ $categoria }} para {{ $genero }}
            </p>
        </div>
 <!-- Filters -->
 <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('produtos.categoria', ['categoria' => $categoria, 'genero' => $genero]) }}" 
              class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            
            <!-- Price Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Preço</label>
                <div class="mt-1 flex gap-2">
                    <input type="number" name="preco_min" placeholder="Min" 
                           class="w-full rounded-xl border-gray-300" 
                           value="{{ request('preco_min') }}">
                    <input type="number" name="preco_max" placeholder="Max" 
                           class="w-full rounded-xl border-gray-300" 
                           value="{{ request('preco_max') }}">
                </div>
            </div>

            <!-- Brand Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Marca</label>
                <select name="marca" class="mt-1 w-full rounded-xl border-gray-300">
                    <option value="">Todas as marcas</option>
                    @foreach($marcas as $marca)
                        <option value="{{ $marca }}" {{ request('marca') == $marca ? 'selected' : '' }}>
                            {{ $marca }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Condition Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="estado" class="mt-1 w-full rounded-xl border-gray-300">
                    <option value="">Todos os estados</option>
                    <option value="novo" {{ request('estado') == 'novo' ? 'selected' : '' }}>Novo</option>
                    <option value="usado" {{ request('estado') == 'usado' ? 'selected' : '' }}>Usado</option>
                    <option value="semi-novo" {{ request('estado') == 'semi-novo' ? 'selected' : '' }}>Semi-novo</option>
                </select>
            </div>

            <!-- Size Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tamanho</label>
                <select name="tamanho" class="mt-1 w-full rounded-xl border-gray-300">
                    <option value="">Todos os tamanhos</option>
                    @if($categoria === 'sapatilhas')
                        @for($i = 35; $i <= 46; $i++)
                            <option value="{{ $i }}" {{ request('tamanho') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    @else
                        @foreach(['XS', 'S', 'M', 'L', 'XL'] as $tamanho)
                            <option value="{{ $tamanho }}" {{ request('tamanho') == $tamanho ? 'selected' : '' }}>
                                {{ $tamanho }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Apply Filters Button -->
            <div class="md:col-span-3 lg:col-span-4 flex justify-end mt-4">
                <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 text-sm rounded-xl hover:bg-blue-700 transition-colors duration-200">
                    <i class="bi bi-funnel mr-2"></i>Aplicar Filtros
                </button>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($produtos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($produtos as $produto)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <img src="{{ asset('storage/' . $produto->imagem) }}" 
                         alt="{{ $produto->nome }}"
                         class="w-full h-48 object-cover">
                    
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $produto->nome }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $produto->marca }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-600 font-bold">{{ number_format($produto->preco, 2) }}€</span>
                            <span class="text-sm text-gray-500">{{ ucfirst($produto->estado) }}</span>
                        </div>
                        
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('produtos.show', $produto) }}" 
                               class="flex-1 bg-blue-600 text-white text-center py-2 rounded-xl hover:bg-blue-700 transition-colors duration-200">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $produtos->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
            <div class="text-gray-500">
                <i class="bi bi-box text-4xl mb-4"></i>
                <p class="text-xl">Nenhum produto encontrado</p>
                <p class="text-sm mt-2">Tente ajustar os filtros ou volte mais tarde</p>
            </div>
        </div>
    @endif
    </div>
</x-kaira-layout>