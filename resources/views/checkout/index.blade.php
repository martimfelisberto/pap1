<x-kaira-layout>
    <div style="max-width: 800px; margin: 2rem auto; padding: 1.5rem; background-color: #FFF; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #333; margin-bottom: 1rem;">Checkout</h2>
        <form action="{{ route('checkout.process', ['produto' => $produto->id]) }}" method="POST">
            @csrf
            <!-- Nome Completo -->
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.875rem; color: #333;">Nome Completo</label>
                <input type="text" name="nome_completo" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <!-- Morada -->
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.875rem; color: #333;">Morada</label>
                <input type="text" name="morada" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <!-- Localidade -->
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.875rem; color: #333;">Localidade</label>
                <input type="text" name="localidade" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <!-- Cidade -->
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.875rem; color: #333;">Cidade</label>
                <input type="text" name="cidade" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <!-- Código Postal -->
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.875rem; color: #333;">Código Postal</label>
                <input type="text" name="codigo_postal" required
                    pattern="\d{4}-\d{3}"
                    title="O código postal deve estar no formato xxxx-xxx (exemplo: 1234-567)"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <!-- Número de Telefone -->
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.875rem; color: #333;">Número de Telefone</label>
                <input type="text" name="telefone" required
                    pattern="\+351-\d{9}"
                    title="O número de telefone deve estar no formato +351-xxxxxxxxx (exemplo: +351-912345678)"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <!-- Método de Pagamento -->
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.875rem; color: #333;">Método de Pagamento</label>
                <select name="metodo_pagamento" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
                    <option value="cartao_credito">Cartão de Crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="mbway">MB WAY</option>
                </select>
            </div>
            <!-- Botão de Finalizar -->
            <div style="text-align: right;">
                <button type="submit"
                    style="padding: 0.75rem 1.5rem; background-color: #34D399; color: #FFF; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
                    Finalizar Compra
                </button>
            </div>
        </form>
    </div>
</x-kaira-layout>