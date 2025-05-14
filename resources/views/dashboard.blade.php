<x-kaira-layout>
    <div style="padding: 2rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; font-weight: bold; color: #333; margin: 0;">Dashboard Administrativo</h2>
            </div>

            <!-- Stats Cards -->
            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Utilizadores -->
                <div style="flex: 1 1 300px;">
                    <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem;">
                        <h5 style="font-size: 1.25rem; font-weight: 600; color: #333; margin-bottom: 1rem;">Utilizadores</h5>
                        <p style="font-size: 2rem; font-weight: bold; margin: 1rem 0;">{{ $stats['users'] }}</p>
                        <a href="{{ route('users.index') }}" 
                           style="display: inline-block; padding: 0.5rem 1rem; background-color: rgb(36, 104, 250); color: #FFF; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                            Gerir Utilizadores
                        </a>
                    </div>
                </div>

                <!-- Categorias -->
                <div style="flex: 1 1 300px;">
                    <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem;">
                        <h5 style="font-size: 1.25rem; font-weight: 600; color: #333; margin-bottom: 1rem;">Categorias</h5>
                        <p style="font-size: 2rem; font-weight: bold; margin: 1rem 0;">{{ $stats['categorias'] }}</p>
                        <a href="{{ route('categorias.index') }}" 
                           style="display: inline-block; padding: 0.5rem 1rem; background-color: rgb(36, 104, 250); color: #FFF; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                            Gerir Categorias
                        </a>
                    </div>
                </div>

                <!-- Produtos -->
                <div style="flex: 1 1 300px;">
                    <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem;">
                        <h5 style="font-size: 1.25rem; font-weight: 600; color: #333; margin-bottom: 1rem;">Produtos</h5>
                        <p style="font-size: 2rem; font-weight: bold; margin: 1rem 0;">{{ $stats['produtos'] }}</p>
                        <a href="{{ route('produtos.index') }}" 
                           style="display: inline-block; padding: 0.5rem 1rem; background-color: rgb(36, 104, 250); color: #FFF; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                            Gerir Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-kaira-layout>
