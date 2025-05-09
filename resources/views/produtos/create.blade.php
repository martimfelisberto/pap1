<x-kaira-layout>
    <div class="container py-4">
        <!-- Progress Bar -->
        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span class="small fw-medium">Progresso do formulário</span>
                <span class="small fw-medium" id="formProgress">0%</span>
            </div>
            <div class="progress">
                <div class="progress-bar bg-warning" id="progressBar" role="progressbar" style="width: 0%"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data" id="productForm">
            @csrf
            
            <!-- Section 1: Basic Information -->
            <div class="card mb-4" id="section1">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <span class="badge bg-white text-warning me-2">1</span>
                        Informações Básicas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            Nome do Produto <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="nome" name="nome" required
                               placeholder="Ex: Camisola Nike Vintage" value="{{ old('nome') }}">
                        @error('nome')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">
                            Descrição <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required
                                  placeholder="Descreva o estado, material, medidas e outros detalhes relevantes do produto...">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" name="marca" required>
                            <option value="">Selecione a marca</option>
                            <optgroup label="Marcas de Sapatilhas">
                                <option value="Nike">Nike</option>
                                <option value="Adidas">Adidas</option>
                                <option value="Puma">Puma</option>
                                <option value="New Balance">New Balance</option>
                                <option value="Reebok">Reebok</option>
                            </optgroup>
                            <optgroup label="Marcas de Roupas">
                                <option value="Zara">Zara</option>
                                <option value="H&M">H&M</option>
                                <option value="Pull&Bear">Pull&Bear</option>
                                <option value="Bershka">Bershka</option>
                                <option value="Stradivarius">Stradivarius</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="genero">Gênero</label>
                        <select class="form-control" id="genero" name="genero" required>
                            <option value="">Selecione o gênero</option>
                            <option value="homem">Homem</option>
                            <option value="mulher">Mulher</option>
                            <option value="crianca">Criança</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="categoria">Categoria</label>
                        <select class="form-control" id="categoria" name="categoria" required disabled>
                            <option value="">Selecione primeiro o gênero</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tamanho">Tamanho</label>
                        <select class="form-control" id="tamanho" name="tamanho" required>
                            <option value="">Selecione o tamanho</option>
                        </select>
                    </div>

                    <div id="especificacoes-sapatilhas" style="display: none;">
                        <h4>Especificações de Sapatilhas</h4>
                        <div class="form-group">
                            <label for="tipo_sola">Tipo de Sola</label>
                            <select class="form-control" id="tipo_sola" name="tipo_sola">
                                <option value="">Selecione o tipo de sola</option>
                                <option value="borracha">Borracha</option>
                                <option value="eva">EVA</option>
                                <option value="pu">PU</option>
                                <option value="tpu">TPU</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="material">Material</label>
                            <select class="form-control" id="material" name="material">
                                <option value="couro">Couro</option>
                                <option value="tecido">Tecido</option>
                                <option value="sintetico">Sintético</option>
                                <option value="mesh">Mesh</option>
                            </select>
                        </div>
                    </div>

                    <div id="especificacoes-roupas" class="especificacoes" style="display: none;">
                        <h4>Especificações de Roupas</h4>
                        <div class="form-group">
                            <label for="material">Material</label>
                            <input type="text" class="form-control" id="material" name="material">
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo">
                        </div>
                        <div class="form-group">
                            <label for="forro">Forro</label>
                            <input type="text" class="form-control" id="forro" name="forro">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="capuz" name="capuz">
                                <label class="form-check-label" for="capuz">Tem Capuz?</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="">Selecione o estado</option>
                            <option value="novo">Novo</option>
                            <option value="semi-novo">Semi-novo</option>
                            <option value="usado">Usado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Cores</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="cores[]" value="preto" id="cor-preto">
                            <label class="form-check-label" for="cor-preto">Preto</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="cores[]" value="branco" id="cor-branco">
                            <label class="form-check-label" for="cor-branco">Branco</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="cores[]" value="azul" id="cor-azul">
                            <label class="form-check-label" for="cor-azul">Azul</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="cores[]" value="vermelho" id="cor-vermelho">
                            <label class="form-check-label" for="cor-vermelho">Vermelho</label>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="imagem" class="form-label">
                            Foto do Produto <span class="text-danger">*</span>
                        </label>
                        <div class="drop-zone border rounded p-4 text-center" id="dropzone">
                            <i class="bi bi-image fs-1 text-muted"></i>
                            <div class="mt-3">
                                <label for="imagem" class="text-warning fw-medium cursor-pointer">
                                    Carregar imagem
                                    <input type="file" id="imagem" name="imagem" class="d-none" 
                                           accept="image/*" onchange="previewImage(event)">
                                </label>
                                <span class="text-muted ms-2">ou arraste e solte</span>
                            </div>
                            <p class="small text-muted mt-2">PNG, JPG, GIF até 10MB</p>
                        </div>
                        @error('imagem')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Product Conditions -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-medium">Detalhes do Estado</span>
                    <button type="button" class="btn btn-sm text-muted" id="clearDetailsBtn">
                        <i class="bi bi-trash me-1"></i> Limpar
                    </button>
                </div>
                <div class="card-body">
                    <textarea name="condicoes" id="condicoes" rows="6" class="form-control" required
                              placeholder="- Sem manchas ou defeitos&#10;- Todas as costuras intactas&#10;- Usado apenas 2 vezes&#10;- Lavado e passado">{{ old('condicoes') }}</textarea>
                    @error('condicoes')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Measurements -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Medidas (opcional)</h5>
                </div>
                <div class="card-body">
                    <textarea name="medidas" id="medidas" rows="4" class="form-control"
                              placeholder="Comprimento: 70cm&#10;Largura: 50cm&#10;Manga: 60cm">{{ old('medidas') }}</textarea>
                    @error('medidas')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Review Section -->
            <div class="card mb-4" id="section4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <span class="badge bg-white text-warning me-2">4</span>
                        Revisar e Publicar
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Product Preview -->
                    <div class="product-preview mb-4">
                        <h4 id="preview-title">Nome do Produto</h4>
                        <p class="text-muted" id="preview-description">Descrição do produto...</p>
                        
                        <div class="d-flex flex-wrap gap-3 mb-3">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-tag text-warning me-1"></i>
                                <span id="preview-price">0.00€</span>
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-box text-warning me-1"></i>
                                <span id="preview-size">Tamanho</span>
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-stars text-warning me-1"></i>
                                <span id="preview-condition">Estado</span>
                            </span>
                        </div>
                        
                        <div class="preview-image-container mb-3">
                            <img id="preview-image" class="img-fluid rounded shadow-sm" src="" alt="Preview">
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Ao publicar, você confirma que este produto é seu e as informações fornecidas são verdadeiras.
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="prevSection(4)">
                            <i class="bi bi-arrow-left me-1"></i> Anterior
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-send me-1"></i> Publicar Produto
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Form Progress
        function updateProgress() {
            const form = document.getElementById('productForm');
            const totalFields = form.querySelectorAll('input:required, select:required, textarea:required').length;
            const filledFields = form.querySelectorAll('input:required:valid, select:required:valid, textarea:required:valid').length;
            const progress = Math.round((filledFields / totalFields) * 100);
            
            document.getElementById('formProgress').textContent = `${progress}%`;
            document.getElementById('progressBar').style.width = `${progress}%`;
        }

        // Image Preview
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Clear Details Button
        document.getElementById('clearDetailsBtn').addEventListener('click', function() {
            document.getElementById('condicoes').value = '';
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateProgress();
            document.getElementById('productForm').addEventListener('change', updateProgress);
        });

        // Update preview when inputs change
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = ['nome', 'descricao', 'tamanho', 'estado'];
            inputs.forEach(field => {
                document.getElementById(field)?.addEventListener('change', updatePreview);
            });

            function updatePreview() {
                // Update title
                const titleElement = document.getElementById('preview-title');
                const nameInput = document.getElementById('nome');
                if (titleElement && nameInput) {
                    titleElement.textContent = nameInput.value || 'Nome do Produto';
                }

                // Update description
                const descElement = document.getElementById('preview-description');
                const descInput = document.getElementById('descricao');
                if (descElement && descInput) {
                    descElement.textContent = descInput.value || 'Descrição do produto...';
                }

                // Update size
                const sizeElement = document.getElementById('preview-size');
                const sizeInput = document.getElementById('tamanho');
                if (sizeElement && sizeInput) {
                    sizeElement.textContent = sizeInput.value || 'Tamanho';
                }

                // Update condition
                const conditionElement = document.getElementById('preview-condition');
                const conditionInput = document.getElementById('estado');
                if (conditionElement && conditionInput) {
                    conditionElement.textContent = conditionInput.value || 'Estado';
                }
            }
        });

        // Categoria dinamica baseada no gênero
        document.getElementById('genero').addEventListener('change', function() {
            const genero = this.value;
            const categoriaSelect = document.getElementById('categoria');
            
            if (!genero) {
                categoriaSelect.disabled = true;
                categoriaSelect.innerHTML = '<option value="">Selecione primeiro o gênero</option>';
                return;
            }

            // Fazer requisição AJAX para buscar categorias
            fetch(`/api/categorias/${genero}`)
                .then(response => response.json())
                .then(categorias => {
                    categoriaSelect.disabled = false;
                    categoriaSelect.innerHTML = '<option value="">Selecione uma categoria</option>';
                    
                    categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nome;
                        categoriaSelect.appendChild(option);
                    });
                });
        });
    </script>
    @endpush
</x-kaira-layout>


