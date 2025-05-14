
<x-kaira-layout>
    <div class="container mt-4">
        <h2>{{ ucfirst($categoria) }} para {{ ucfirst($genero) }}</h2>

        <div class="row">
            @forelse($produtos as $produto)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        @if($produto->imagens->first())
                            <img src="{{ asset('storage/' . $produto->imagens->first()->caminho) }}" 
                                 class="card-img-top" 
                                 alt="{{ $produto->nome }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $produto->nome }}</h5>
                            <p class="card-text">
                                <strong>Preço:</strong> €{{ number_format($produto->preco, 2) }}<br>
                                <strong>Marca:</strong> {{ $produto->marca }}<br>
                                <strong>Estado:</strong> {{ ucfirst($produto->estado) }}
                            </p>
                            <a href="{{ route('produtos.show', $produto) }}" 
                               class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Nenhum produto encontrado nesta categoria.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $produtos->links() }}
        </div>
    </div>
</x-kaira-layout>