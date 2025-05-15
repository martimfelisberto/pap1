<x-kaira-layout>
    <div style="padding: 1.5rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1rem;">
            <!-- Header Section -->
            <div style="margin-bottom: 1.5rem; text-align: center;">
                <h2 style="font-size: 2rem; font-weight: 600; color: #333; margin: 0;">Os meus produtos</h2>
            </div>

            <!-- Botão Novo Produto centralizado -->
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <a href="{{ route('produtos.create') }}" 
                   style="display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem; background-color: #007BFF; border: none; border-radius: 4px; font-weight: 600; font-size: 0.875rem; color: #FFF; text-transform: uppercase; text-decoration: none;">
                    <i class="bi bi-plus-lg" style="margin-right: 0.5rem;"></i>
                    Novo Produto
                </a>
            </div>

            <!-- Products Grid -->
            @if($produtos->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach($produtos as $produto)
                        <div style="background-color: #FFF; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; transition: box-shadow 0.3s;">
                            <!-- Imagem / Placeholder -->
                            <div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
                                @if($produto->imagem)
                                    @php
                                        $imagens = json_decode($produto->imagem);
                                        $primeira_imagem = is_array($imagens) ? $imagens[0] : $produto->imagem;
                                    @endphp
                                    <img src="{{ asset('storage/' . $primeira_imagem) }}" 
                                         alt="{{ $produto->nome }}"
                                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="display: flex; align-items: center; justify-content: center; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #F3F4F6;">
                                        <i class="bi bi-image" style="color: #9CA3AF; font-size: 2rem;"></i>
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <div style="position: absolute; top: 8px; right: 8px;">
                                    <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: 600; border-radius: 999px; background-color: {{ $produto->disponivel ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $produto->disponivel ? '#065F46' : '#991B1B' }};">
                                        {{ $produto->disponivel ? 'Disponível' : 'Vendido' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Informações do Produto -->
                            <div style="padding: 1rem;">
                                <!-- Título e Preço -->
                                <div style="margin-bottom: 1rem;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #333; margin: 0 0 0.5rem 0;">
                                        {{ $produto->nome }}
                                    </h3>
                                    <p style="font-size: 1.25rem; font-weight: bold; color: #007BFF; margin: 0;">
                                        {{ number_format($produto->preco, 2) }}€
                                    </p>
                                </div>

                                <!-- Detalhes -->
                                <div style="font-size: 0.875rem; color: #6B7280; line-height: 1.5;">
                                    <p style="margin: 0;"><span style="font-weight: 600;">Marca:</span> {{ $produto->marca }}</p>
                                    <p style="margin: 0;"><span style="font-weight: 600;">Categoria:</span> {{ $produto->categoria->nome }}</p>
                                    <p style="margin: 0;"><span style="font-weight: 600;">Estado:</span> {{ $produto->estado }}</p>
                                    @if($produto->tamanho)
                                        <p style="margin: 0;"><span style="font-weight: 600;">Tamanho:</span> {{ $produto->tamanho }}</p>
                                    @endif
                                    @if($produto->cores)
                                        <p style="margin: 0;"><span style="font-weight: 600;">Cores:</span> {{ $produto->cores }}</p>
                                    @endif
                                </div>

                                <!-- Estatísticas -->
                                <div style="margin-top: 1rem; display: flex; justify-content: space-between; font-size: 0.875rem; color: #6B7280;">
                                    <div style="display: flex; align-items: center;">
                                        <i class="bi bi-eye" style="margin-right: 0.25rem;"></i>
                                        {{ $produto->visualizacoes }} visualizações
                                    </div>
                                    <div style="display: flex; align-items: center;">
                                        <i class="bi bi-heart" style="margin-right: 0.25rem;"></i>
                                        {{ $produto->favoritos()->count() }} favoritos
                                    </div>
                                </div>

                                <!-- Ações -->
                                <div style="margin-top: 1rem; display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <a href="{{ route('produtos.edit', $produto) }}"
                                       style="padding: 0.25rem 0.75rem; font-size: 0.875rem; color: #007BFF; text-decoration: none;">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" style="display: inline;"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                style="padding: 0.25rem 0.75rem; font-size: 0.875rem; color: #DC2626; background: none; border: none; cursor: pointer;">
                                            <i class="bi bi-trash"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div style="margin-top: 1.5rem;">
                    {{ $produtos->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <i class="bi bi-bag-x" style="color: #9CA3AF; font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p style="color: #6B7280; font-size: 1.125rem;">Você ainda não tem nenhum produto.</p>
                </div>
            @endif
        </div>
    </div>
</x-kaira-layout>
