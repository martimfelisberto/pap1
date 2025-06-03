<?php
?>
<x-kaira-layout>

    <div class="container py-5" style="max-width: 1280px; margin: 0 auto; padding: 2rem 1rem;">
        <h4 class="mb-4" style="font-size: 1.75rem; font-weight: 600; color: #333;">O teu Carrinho de Compras</h4>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius: 4px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(count($carrinho) > 0)
        <div class="table-responsive" style="background-color: #F9FAFB; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
            <table class="table table-hover" style="width: 100%; border-collapse: collapse;">
                <thead class="table-light" style="background-color: #F3F4F6; text-align: left;">
                    <tr>
                        <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Produto</th>
                        <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Preço Unitário</th>
                        <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Quantidade</th>
                        <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Subtotal</th>
                        <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('carrinho', []) as $id => $item)
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <td style="padding: 0.75rem;">
                            <div style="display: flex; align-items: center;">
                                @if(isset($item['imagem']) && $item['imagem'])
                                    <img src="{{ asset('storage/' . $item['imagem']) }}" alt="{{ $item['nome'] }}" style="width: 80px; height: 80px; object-fit: cover; margin-right: 0.75rem; border-radius: 4px;">
                                @endif
                                <div>
                                    <h5 style="margin: 0 0 0.25rem 0;">{{ $item['nome'] }}</h5>
                                    @if(isset($item['marca']))
                                        <small style="color: #6B7280;">Marca: {{ $item['marca'] }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="padding: 0.75rem;">EUR€ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                        <td style="padding: 0.75rem;">
                            <form action="{{ route('carrinho.atualizar', $id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantidade" value="{{ $item['quantidade'] }}" min="1" 
                                       class="form-control form-control-sm" 
                                       style="width: 70px; display: inline-block;" 
                                       onchange="this.form.submit()">
                            </form>
                        </td>
                        <td style="padding: 0.75rem;">EUR€ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                        <td style="padding: 0.75rem;">
                            <form action="{{ route('carrinho.remover', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" style="padding: 0.25rem 0.5rem; border-radius: 4px;" title="Remover do carrinho">
                                    <i class="bi bi-cart-x"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-group-divider" style="background-color: #F3F4F6;">
                    <tr>
                        <td colspan="3" class="text-end fw-bold" style="padding: 0.75rem;">Total:</td>
                        <td colspan="2" class="fw-bold" style="padding: 0.75rem;">EUR€ {{ number_format($total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary" style="padding: 0.5rem 1rem; color:#FFF; background-color:rgb(4, 23, 85); border-radius: 4px;">
                <i class="bi bi-arrow-left"></i> Continuar a comprar
            </a>

            <div>
                <form action="{{ route('carrinho.limpar') }}" method="POST" class="d-inline me-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" style="padding: 0.5rem 1rem; border-radius: 4px;">
                        <i class="bi bi-cart-x"></i> Limpar Carrinho
                    </button>
                </form>

                <!-- Botão Finalizar Compra -->
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; background-color:rgb(4, 23, 85); border-radius: 4px;">
                    <i class="bi bi-bag-check"></i> Finalizar Compra
                </a>
            </div>
        </div>
        @else
        <div class="alert alert-info" style="margin-bottom: 22rem; border-radius: 4px;">
            <i class="bi bi-info-circle"></i> O teu carrinho está vazio.
            <a href="http://reshoppingpap.test/" class="alert-link">Voltar às compras</a>.
        </div>
        @endif
    </div>
</x-kaira-layout>
