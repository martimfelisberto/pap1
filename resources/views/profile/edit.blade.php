<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h1 class="text-2xl font-bold leading-tight text-white mb-2 md:mb-0">
                <i class="bi bi-person-circle me-2"></i>{{ __('Meu Perfil') }}
            </h1>
            <a href="/"
                class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="bi bi-house-door me-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Alerts Section -->
            @if(session('status'))
            <div class="mb-6 overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="p-4 text-green-700 bg-green-100 border-l-4 border-green-500" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Profile Overview Card -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center space-x-5">
                            <!-- Avatar with Upload Option -->
                            <div class="relative group">
                                <div class="flex items-center justify-center w-24 h-24 text-2xl text-white bg-warning rounded-full overflow-hidden border-4 border-white shadow-md">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile"
                                            class="h-full w-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <label for="profile_photo_upload" class="absolute bottom-0 right-0 flex items-center justify-center w-8 h-8 bg-warning rounded-full cursor-pointer shadow-md hover:bg-warning-dark transition-colors">
                                    <i class="bi bi-camera text-white"></i>
                                    <input id="profile_photo_upload" type="file" class="hidden" form="update-profile-form" name="profile_photo">
                                </label>
                            </div>

                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                                <div class="flex flex-col sm:flex-row sm:items-center text-sm text-gray-600 mt-1 space-y-1 sm:space-y-0 sm:space-x-4">
                                    <p><i class="bi bi-envelope-fill mr-1"></i> {{ Auth::user()->email }}</p>
                                    <p><i class="bi bi-calendar3 mr-1"></i> Membro desde {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="mt-2 flex items-center space-x-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning text-white">
                                        <i class="bi bi-bag mr-1"></i> 
                                        {{ Auth::user()->produtos()->count() }} produtos
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="bi bi-heart-fill mr-1"></i> 
                                        {{ Auth::user()->favoriteProdutos()->count() }} favoritos
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="bi bi-star-fill mr-1"></i> 
                                        {{ Auth::user()->vendas()->count() }} vendas
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                            <a href="{{ route('produtos.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-warning rounded-md hover:bg-warning-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning transition-colors">
                                <i class="bi bi-plus-lg mr-2"></i> Vender Produto
                            </a>
                            <a href="{{ route('profile.show', Auth::id()) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning transition-colors">
                                <i class="bi bi-person-badge mr-2"></i> Ver Perfil Público
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <button class="tab-button active w-1/3 py-4 px-1 text-center border-b-2 border-warning font-medium text-sm text-warning" data-target="profile-info">
                            <i class="bi bi-person-fill mr-2"></i>Informações do Perfil
                        </button>
                        <button class="tab-button w-1/3 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="security">
                            <i class="bi bi-shield-lock-fill mr-2"></i>Segurança
                        </button>
                        <button class="tab-button w-1/3 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="danger-zone">
                            <i class="bi bi-exclamation-triangle-fill mr-2"></i>Zona de Perigo
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Profile Information Tab -->
                    <div id="profile-info" class="tab-content">
                        <div class="max-w-xl">
                            <h3 class="text-lg font-bold text-warning mb-4">
                                <i class="bi bi-person-fill mr-2"></i>Informações do Perfil
                            </h3>
                            <p class="text-sm text-gray-600 mb-6">
                                Atualiza as informações do perfil e do teu endereço de e-mail.
                            </p>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div id="security" class="tab-content hidden">
                        <div class="max-w-xl">
                            <h3 class="text-lg font-bold text-warning mb-4">
                                <i class="bi bi-shield-lock-fill mr-2"></i>Segurança
                            </h3>
                            <p class="text-sm text-gray-600 mb-6">
                                Atualiza a tua senha para manteres a tua conta segura.
                            </p>
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Danger Zone Tab -->
                    <div id="danger-zone" class="tab-content hidden">
                        <div class="max-w-xl">
                            <h3 class="text-lg font-bold text-red-600 mb-4">
                                <i class="bi bi-exclamation-triangle-fill mr-2"></i>Zona de Perigo
                            </h3>
                            <p class="text-sm text-gray-600 mb-6">
                                Uma vez que a tua conta é excluída, todos os teus recursos e dados são apagados permanentemente.
                            </p>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produtos Favoritos -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-warning">
                        <i class="bi bi-heart-fill mr-2"></i>Produtos Favoritos
                    </h3>
                    @if ($user->favoriteProdutos->count() > 6)
                    <a href="{{ route('profile.favorites', $user->id) }}" class="text-sm text-warning hover:text-warning-dark">
                        Ver todos <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                    @endif
                </div>

                @if ($user->favoriteProdutos->count() > 0)
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($user->favoriteProdutos()->latest()->take(6)->get() as $produto)
                            <div class="overflow-hidden transition-all duration-300 bg-white border rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-1">
                                <div class="relative">
                                    @if ($produto->imagem)
                                        <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}"
                                            class="object-cover w-full h-48">
                                    @else
                                        <div class="flex items-center justify-center w-full h-48 bg-gray-200">
                                            <span class="text-gray-400"><i class="bi bi-image"></i> Sem imagem</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-warning bg-opacity-90 rounded">
                                            {{ $produto->preco }}€
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h4 class="mb-1 text-lg font-semibold text-gray-900 line-clamp-1">{{ $produto->nome }}</h4>
                                    <p class="mb-2 text-sm text-gray-600">
                                        <i class="bi bi-tag-fill"></i> {{ $produto->categoria->nome }}
                                        <span class="mx-1">•</span>
                                        <i class="bi bi-rulers"></i> {{ $produto->tamanho }}
                                    </p>

                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('produtos.show', $produto->id) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs text-white bg-warning rounded hover:bg-warning-dark transition-colors">
                                            <i class="bi bi-eye mr-1"></i> Ver Produto
                                        </a>
                                        
                                        <form action="{{ route('produtos.favorite', $produto->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center text-red-500 hover:text-red-700">
                                                <i class="bi bi-heart-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center bg-gray-50 rounded-lg border border-gray-100">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-warning-light text-warning mb-4">
                            <i class="bi bi-heart text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto favorito</h4>
                        <p class="text-gray-600 mb-4">Você ainda não adicionou nenhum produto aos seus favoritos.</p>
                        <a href="{{ route('favoritos.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-warning rounded-md hover:bg-warning-dark transition-colors">
                            <i class="bi bi-search mr-2"></i> Explorar Produtos
                        </a>
                    </div>
                @endif
            </div>

            <!-- Meus Produtos -->
            <div class="mt-8 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-warning">
                        <i class="bi bi-bag mr-2"></i>Os meus Produtos
                    </h3>
                    @if ($user->produtos->count() > 3)
                    <a href="{{ route('profile.show', $user->id) }}" class="text-sm text-warning hover:text-warning-dark">
                        Ver todos <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                    @endif
                </div>

                @if ($user->produtos->count() > 0)
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($user->produtos()->latest()->take(3)->get() as $produto)
                            <div class="overflow-hidden transition-all duration-300 bg-white border rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-1">
                                <!-- Product Card Content -->
                                <!-- Similar to the favorite products card but with edit/delete options -->
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center bg-gray-50 rounded-lg border border-gray-100">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-warning-light text-warning mb-4">
                            <i class="bi bi-bag-plus text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto publicado</h4>
                        <p class="text-gray-600 mb-4">Você ainda não publicou nenhum produto para venda.</p>
                        <a href="{{ route('produtos.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-warning rounded-md hover:bg-warning-dark transition-colors">
                            <i class="bi bi-plus-lg mr-2"></i> Vender Produto
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            // ...existing tab code...

            // Profile photo preview
            // ...existing photo preview code...

            // Animation for cards
            // ...existing animation code...
        });
    </script>
    @endpush
</x-app-layout>