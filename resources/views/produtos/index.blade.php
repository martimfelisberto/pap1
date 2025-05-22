<x-kaira-layout>
    <!-- Seção de Cabeçalho com Filtros -->
    <div style="padding: 2rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
            <!-- Cabeçalho com Título e Botão de Filtros -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 2rem; font-weight: bold; color: #333; margin: 0;">
                    Página de Produtos
                </h2>
                <button id="toggleFiltersBtn"
                    style="padding: 0.75rem 1.25rem; background-color: rgb(36, 104, 250); color: #FFF; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer;">
                    <i class="bi bi-funnel-fill" style="margin-right: 0.5rem;"></i>Filtros
                </button>
            </div>

            <!-- Painel de Filtros Oculto -->
            <div id="filtersPanel"
                style="display: none; margin-bottom: 1.5rem; padding: 1.5rem; background-color: #FFF; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <form method="GET" action="{{ route('produtos.index') }}" style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- Pesquisar -->
                    <div>
                        <label style="font-size: 0.875rem; color: #333;">Pesquisar</label>
                        <input type="text" name="search"
                            placeholder="Nome do produto"
                            value="{{ request()->get('search') }}"
                            style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 8px;">
                    </div>
                    <!-- Marca -->
                    <div>
                        <label style="font-size: 0.875rem; color: #333;">Marca</label>
                        <select name="marca"
                            style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 8px;">
                            <option value="">Todas as marcas</option>
                            <option value="Nike" {{ request()->get('marca') == 'Nike' ? 'selected' : '' }}>Nike</option>
                            <option value="Adidas" {{ request()->get('marca') == 'Adidas' ? 'selected' : '' }}>Adidas</option>
                            <option value="Puma" {{ request()->get('marca') == 'Puma' ? 'selected' : '' }}>Puma</option>
                            <option value="Reebok" {{ request()->get('marca') == 'Reebok' ? 'selected' : '' }}>Reebok</option>
                            <option value="Outros" {{ request()->get('marca') == 'Outros' ? 'selected' : '' }}>Outros</option>
                        </select>
                    </div>
                    <!-- Categoria -->
                    <div>
                        <label style="font-size: 0.875rem; color: #333;">Categoria</label>
                        <select name="categoria"
                            style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 8px;">
                            <option value="">Todas as categorias</option>
                            @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request()->get('categoria') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->titulo }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Gênero -->
                    <div>
                        <label style="font-size: 0.875rem; color: #333;">Gênero</label>
                        <select name="genero"
                            style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 8px;">
                            <option value="">Todos os géneros</option>
                            @php
                            $generos = App\Models\Categoria::select('genero')->distinct()->pluck('genero')->toArray();
                            @endphp
                            @foreach($generos as $genero)
                            <option value="{{ $genero }}" {{ request()->get('genero') == $genero ? 'selected' : '' }}>
                                {{ ucfirst($genero) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Estado -->
                    <div>
                        <label style="font-size: 0.875rem; color: #333;">Estado</label>
                        <select name="estado"
                            style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 8px;">
                            <option value="">Todos os estados</option>
                            <option value="Novo" {{ request()->get('estado') == 'Novo' ? 'selected' : '' }}>Novo</option>
                            <option value="Usado" {{ request()->get('estado') == 'Usado' ? 'selected' : '' }}>Usado</option>
                            <option value="Semi-novo" {{ request()->get('estado') == 'Semi-novo' ? 'selected' : '' }}>Semi-novo</option>
                        </select>
                    </div>
                    <!-- Faixa de Preço -->
                    <div>
                        <label style="font-size: 0.875rem; color: #333;">Faixa de Preço</label>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                            <input type="number" name="preco_min" placeholder="Min"
                                value="{{ request()->get('preco_min') }}" min="0" step="0.01"
                                style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 8px;">
                            <input type="number" name="preco_max" placeholder="Max"
                                value="{{ request()->get('preco_max') }}" min="0" step="0.01"
                                style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 8px;">
                        </div>
                    </div>
                    <!-- Botão de Aplicar Filtros -->
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit"
                            style="padding: 0.5rem 1rem; background-color: rgb(36, 104, 250); color: #FFF; border: none; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                            <i class="bi bi-funnel" style="margin-right: 0.5rem;"></i>Aplicar Filtros
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Container Principal -->
        <div style="max-width: 1280px; margin: 0 auto; padding: 1rem;">
            <!-- Resumo da Pesquisa e Botões de Alternância -->
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <!-- Resumo da Pesquisa -->
                <div style="flex: 1; min-width: 280px;">
                    @if(request()->anyFilled(['search', 'marca', 'categoria', 'genero', 'estado', 'preco_min', 'preco_max']))
                    <h5 style="font-size: 1.125rem; color: #666; margin: 0 0 0.5rem 0;">
                        <i class="bi bi-list-ul" style="margin-right: 0.5rem;"></i>Resultados da pesquisa:
                        <span style="color: #2563EB; font-weight: bold;">{{ $produtos->count() }} produtos encontrados</span>
                    </h5>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                        @if(request('search'))
                        <span style="padding: 0.25rem 0.75rem; background-color: #f3f4f6; color: #374151; border: 1px solid #ccc; border-radius: 999px; display: flex; align-items: center;">
                            <i class="bi bi-search" style="margin-right: 0.25rem;"></i>{{ request('search') }}
                        </span>
                        @endif
                        @if(request('marca'))
                        <span style="padding: 0.25rem 0.75rem; background-color: #f3f4f6; color: #374151; border: 1px solid #ccc; border-radius: 999px; display: flex; align-items: center;">
                            <i class="bi bi-tag-fill" style="margin-right: 0.25rem;"></i>{{ request('marca') }}
                        </span>
                        @endif
                        @if(request('categoria'))
                        <span style="padding: 0.25rem 0.75rem; background-color: #f3f4f6; color: #374151; border: 1px solid #ccc; border-radius: 999px; display: flex; align-items: center;">
                            <i class="bi bi-collection-fill" style="margin-right: 0.25rem;"></i>{{ request('categoria') }}
                        </span>
                        @endif
                        @if(request('genero'))
                        <span style="padding: 0.25rem 0.75rem; background-color: #f3f4f6; color: #374151; border: 1px solid #ccc; border-radius: 999px; display: flex; align-items: center;">
                            <i class="bi bi-gender-ambiguous" style="margin-right: 0.25rem;"></i>{{ ucfirst(request('genero')) }}
                        </span>
                        @endif
                        @if(request('estado'))
                        <span style="padding: 0.25rem 0.75rem; background-color: #f3f4f6; color: #374151; border: 1px solid #ccc; border-radius: 999px; display: flex; align-items: center;">
                            <i class="bi bi-stars" style="margin-right: 0.25rem;"></i>{{ request('estado') }}
                        </span>
                        @endif
                        @if(request('preco_min') || request('preco_max'))
                        <span style="padding: 0.25rem 0.75rem; background-color: #f3f4f6; color: #374151; border: 1px solid #ccc; border-radius: 999px; display: flex; align-items: center;">
                            <i class="bi bi-currency-euro" style="margin-right: 0.25rem;"></i>
                            @if(request('preco_min') && request('preco_max'))
                            {{ request('preco_min') }}€ - {{ request('preco_max') }}€
                            @elseif(request('preco_min'))
                            Min: {{ request('preco_min') }}€
                            @else
                            Max: {{ request('preco_max') }}€
                            @endif
                        </span>
                        @endif
                    </div>
                    @else
                    <h5 style="font-size: 1.125rem; color: #666;">
                        <i class="bi bi-list-ul" style="margin-right: 0.5rem;"></i>Mostrar todos os produtos:
                        <span style="color: #2563EB; font-weight: bold;">{{ $produtos->count() }} produtos</span>
                    </h5>
                    @endif
                </div>

                <!-- Botões de Alternar Visualização -->
                <div style="margin-top: 1rem;">
                    <div style="display: inline-flex; border-radius: 4px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" role="group">
                        <button type="button" id="grid-view"
                            style="padding: 0.5rem 1rem; font-size: 0.875rem; color: #333; background-color: #FFF; border: 1px solid #ccc; border-right: 0; border-top-left-radius: 4px; border-bottom-left-radius: 4px; cursor: pointer;">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </button>
                        <button type="button" id="list-view"
                            style="padding: 0.5rem 1rem; font-size: 0.875rem; color: #333; background-color: #FFF; border: 1px solid #ccc; border-top-right-radius: 4px; border-bottom-right-radius: 4px; cursor: pointer;">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Seção de Exibição dos Produtos -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;" id="products-container">
    @forelse ($produtos as $produto)
    <div style="background-color: #FFF; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column; height: 100%;"
        class="{{ auth()->check() && auth()->user()->is_admin ? 'admin-product-card' : '' }}">
        <!-- Imagem e Marcas/Estado -->
        <div style="position: relative;">
            <img src="{{ asset('storage/' . $produto->imagem) }}"
                style="width: 100%; height: 12rem; object-fit: cover;"
                alt="{{ $produto->nome }}">

            <!-- Se o produto estiver indisponível, exibe a barra "Vendido" -->
            @if(!$produto->disponivel)
            <div style="position: absolute; top: 0; left: 0; width: 100%; background-color: rgba(0,0,0,0.6); color: #FFF; text-align: center; padding: 0.5rem; z-index: 10;">
                Vendido
            </div>
            @endif

            <div style="position: absolute; top: 0.5rem; right: 0.5rem;">
                <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: 600; background-color: #DBEAFE; color: #1D4ED8; border-radius: 999px;">
                    <i class="bi bi-tag-fill" style="margin-right: 0.25rem;"></i>{{ $produto->marca }}
                </span>
            </div>
            @if($produto->estado)
            <div style="position: absolute; bottom: 0.5rem; left: 0.5rem;">
                @php
                // Define estilos de badge conforme o estado
                $badgeStyles = [
                    'Novo' => 'background-color: #DCFCE7; color: #16A34A;',
                    'Semi-novo' => 'background-color: #FEF3C7; color: #CA8A04;',
                    'Usado' => 'background-color: #F3F4F6; color: #6B7280;'
                ];
                $style = $badgeStyles[$produto->estado] ?? 'background-color: #F3F4F6; color: #6B7280;';
                @endphp
                <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: 600; border-radius: 999px; ">
                    {{ $produto->estado }}
                </span>
            </div>
            @endif
        </div>

        <!-- Informações do Produto -->
        <div style="padding: 1rem; flex-grow: 1; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: 600; background-color: #F3F4F6; color: #374151; border-radius: 999px;">
                    <i class="bi bi-collection-fill" style="margin-right: 0.25rem;"></i>{{ $produto->categoria->titulo ?? 'Sem categoria' }}
                </span>
                <span style="font-size: 0.875rem; color: #6B7280;">
                    <i class="bi bi-gender-ambiguous" style="margin-right: 0.25rem;"></i>{{ ucfirst($produto->genero) }}
                </span>
            </div>
            <h3 style="font-size: 1.125rem; font-weight: bold; color: #333; margin: 0 0 0.5rem 0;">{{ $produto->nome }}</h3>
            <div style="margin-bottom: 0.5rem;">
                <span style="font-size: 0.875rem; color: #6B7280;">
                    <i class="bi bi-person-fill" style="margin-right: 0.25rem;"></i>Vendedor:
                    <strong>{{ $produto->user?->name ?? '' }}</strong>
                </span>
            </div>
            <p style="font-size: 0.875rem; color: #6B7280; flex-grow: 1; margin-bottom: 1rem;">
                {{ Str::limit($produto->descricao, 100) }}
            </p>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                @if($produto->tamanho)
                <span style="font-size: 0.875rem; color: #6B7280;">
                    <i class="bi bi-rulers" style="margin-right: 0.25rem;"></i>Tamanho: {{ $produto->tamanho }}
                </span>
                @endif
                <span style="font-size: 1.25rem; font-weight: bold; color: #2563EB;">
                    {{ number_format($produto->preco, 2) }}€
                </span>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <!-- Botão de Favoritos -->
                <button type="button"
                    style="padding: 0.75rem; background-color: #F3F4F6; color: #374151; border: none; border-radius: 8px; transition: background-color 0.3s;">
                    <i class="bi bi-heart"></i>
                </button>

                <!-- Botão de Comprar ou desabilitado caso o produto já tenha sido adquirido -->
                @if($produto->disponivel)
                <a href="{{ route('checkout', ['produto' => $produto->id]) }}"
                    style="padding: 0.75rem; background-color: #34D399; color: #FFF; border: none; border-radius: 8px; text-decoration: none; display: flex; align-items: center; justify-content: center; transition: background-color 0.3s;">
                    Comprar
                </a>
                @else
                <button type="button"
                    style="padding: 0.75rem; background-color: #9CA3AF; color: #FFF; border: none; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: not-allowed;"
                    disabled>
                    Vendido
                </button>
                @endif

                <!-- Botões de administrador -->
                @if(auth()->check() && auth()->user()->is_admin)
                    <div style="display: flex; gap: 0.5rem; margin-left: auto;">
                        <!-- Botão de Editar -->
                        <a href="{{ route('produtos.edit', $produto) }}"
                            style="padding: 0.75rem; background-color: #DBEAFE; color: #2563EB; border: none; border-radius: 8px; transition: background-color 0.3s; display: flex; align-items: center; text-decoration: none;"
                            title="Editar Produto">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        
                        <!-- Botão de Excluir -->
                        <form action="{{ route('produtos.destroy', $produto) }}" method="POST" 
                              onsubmit="return confirm('Tem certeza que deseja excluir este produto? Esta ação não pode ser desfeita.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="padding: 0.75rem; background-color: #FEE2E2; color: #DC2626; border: none; border-radius: 8px; transition: background-color 0.3s; cursor: pointer;"
                                title="Excluir Produto">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @empty
    <div style="grid-column: 1 / -1;">
        <div style="background-color: #DBEAFE; text-align: center; padding: 2rem; border-radius: 16px;">
            <i class="bi bi-info-circle" style="font-size: 2.5rem; color: #2563EB;"></i>
            <h4 style="font-size: 1.5rem; font-weight: bold; color: #333; margin: 1rem 0;">Nenhum produto encontrado</h4>
            <p style="font-size: 1rem; color: #374151; margin-bottom: 1rem;">Tente ajustar os filtros ou pesquise por outro termo.</p>
            <a href="{{ route('produtos.index') }}"
                style="display: inline-flex; align-items: center; padding: 0.75rem 1rem; border: 1px solid #2563EB; color: #2563EB; border-radius: 8px; text-decoration: none;">
                <i class="bi bi-arrow-repeat" style="margin-right: 0.5rem;"></i>Ver todos os produtos
            </a>
        </div>
    </div>
    @endforelse
</div>

        </div>

        <!-- Paginação -->
        <div style="max-width: 1280px; margin: 0 auto; padding: 1rem;">
            <div style="display: flex; justify-content: center;">
                {{ $produtos->links() }}
            </div>
        </div>

        <!-- Scripts para Funcionalidades -->
        <script>
            // Alternar entre visualização em grid e list
            const gridBtn = document.getElementById('grid-view');
            const listBtn = document.getElementById('list-view');
            const productsContainer = document.getElementById('products-container');

            gridBtn.addEventListener('click', () => {
                productsContainer.style.display = 'grid';
                productsContainer.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
            });

            listBtn.addEventListener('click', () => {
                productsContainer.style.display = 'block';
                // Exemplo: alterar cada card para layout em linha
                const cards = productsContainer.querySelectorAll('div[style*="background-color: #FFF"]');
                cards.forEach(card => {
                    card.style.display = 'flex';
                    card.style.flexDirection = 'row';
                });
            });


            // Toggle filters panel
            document.addEventListener('DOMContentLoaded', function() {
                const toggleFiltersBtn = document.getElementById('toggleFiltersBtn');
                const filtersPanel = document.getElementById('filtersPanel');

                toggleFiltersBtn.addEventListener('click', function() {
                    // Verifique se display é 'none' ou vazio (comportamento inicial)
                    const isHidden = filtersPanel.style.display === 'none' || filtersPanel.style.display === '';
                    filtersPanel.style.display = isHidden ? 'block' : 'none';

                    // Atualiza o texto e ícone do botão
                    toggleFiltersBtn.innerHTML = isHidden ?
                        '<i class="bi bi-x-lg" style="margin-right: 0.5rem;"></i>Fechar Filtros' :
                        '<i class="bi bi-funnel-fill" style="margin-right: 0.5rem;"></i>Filtros';
                });
            });

            function toggleDropdown(id) {
                document.getElementById(id).classList.toggle('hidden');
            }

            // Fechar dropdowns ao clicar fora
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.relative')) {
                    document.getElementById('categoriaDropdown').classList.add('hidden');
                    document.getElementById('corDropdown').classList.add('hidden');
                }
            });

            function updateSelectedCategory(categoria) {
                document.getElementById('selectedCategories').textContent = categoria;
            }

            function updateSelectedColors() {
                const checkboxes = document.querySelectorAll('input[name="cores[]"]:checked');
                const selectedColors = Array.from(checkboxes).map(cb => cb.nextElementSibling.textContent).join(', ');
                document.getElementById('selectedColors').textContent = selectedColors || 'Seleciona as cores';
            }

            function updateTamanhoOptions(categoria) {
                const tamanhoContainer = document.getElementById("tamanhoContainer");
                const tamanhoSelect = document.getElementById("tamanho");

                // Limpa as opções anteriores, mantendo apenas a primeira opção
                while (tamanhoSelect.options.length > 1) {
                    tamanhoSelect.remove(1);
                }

                // Mostra o container de tamanhos
                tamanhoContainer.classList.remove('hidden');

                // Adiciona os tamanhos específicos para cada categoria
                if (['Casacos', 'Camisolas', 'Calças e Calções', 'Tops e T-shirts'].includes(categoria)) {
                    const tamanhos = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                    tamanhos.forEach(tamanho => {
                        const option = new Option(tamanho, tamanho);
                        tamanhoSelect.add(option);
                    });
                } else if (categoria === 'Sapatilhas') {
                    // Gera tamanhos de 36 a 46
                    for (let i = 36; i <= 46; i += 0.5) {
                        const option = new Option(i.toString(), i.toString());
                        tamanhoSelect.add(option);
                    }
                } else {
                    // Para outras categorias sem tamanho específico
                    tamanhoContainer.classList.add('hidden');
                }
            }

            // Preview da imagem
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('imagePlaceholder');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
            }
        </script>
        </body>

        </html>
</x-kaira-layout>