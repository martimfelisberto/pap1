<x-kaira-layout>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-0">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i>Painel de Administração
                </h1>
                <p class="text-muted mt-2">Gerencie utilizadores, produtos e categorias da plataforma Reshopping</p>
            </div>
            <!-- ... keep existing back button ... -->
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-4 mb-4">
                <!-- Users Card - keep as is -->
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-warning shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-warning d-inline-flex justify-content-center align-items-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-bag-fill text-white fs-1"></i>
                        </div>
                        <h3 class="fs-2 fw-bold">{{ $produtos->total() }}</h3>
                        <p class="text-muted">Produtos</p>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
                        </div>
                        <div class="mt-3 text-muted small">
                            <span class="text-success">
                                <i class="bi bi-arrow-up"></i> 
                                {{ \App\Models\Produto::where('created_at', '>=', now()->subDays(30))->count() }}
                            </span> 
                            novos nos últimos 30 dias
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Categories Card - keep structure but update text -->
        </div>

        <!-- Tabs Navigation -->
        <div class="list-group shadow-sm sticky-top" style="top: 20px;" id="admin-tabs" role="tablist">
            <a href="#users" class="list-group-item list-group-item-action active">
                <i class="bi bi-people-fill me-2 text-primary"></i>Utilizadores
            </a>
            <a href="#products" class="list-group-item list-group-item-action">
                <i class="bi bi-bag-fill me-2 text-warning"></i>Produtos
            </a>
            <a href="#categories" class="list-group-item list-group-item-action" data-bs-toggle="list" role="tab">
                <i class="bi bi-tags-fill me-2 text-success"></i>Categorias
            </a>
        

            <!-- Products Tab -->
            <div class="tab-pane fade" id="products" role="tabpanel">
                 <div class="card shadow-sm">
                 <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-bag-fill me-2"></i>Gestão de Produtos</h5>
                 </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Preço</th>
                                    <th>Categoria</th>
                                    <th>Estado</th>
                                    <th>Vendedor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produtos as $produto)
                                    <tr>
                                        <td>{{ $produto->id }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                                alt="{{ $produto->nome }}" 
                                                class="img-thumbnail" 
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td>{{ $produto->nome }}</td>
                                        <td>{{ number_format($produto->preco, 2) }}€</td>
                                        <td>{{ $produto->categoria }}</td>
                                        <td>
                                            <span class="badge bg-{{ $produto->vendido ? 'success' : 'warning' }}">
                                                {{ $produto->vendido ? 'Vendido' : 'Disponível' }}
                                            </span>
                                        </td>
                                        <td>{{ $produto->user->name }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('produtos.show', $produto) }}" class="btn btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.produtos.delete', $produto) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" 
                                                            onclick="return confirm('Tem certeza que deseja eliminar este produto?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
            <!-- Users Section -->
        @if($users->isEmpty())
    <div class="text-center py-4">
        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
        <p class="mt-3">Nenhum utilizador encontrado</p>
    </div>
// End of validation errors check

<div class="d-flex justify-content-center mt-3">
    {{ $users->links() }}
</div>

<!-- Products Tab -->
<div class="tab-pane fade" id="products">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-bag-fill me-2"></i>Gestão de Produtos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Categoria</th>
                            <th>Estado</th>
                            <th>Tamanho</th>
                            <th>Vendedor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produtos as $produto)
                            <tr>
                                <td>{{ $produto->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                         alt="{{ $produto->nome }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                </td>
                                <td>{{ $produto->nome }}</td>
                                <td>{{ number_format($produto->preco, 2) }}€</td>
                                <td>{{ $produto->categoria }}</td>
                                <td>
                                    <span class="badge bg-{{ $produto->estado == 'Novo' ? 'success' : 'warning' }}">
                                        {{ $produto->estado }}
                                    </span>
                                </td>
                                <td>{{ $produto->tamanho }}</td>
                                <td>{{ $produto->user->name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('produtos.show', $produto) }}" class="btn btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.produtos.delete', $produto) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('Tem certeza que deseja eliminar este produto?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($produtos->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-bag-x text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-3">Nenhum produto encontrado</p>
                </div>
            @endif
            
            <div class="d-flex justify-content-center mt-3">
                {{ $produtos->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Categories Tab -->
<div class="tab-pane fade" id="categories" role="tabpanel">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-tags-fill me-2"></i>Gestão de Categorias</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 mb-4">
                    <div class="card border-success">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Adicionar Nova Categoria</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('categorias.store') }}" method="POST" id="categoryForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome da Categoria</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                            id="nome" name="nome" required minlength="3"
                                            placeholder="Ex: Camisolas, Calças, Casacos...">
                                    </div>
                                    @error('nome')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-plus-circle me-1"></i>Adicionar Categoria
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="card border-success">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Categorias Existentes</h6>
                            <span class="badge bg-success">{{ $categorias->total() }} categorias</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Produtos</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorias as $categoria)
                                            <tr>
                                                <td>{{ $categoria->id }}</td>
                                                <td>
                                                    <span class="badge bg-light text-dark p-2">
                                                        <i class="bi bi-tag-fill me-1 text-success"></i>
                                                        {{ $categoria->nome }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ \App\Models\Produto::where('categoria', $categoria->nome)->count() }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.categorias.delete', $categoria) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Tem certeza que deseja eliminar esta categoria? Todos os produtos associados ficarão sem categoria.')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($categorias->isEmpty())
                                <div class="text-center py-4">
                                    <i class="bi bi-tags text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-3">Nenhuma categoria encontrada</p>
                                </div>
                            @endif
                            
                            <div class="d-flex justify-content-center mt-3">
                                {{ $categorias->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addCategoryModalLabel"><i class="bi bi-plus-circle me-2"></i>Nova Categoria</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categorias.store') }}" method="POST" id="modalCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="modal_nome" class="form-label">Nome da Categoria</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" class="form-control" id="modal_nome" name="nome" required minlength="3"
                                    placeholder="Ex: Sobremesas, Vegetariano...">
                            </div>
                            <div class="form-text">O nome deve ter pelo menos 3 caracteres e ser único.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="document.getElementById('modalCategoryForm').submit()">
                        <i class="bi bi-plus-circle me-1"></i>Adicionar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    <i class="bi bi-tag-fill me-2"></i>Nova Categoria de Roupa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categorias.store') }}" method="POST" id="modalCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="modal_nome" class="form-label">Nome da Categoria</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                            <input type="text" class="form-control" id="modal_nome" name="nome" required minlength="3"
                                placeholder="Ex: Camisolas, Calças, Casacos...">
                        </div>
                        <div class="form-text">O nome deve ter pelo menos 3 caracteres e ser único.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="document.getElementById('modalCategoryForm').submit()">
                    <i class="bi bi-plus-circle me-1"></i>Adicionar Categoria
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabLinks = document.querySelectorAll('.list-group-item[data-bs-toggle="list"]');
    const tabContents = document.querySelectorAll('.tab-pane');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('show', 'active'));
            
            this.classList.add('active');
            const target = this.getAttribute('href');
            document.querySelector(target).classList.add('show', 'active');
        });
    });
    
    // Validation errors check
    <?php if(session('errors') && session('errors')->has('nome')): ?>
        if (!document.querySelector('#categories').classList.contains('active')) {
            document.querySelector('a[href="#categories"]').click();
        }
    <?php endif; ?>
    
    // Keep active tab after page reload
    const activeTab = sessionStorage.getItem('activeAdminTab');
    if (activeTab) {
        const tabToActivate = document.querySelector(`a[href="${activeTab}"]`);
        if (tabToActivate) tabToActivate.click();
    }
    
    // Save active tab
    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            const tabId = this.getAttribute('href');
            sessionStorage.setItem('activeAdminTab', tabId);
        });
    });
    
    // Card hover animations
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
});
</script>

<style>
/* Custom styling for the admin dashboard */
.list-group-item {
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.list-group-item.active {
    border-left: 3px rgb(22, 111, 245); /* Warning color for clothing theme */
    background-color: rgba(255, 193, 7, 0.1);
    color: #000;
}

/* Table styling */
.table th {
    font-weight: 600;
    color: #495057;
    text-transform: uppercase;
    font-size: 0.875rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(255, 193, 7, 0.05);
}

/* Card animations */
.card {
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Badge customization */
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background:rgb(22, 111, 245);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgb(22, 111, 245);
}
</style>
</x-kaira-layout>