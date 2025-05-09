<x-kaira-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard Administrativo</h2>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Utilizadores</h5>
                        <p class="display-6">{{ $stats['users'] }}</p>
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">
                            Gerir Utilizadores
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Categorias</h5>
                        <p class="display-6">{{ $stats['categories'] }}</p>
                        <a href="{{ route('admin.categories') }}" class="btn btn-sm btn-primary">
                            Gerir Categorias
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produtos</h5>
                        <p class="display-6">{{ $stats['products'] }}</p>
                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-primary">
                            Gerir Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-kaira-layout>