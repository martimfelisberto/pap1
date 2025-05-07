<x-app-layout>
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center space-x-5">
                            <!-- Avatar with border effect -->
                            <div class="relative">
                                @if($user->profile_photo)
                                    <div class="w-24 h-24 rounded-full border-4 border-warning-light shadow-md overflow-hidden">
                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                             alt="{{ $user->name }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-r from-warning to-warning-dark rounded-full border-4 border-warning-light shadow-md flex items-center justify-center text-white text-3xl font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <!-- Member status badge -->
                                <div class="absolute -bottom-1 -right-1 bg-green-500 text-white text-xs px-2 py-1 rounded-full shadow-md">
                                    <i class="bi bi-check-circle-fill mr-1"></i>Ativo
                                </div>
                            </div>
                            
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                                <div class="flex items-center text-gray-600 text-sm mt-1">
                                    <i class="bi bi-calendar3 mr-1"></i>
                                    <span>Membro desde {{ $user->created_at->format('d/m/Y') }}</span>
                                </div>
                                
                                <!-- User Statistics -->
                                <div class="flex items-center space-x-4 mt-3">
                                    <div class="flex items-center text-gray-700">
                                        <i class="bi bi-bag text-warning mr-1"></i>
                                        <span>{{ $user->produtos->count() }} produtos</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="bi bi-heart-fill text-red-500 mr-1"></i>
                                        <span>{{ $user->favoriteProdutos ? $user->favoriteProdutos->count() : 0 }} favoritos</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="bi bi-cart-check text-green-500 mr-1"></i>
                                        <span>{{ $user->vendas ? $user->vendas->count() : 0 }} vendas</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                            @if(Auth::id() === $user->id)
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-warning focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="bi bi-pencil-square mr-2"></i>Editar Perfil
                                </a>
                                <a href="{{ route('produtos.create') }}" class="inline-flex items-center px-4 py-2 bg-warning border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-warning-dark focus:bg-warning-dark active:bg-warning focus:outline-none focus:ring-2 focus:ring-warning focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="bi bi-plus-lg mr-2"></i>Vender Produto
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- User Bio -->
                    @if(isset($user->bio) && !empty($user->bio))
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Sobre mim</h3>
                            <p class="text-gray-700">{{ $user->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <button class="tab-button w-1/3 py-4 px-1 text-center border-b-2 border-warning font-medium text-sm text-warning active" data-target="products-tab">
                            <i class="bi bi-bag mr-2"></i>Produtos
                            <span class="bg-gray-100 text-gray-700 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $user->produtos->count() }}</span>
                        </button>
                        <button class="tab-button w-1/3 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="favorites-tab">
                            <i class="bi bi-heart mr-2"></i>Favoritos
                            <span class="bg-gray-100 text-gray-700 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $user->favoriteProdutos ? $user->favoriteProdutos->count() : 0 }}</span>
                        </button>
                        <button class="tab-button w-1/3 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="sales-tab">
                            <i class="bi bi-cart-check mr-2"></i>Vendas
                            <span class="bg-gray-100 text-gray-700 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $user->vendas ? $user->vendas->count() : 0 }}</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Products Tab -->
                <div id="products-tab" class="tab-pane active">
                    @include('profile.partials.products-tab')
                </div>

                <!-- Favorites Tab -->
                <div id="favorites-tab" class="tab-pane hidden">
                    @include('profile.partials.favorites-tab')
                </div>

                <!-- Sales Tab -->
                <div id="sales-tab" class="tab-pane hidden">
                    @include('profile.partials.sales-tab')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab management
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabPanes = document.querySelectorAll('.tab-pane');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'border-warning', 'text-warning');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    
                    // Add active class to clicked button
                    this.classList.add('active', 'border-warning', 'text-warning');
                    this.classList.remove('border-transparent', 'text-gray-500');
                    
                    // Hide all panes
                    tabPanes.forEach(pane => {
                        pane.classList.add('hidden');
                        pane.classList.remove('active');
                    });
                    
                    // Show target pane
                    const targetId = this.getAttribute('data-target');
                    const targetPane = document.getElementById(targetId);
                    targetPane.classList.remove('hidden');
                    targetPane.classList.add('active');
                    
                    // Save active tab to localStorage
                    localStorage.setItem('activeProfileTab', targetId);
                });
            });
            
            // Restore active tab from localStorage
            const activeTab = localStorage.getItem('activeProfileTab');
            if (activeTab) {
                const tabToActivate = document.querySelector(`.tab-button[data-target="${activeTab}"]`);
                if (tabToActivate) {
                    tabToActivate.click();
                }
            }
        });
    </script>
    @endpush

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</x-app-layout>