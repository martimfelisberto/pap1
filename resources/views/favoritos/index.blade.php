<x-kaira-layout>
    <div style="max-width: 1280px; margin: 0 auto; padding: 2rem 1rem;">
        <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem;">Meus Favoritos</h1>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
            @forelse ($favoritos as $produto)
                <div style="background-color: #FFF; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column; height: 100%;">
                    <div style="position: relative;">
                        @if($produto->imagem)
                            <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->titulo }}" 
                                style="width: 100%; height: 220px; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 220px; background-color: #EEE; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image" style="font-size: 2.5rem; color: #CCC;"></i>
                            </div>
                        @endif
                        
                        @if($produto->categoria)
                            <span style="position: absolute; top: 0.75rem; left: 0.75rem; background-color: rgba(4, 23, 85, 0.8); color: white; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px;">
                                {{ $produto->categoria->nome }}
                            </span>
                        @endif
                    </div>
                    
                    <div style="padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column;">
                        <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem;">{{ $produto->titulo }}</h3>
                        <p style="color: #6B7280; margin-bottom: 1rem; flex-grow: 1;">{{ Str::limit($produto->descricao, 100) }}</p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                            <span style="font-size: 1.25rem; font-weight: bold; color: #2563EB;">{{ number_format($produto->preco, 2) }}€</span>
                            
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('produtos.show', $produto) }}" 
                                   style="padding: 0.5rem 1rem; background-color: #EEF2FF; color: #4F46E5; border-radius: 8px; text-decoration: none;">
                                    Ver Detalhes
                                </a>
                                
                                <form action="{{ route('favoritos.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                    <button type="submit" 
                                        style="padding: 0.5rem 1rem; background-color: #FEE2E2; color: #DC2626; border: none; border-radius: 8px; cursor: pointer;">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1;">
                    <div style="background-color: #F3F4F6; padding: 3rem; border-radius: 12px; text-align: center;">
                        <i class="bi bi-heart" style="font-size: 3.5rem; color: #9CA3AF; margin-bottom: 1.5rem;"></i>
                        <h3 style="font-size: 1.75rem; margin-bottom: 1rem;">Nenhum favorito encontrado</h3>
                        <p style="color: #6B7280; margin-bottom: 1.5rem;">Você ainda não adicionou nenhum produto aos favoritos.</p>
                        <a href="{{ route('produtos.index') }}" 
                           style="padding: 0.75rem 1.5rem; background-color: rgb(4, 23, 85); color: white; border-radius: 8px; text-decoration: none; display: inline-block;">
                            Explorar Produtos
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div style="margin-top: 2rem;">
            {{ $favoritos->links() }}
        </div>
    </div>
</x-kaira-layout>