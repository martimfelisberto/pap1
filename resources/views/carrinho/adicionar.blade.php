<form action="{{ route('carrinho.adicionar') }}" method="POST" class="d-inline" id="addToCartForm">
    @csrf
    <input type="hidden" name="id" value="{{ $produtoId }}">
    <button type="submit" class="btn btn-success btn-sm" title="Adicionar ao carrinho">
        <i class="bi bi-cart-plus"></i> Adicionar
    </button>
</form>

<script>
document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            updateCartUI(data.cart);
            // Abre o offcanvas do carrinho
            const offcanvasCart = new bootstrap.Offcanvas(document.getElementById('offcanvasCart'));
            offcanvasCart.show();
        }
    })
    .catch(error => console.error('Error:', error));
});

function updateCartUI(cartData) {
    const cartItems = document.getElementById('cartItems');
    const cartCounter = document.getElementById('cartCounter');
    const cartTotal = document.getElementById('cartTotal');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const checkoutBtn = document.getElementById('checkoutBtn');

    // Limpa os itens existentes
    cartItems.innerHTML = '';
    
    if (cartData.items && Object.keys(cartData.items).length > 0) {
        // Esconde a mensagem de carrinho vazio
        if (emptyCartMessage) emptyCartMessage.style.display = 'none';
        
        // Adiciona cada item ao carrinho
        for (const [id, item] of Object.entries(cartData.items)) {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between lh-sm';
            li.innerHTML = `
                <div>
                    <h6 class="my-0">${item.nome}</h6>
                    <small class="text-muted">${item.quantidade} x €${item.preco.toFixed(2)}</small>
                </div>
                <span class="text-muted">€${(item.preco * item.quantidade).toFixed(2)}</span>
            `;
            cartItems.appendChild(li);
        }

        // Atualiza contador e total
        const totalItems = Object.values(cartData.items).reduce((total, item) => total + item.quantidade, 0);
        cartCounter.textContent = totalItems;
        cartTotal.textContent = `€${cartData.total.toFixed(2)}`;
        checkoutBtn.disabled = false;
    } else {
        // Mostra mensagem de carrinho vazio
        if (emptyCartMessage) emptyCartMessage.style.display = 'block';
        cartCounter.textContent = '0';
        cartTotal.textContent = '€0.00';
        checkoutBtn.disabled = true;
    }
}


</script>