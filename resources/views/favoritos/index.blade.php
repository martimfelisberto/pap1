<x-kaira-layout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-blue-600">
        <div class="container mx-auto px-4 py-12">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Meus Produtos Favoritos</h1>
                <p class="text-blue-100 text-lg mb-6">A tua coleção pessoal de produtos que você salvou para comprar depois.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('favoritos.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="bi bi-search mr-2"></i>Explorar mais produtos
                    </a>
                    @if($favorites->count() > 0)
                    <button type="button" class="inline-flex items-center px-6 py-3 border border-white text-white rounded-lg hover:bg-blue-700 transition-colors" id="printFavorites">
                        <i class="bi bi-printer mr-2"></i>Imprimir lista
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Favorites Content -->
    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <i class="bi bi-check-circle-fill mr-2"></i>{{ session('success') }}
            <button type="button" class="absolute top-0 right-0 px-4 py-3" data-dismiss="alert">
                <span class="sr-only">Close</span>
                <i class="bi bi-x"></i>
            </button>
        </div>
        @endif

        @if($favorites->count() > 0)
            <!-- Filtros e Ordenação -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="relative">
                    <input type="text" class="w-full px-4 py-2 border rounded-lg" id="searchFavorites" 
                           placeholder="Buscar nos seus favoritos...">
                    <button class="absolute right-2 top-2 text-gray-400">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <div class="flex justify-end">
                    <select class="px-4 py-2 border rounded-lg" id="sortFavorites">
                        <option value="recent">Mais recentes</option>
                        <option value="name">Nome (A-Z)</option>
                        <option value="price_low">Menor preço</option>
                        <option value="price_high">Maior preço</option>
                    </select>
                </div>
            </div>

            <!-- Grid de Produtos Favoritos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="favoritesGrid">
                @foreach ($favorites as $produto)
                <div class="favorite-item bg-white rounded-lg shadow-md overflow-hidden" 
                     data-name="{{ strtolower($produto->nome) }}"
                     data-price="{{ $produto->preco }}">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $produto->imagem) }}" 
                             class="w-full h-48 object-cover"
                             alt="{{ $produto->nome }}">
                        
                        <!-- Overlay com ações rápidas -->
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 p-4">
                            <div class="flex justify-between">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    <i class="bi bi-tag-fill mr-1"></i>{{ $produto->marca }}
                                </span>
                                <form action="{{ route('produtos.favorite', $produto->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-gray-900/50 rounded-full text-sm">
                                        {{ $produto->estado }}
                                    </span>
                                    <span class="px-2 py-1 bg-gray-900/50 rounded-full text-sm">
                                        {{ ucfirst($produto->genero) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $produto->nome }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($produto->descricao, 100) }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">
                                <i class="bi bi-person-circle mr-1"></i>{{ $produto->user->name }}
                            </span>
                            <span class="text-xl font-bold text-blue-600">
                                {{ number_format($produto->preco, 2) }}€
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('produtos.show', $produto->id) }}" 
                               class="flex-1 px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 mr-2">
                                Ver Detalhes
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" @click="open = !open">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10" 
                                     x-show="open" @click.away="open = false">
                                    <a href="{{ route('produtos.show', $produto->id) }}" 
                                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="bi bi-eye mr-2"></i>Ver produto
                                    </a>
                                    <form action="{{ route('produtos.favorite', $produto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                            <i class="bi bi-heart-fill mr-2"></i>Remover dos favoritos
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-gray-50 rounded-lg p-8 max-w-2xl mx-auto">
                    <i class="bi bi-heart text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum produto favorito</h3>
                    <p class="text-gray-600 mb-6">Você ainda não adicionou nenhum produto aos seus favoritos.</p>
                    <a href="{{ route('produtos.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="bi bi-search mr-2"></i>Explorar produtos
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Existing content... -->

<!-- Paginação -->
<div class="mt-8 flex justify-center">
    {{ $favorites->links('pagination::tailwind') }}
</div>

@else
<!-- Estado vazio -->
<div class="text-center py-12">
    <div class="bg-gray-50 rounded-lg p-8 max-w-2xl mx-auto">
        <i class="bi bi-heart text-4xl text-gray-400 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum produto favorito</h3>
        <p class="text-gray-600 mb-6">
            Explore nossa coleção de produtos e salve seus favoritos para acessá-los facilmente depois.
        </p>
        <a href="{{ route('produtos.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="bi bi-search mr-2"></i>Explorar produtos
        </a>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Busca em tempo real
    const searchInput = document.getElementById('searchFavorites');
    const favoritesGrid = document.getElementById('favoritesGrid');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterFavorites);
    }
    
    // Ordenação de favoritos
    const sortSelect = document.getElementById('sortFavorites');
    if (sortSelect) {
        sortSelect.addEventListener('change', sortFavorites);
    }
    
    // Impressão da lista de favoritos
    const printBtn = document.getElementById('printFavorites');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            window.print();
        });
    }
    
    // Animação de remoção de favoritos
    document.querySelectorAll('form[action*="favorite"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const favoriteItem = this.closest('.favorite-item');
            favoriteItem.classList.add('opacity-0', 'transform', 'scale-95', 'transition-all');
            
            setTimeout(() => {
                this.submit();
            }, 300);
        });
    });
    
    // Função para filtrar favoritos
    function filterFavorites() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const favoriteItems = document.querySelectorAll('.favorite-item');
        
        favoriteItems.forEach(item => {
            const productName = item.dataset.name;
            if (productName.includes(searchTerm)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
        
        // Mostrar mensagem se nenhum resultado for encontrado
        const noResultsMsg = document.getElementById('noResultsMsg');
        const visibleItems = document.querySelectorAll('.favorite-item:not(.hidden)').length;
        
        if (visibleItems === 0 && searchTerm !== '') {
            if (!noResultsMsg) {
                const msg = document.createElement('div');
                msg.id = 'noResultsMsg';
                msg.className = 'col-span-full text-center py-8';
                msg.innerHTML = `
                    <p class="text-gray-500 mb-4">Nenhum produto encontrado para "${searchTerm}"</p>
                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            onclick="document.getElementById('searchFavorites').value = ''; filterFavorites();">
                        <i class="bi bi-x-circle mr-2"></i>Limpar busca
                    </button>
                `;
                favoritesGrid.appendChild(msg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
    
    // Função para ordenar favoritos
    function sortFavorites() {
        const sortBy = sortSelect.value;
        const items = Array.from(document.querySelectorAll('.favorite-item'));
        
        items.sort((a, b) => {
            switch (sortBy) {
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'price_low':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'price_high':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                default: // recent
                    return 0;
            }
        });
        
        // Reordenar itens com animação
        items.forEach((item, index) => {
            item.classList.add('opacity-0', 'transform', 'translate-y-4');
            favoritesGrid.appendChild(item);
            
            setTimeout(() => {
                item.classList.remove('opacity-0', 'transform', 'translate-y-4');
                item.classList.add('transition-all', 'duration-300');
            }, 50 * index);
        });
    }
    
    // Compartilhamento de produtos
    window.shareProduto = function(nome, url) {
        if (navigator.share) {
            navigator.share({
                title: nome,
                url: url
            }).catch(console.error);
        } else {
            // Fallback: copiar link
            navigator.clipboard.writeText(url).then(() => {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300';
                toast.innerHTML = '<i class="bi bi-check-circle mr-2"></i>Link copiado!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 2000);
            });
        }
    };
    
    // Animação inicial dos cards
    const favoriteItems = document.querySelectorAll('.favorite-item');
    favoriteItems.forEach((item, index) => {
        item.classList.add('opacity-0', 'transform', 'translate-y-4');
        
        setTimeout(() => {
            item.classList.remove('opacity-0', 'transform', 'translate-y-4');
            item.classList.add('transition-all', 'duration-500');
        }, 100 * index);
    });
});
</script>

<style>
@media print {
    .no-print {
        display: none;
    }
    .favorite-item {
        break-inside: avoid;
        page-break-inside: avoid;
    }
}
</style>
@endpush
    
</x-kaira-layout>
