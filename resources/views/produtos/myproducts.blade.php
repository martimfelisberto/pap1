<x-kaira-layout>
    <div style="padding: 2rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 1rem;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #333; margin-bottom: 1rem;">Meus Produtos</h1>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                @forelse ($produtos as $produto)
                    <div style="background-color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column; height: 100%;">
                        <!-- Imagem do Produto -->
                        <div style="position: relative;">
                            <img src="{{ asset('storage/' . $produto->imagem) }}"
                                style="width: 100%; height: 200px; object-fit: cover;"
                                alt="{{ $produto->nome }}">
                        </div>

                        <!-- Informações do Produto -->
                        <div style="padding: 1rem; display: flex; flex-direction: column; flex-grow: 1;">
                            <h3 style="font-size: 1.125rem; font-weight: bold; color: #333; margin-bottom: 0.5rem;">{{ $produto->nome }}</h3>
                            <p style="font-size: 0.875rem; color: #6B7280; margin-bottom: 0.5rem; flex-grow: 1;">{{ Str::limit($produto->descricao, 100) }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 1.25rem; font-weight: bold; color: #2563EB;">{{ number_format($produto->preco, 2) }}€</span>
                                <div>
                                    <a href="{{ route('produtos.edit', $produto) }}" style="padding: 0.25rem 0.5rem; background-color: rgb(4, 23, 85); color: white; text-decoration: none; border-radius: 4px; font-size: 0.875rem; margin-right: 0.5rem;">Editar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; font-size: 1.25rem; color: #6B7280; grid-column: 1 / -1;">Você ainda não publicou nenhum produto.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-kaira-layout>
