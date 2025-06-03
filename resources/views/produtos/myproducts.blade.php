
<x-kaira-layout>
    <div style="padding: 2rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 1rem;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #333; margin-bottom: 1rem;">Meus Produtos</h1>

            @forelse ($produtos as $produto)
                <div style="background-color: #F9FAFB; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column; margin-bottom: 1rem;">
                    <!-- Imagem do Produto -->
                    <div style="position: relative;">
                        <img src="{{ asset('storage/' . $produto->imagem) }}"
                            style="width: 100%; height: 12rem; object-fit: cover;"
                            alt="{{ $produto->nome }}">
                    </div>

                    <!-- Informações do Produto -->
                    <div style="padding: 1rem;">
                        <h3 style="font-size: 1.125rem; font-weight: bold; color: #333; margin-bottom: 0.5rem;">{{ $produto->nome }}</h3>
                        <p style="font-size: 0.875rem; color: #6B7280; margin-bottom: 0.5rem;">{{ Str::limit($produto->descricao, 100) }}</p>
                        <span style="font-size: 1.25rem; font-weight: bold; color: #2563EB;">{{ number_format($produto->preco, 2) }}€</span>
                    </div>
                </div>
            @empty
                <p style="text-align: center; font-size: 1.25rem; color: #6B7280;">Você ainda não publicou nenhum produto.</p>
            @endforelse
        </div>
    </div>
</x-kaira-layout>
