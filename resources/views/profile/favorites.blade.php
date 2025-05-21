<x-kaira-layout>
    <section class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-warning hover:underline">
                            <i class="bi bi-arrow-left"></i> Voltar ao perfil
                        </a>
                        <h2 class="mt-2 text-2xl font-bold">Produtos Favoritos de {{ $user->name }}</h2>
                    </div>

                    @if($favorites->count() > 0)
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            @foreach($favorites as $produto)
                                <div class="overflow-hidden transition-shadow bg-white border rounded-lg shadow-md hover:shadow-lg">
                                    @if($produto->imagem)
                                        <img src="{{ asset('storage/' . $produto->imagem) }}"
                                             alt="{{ $produto->nome }}"
                                             class="object-cover w-full h-48">
                                    @else
                                        <div class="flex items-center justify-center w-full h-48 bg-gray-200">
                                            <span class="text-gray-400"><i class="bi bi-image"></i> Sem imagem</span>
                                        </div>
                                    @endif

                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="text-lg font-semibold">{{ $produto->nome }}</h4>
                                            <span class="text-lg font-bold text-warning">{{ number_format($produto->preco, 2) }}€</span>
                                        </div>
                                        
                                        <p class="mb-1 text-sm text-gray-600">
                                            Vendedor: <strong>{{ $produto->user->name }}</strong>
                                        </p>
                                        
                                        <div class="mb-3 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                                                <i class="bi bi-tag-fill mr-1"></i> {{ $produto->categoria->nome }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                                                <i class="bi bi-rulers mr-1"></i> {{ $produto->tamanho }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                                                <i class="bi bi-star-fill mr-1"></i> {{ $produto->estado }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center mt-4">
                                            <form action="{{ route('produtos.favorite', $produto) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                    <i class="bi bi-heart-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $favorites->links() }}
                        </div>
                    @else
                        <div class="p-12 text-center bg-gray-50 rounded-lg border border-gray-100">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-warning-light text-warning mb-4">
                                <i class="bi bi-heart text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto favorito</h4>
                            <p class="text-gray-600 mb-4">Este utilizador ainda não adicionou nenhum produto aos favoritos.</p>
                            <a href="{{ route('favoritos.index') }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-warning rounded-md hover:bg-warning-dark transition-colors">
                                <i class="bi bi-search mr-2"></i> Explorar Produtos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>