<x-kaira-layout>
    <div class="container py-5" style="max-width: 1280px; margin: 0 auto;">
        <h4 class="mb-4" style="font-size: 1.75rem; font-weight: 600; color: #333;">Finalizar Compra</h4>

        <div class="table-responsive" style="background-color: #F9FAFB; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
            <table class="table table-hover" style="width: 100%; border-collapse: collapse;">
                <thead class="table-light" style="background-color: #F3F4F6; text-align: left;">
                    <tr>
                        <th style="padding: 0.75rem;">Produto</th>
                        <th style="padding: 0.75rem;">Preço Unitário</th>
                        <th style="padding: 0.75rem;">Quantidade</th>
                        <th style="padding: 0.75rem;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrinho as $item)
                    <tr>
                        <td style="padding: 0.75rem;">{{ $item['nome'] }}</td>
                        <td style="padding: 0.75rem;">EUR€ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                        <td style="padding: 0.75rem;">{{ $item['quantidade'] }}</td>
                        <td style="padding: 0.75rem;">EUR€ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold" style="padding: 0.75rem;">Total:</td>
                        <td style="padding: 0.75rem;">EUR€ {{ number_format($total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Botão para exibir o formulário -->
        <div class="mt-4 text-center">
            <button id="toggleFormButton" class="btn" style="padding: 0.5rem 1rem; border-radius: 4px; background-color: rgb(4, 23, 85); color: #FFF; font-size: 1rem; border: none;">
                <i class="bi bi-pencil"></i> Preencher Dados de Entrega
            </button>
        </div>

        <!-- Formulário de entrega (inicialmente oculto) -->
        <div id="deliveryForm" class="mt-4" style="display: none;">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nome_completo" class="form-label">Nome Completo</label>
                    <input type="text" name="nome_completo" id="nome_completo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="morada" class="form-label">Morada</label>
                    <input type="text" name="morada" id="morada" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="localidade" class="form-label">Localidade</label>
                    <input type="text" name="localidade" id="localidade" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="codigo_postal" class="form-label">Código Postal</label>
                    <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" required pattern="[0-9]{4}-[0-9]{3}">
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="form-control" required pattern="\+351-[0-9]{9}">
                </div>
                <div class="mb-3">
                    <label for="metodo_pagamento" class="form-label">Método de Pagamento</label>
                    <select name="metodo_pagamento" id="metodo_pagamento" class="form-control" required>
                        <option value="cartao_credito">Cartão de Crédito</option>
                        <option value="paypal">PayPal</option>
                        <option value="mbway">MB Way</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" style="padding: 0.5rem 1rem; background-color:rgb(4, 23, 85); border-radius: 4px;">
                    <i class="bi bi-credit-card"></i> Confirmar Compra
                </button>
            </form>
        </div>
    </div>

    <!-- Script para alternar a visibilidade do formulário -->
    <script>
        document.getElementById('toggleFormButton').addEventListener('click', function () {
            const form = document.getElementById('deliveryForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</x-kaira-layout>