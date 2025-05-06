<x-kaira-layout>

    <div class="container py-5">
        <h4 class="mb-4">O teu Carrinho de Compras</h4>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(count($carrinho) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Preço Unitário</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th>Eliminar</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrinho as $id => $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item['imagem'])
                                            <img src="{{ asset('storage/' . $item['imagem']) }}" 
                                                 alt="{{ $item['nome'] }}" 
                                                 class="img-thumbnail me-3" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h5 class="mb-1">{{ $item['nome'] }}</h5>
                                            @if($item['marca'])
                                                <small class="text-muted">Marca: {{ $item['marca'] }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">EUR€ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                                <td class="align-middle">
                                    <form action="{{ route('carrinho.atualizar', $id) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" 
                                               name="quantidade" 
                                               value="{{ $item['quantidade'] }}" 
                                               min="1" 
                                               class="form-control form-control-sm" 
                                               style="width: 70px;"
                                               onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="align-middle">EUR€ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                                <td class="align-middle">
                                    <form action="{{ route('carrinho.remover', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Remover do carrinho">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-group-divider">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td colspan="2" class="fw-bold">EUR€ {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Continuar a comprar
                </a>
                
                <div>
                    <form action="{{ route('carrinho.limpar') }}" method="POST" class="d-inline me-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-cart-x"></i> Limpar Carrinho
                        </button>
                    </form>
                    
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> O teu carrinho está vazio.
                <a href="http://reshopping2-main.test/" class="alert-link">Voltar às compras</a>.
            </div>
        @endif
    </div>
</x-kaira-layout>
