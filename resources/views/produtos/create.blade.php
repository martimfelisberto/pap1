<x-kaira-layout>
    <div style="padding: 1.5rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1rem;">
            <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); border-radius: 15px; padding: 1.5rem; margin-bottom: 2rem;">
                <h2 style="font-size: 1.75rem; font-weight: 600; text-align: center; margin-bottom: 1rem; color: #333;">
                    Novo Produto
                </h2>
                <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data" id="productForm">
                    @csrf

                    <!-- Nome do Produto -->
                    <div style="margin-bottom: 1rem;">
                        <label for="nome" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                            Nome do Produto <span style="color: #e63946;">*</span>
                        </label>
                        <input type="text" id="nome" name="nome" required
                            placeholder="Ex: Camisola Nike Vintage"
                            value="{{ old('nome') }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                        @error('nome')
                        <div style="color: #e63946; font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div style="margin-bottom: 1rem;">
                        <label for="descricao" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                            Descrição <span style="color: #e63946;">*</span>
                        </label>
                        <textarea id="descricao" name="descricao" rows="3" required
                            placeholder="Descreva o estado, material, medidas e outros detalhes relevantes do produto..."
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">{{ old('descricao') }}</textarea>
                        @error('descricao')
                        <div style="color: #e63946; font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Marca -->
                    <div style="margin-bottom: 1rem;">
                        <label for="marca" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                            Marca
                        </label>
                        <select id="marca" name="marca" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
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

                    <!-- Gênero -->
                    <div style="margin-bottom: 1rem;">
                        <label for="genero" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                            Gênero
                        </label>
                        <select id="genero" name="genero" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                            <option value="">Selecione o gênero</option>
                            <option value="homem">Homem</option>
                            <option value="mulher">Mulher</option>
                            <option value="crianca">Criança</option>
                        </select>
                    </div>

                   <!-- Categoria -->
<div style="margin-bottom: 1rem;">
    <label for="categoria" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
        Categoria <span style="color: #e63946;">*</span>
    </label>
    <select id="categoria" name="categoria" required
            style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
        <option value="">Selecione uma categoria</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
        @endforeach
    </select>
    @error('categoria')
        <div style="color: #e63946; font-size: 0.875rem;">{{ $message }}</div>
    @enderror
</div>
                    <!-- Tamanho -->
                    <div style="margin-bottom: 1rem;">
                        <label for="tamanho" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                            Tamanho
                        </label>
                        <select id="tamanho" name="tamanho" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                            <option value="">Selecione o tamanho</option>
                        </select>
                    </div>

                    <!-- Especificações de Sapatilhas -->
                    <div id="especificacoes-sapatilhas" style="display: none; margin-bottom: 1rem;">
                        <h4 style="font-size: 1.25rem; color: #333; margin-bottom: 0.75rem;">
                            Especificações de Sapatilhas
                        </h4>
                        <div style="margin-bottom: 1rem;">
                            <label for="tipo_sola" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Tipo de Sola
                            </label>
                            <select id="tipo_sola" name="tipo_sola"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                                <option value="">Selecione o tipo de sola</option>
                                <option value="borracha">Borracha</option>
                                <option value="eva">EVA</option>
                                <option value="pu">PU</option>
                                <option value="tpu">TPU</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="material" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Material
                            </label>
                            <select id="material" name="material"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                                <option value="">Selecione o material</option>
                                <option value="couro">Couro</option>
                                <option value="tecido">Tecido</option>
                                <option value="sintetico">Sintético</option>
                                <option value="mesh">Mesh</option>
                            </select>
                        </div>
                    </div>

                    <!-- Especificações de Roupas -->
                    <div id="especificacoes-roupas" style="display: none; margin-bottom: 1rem;">
                        <h4 style="font-size: 1.25rem; color: #333; margin-bottom: 0.75rem;">
                            Especificações de Roupas
                        </h4>
                        <div style="margin-bottom: 1rem;">
                            <label for="material" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Material
                            </label>
                            <input type="text" id="material" name="material"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="tipo" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Tipo
                            </label>
                            <input type="text" id="tipo" name="tipo"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="forro" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Forro
                            </label>
                            <input type="text" id="forro" name="forro"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" id="capuz" name="capuz" style="margin-right: 0.5rem;">
                                <label for="capuz" style="font-size: 1rem; color:#333;">Tem Capuz?</label>
                            </div>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div style="margin-bottom: 1rem;">
                        <label for="estado" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                            Estado
                        </label>
                        <select id="estado" name="estado" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                            <option value="">Selecione o estado</option>
                            <option value="novo">Novo</option>
                            <option value="semi-novo">Semi-novo</option>
                            <option value="usado">Usado</option>
                        </select>
                    </div>

                    <!-- Cores -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">Cores</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            <div>
                                <input type="checkbox" name="cores[]" value="preto" id="cor-preto" style="margin-right: 0.25rem;">
                                <label for="cor-preto" style="font-size: 0.875rem; color:#333;">Preto</label>
                            </div>
                            <div>
                                <input type="checkbox" name="cores[]" value="branco" id="cor-branco" style="margin-right: 0.25rem;">
                                <label for="cor-branco" style="font-size: 0.875rem; color:#333;">Branco</label>
                            </div>
                            <div>
                                <input type="checkbox" name="cores[]" value="azul" id="cor-azul" style="margin-right: 0.25rem;">
                                <label for="cor-azul" style="font-size: 0.875rem; color:#333;">Azul</label>
                            </div>
                            <div>
                                <input type="checkbox" name="cores[]" value="vermelho" id="cor-vermelho" style="margin-right: 0.25rem;">
                                <label for="cor-vermelho" style="font-size: 0.875rem; color:#333;">Vermelho</label>
                            </div>
                        </div>
                    </div>

                    <!-- Upload da Imagem -->
                    <div style="margin-bottom: 1rem;">
                        <label for="imagem" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                            Foto do Produto <span style="color: #e63946;">*</span>
                        </label>
                        <div id="dropzone" style="border: 2px dashed #ccc; border-radius: 8px; padding: 1.5rem; text-align: center;">
                            <i class="bi bi-image" style="font-size: 2.5rem; color: #ccc;"></i>
                            <div style="margin-top: 0.75rem;">
                                <label for="imagem" style="cursor: pointer; color: rgb(36, 104, 250); font-weight: 600;">
                                    Carregar imagem
                                    <input type="file" id="imagem" name="imagem" style="display: none;" accept="image/*" onchange="previewImage(event)">
                                </label>
                                <span style="color: #6c757d; margin-left: 0.5rem;">ou arraste e solte</span>
                            </div>
                            <p style="font-size: 0.875rem; color: #6c757d; margin-top: 0.5rem;">PNG, JPG, GIF até 10MB</p>
                        </div>
                        @error('imagem')
                        <div style="color: #e63946; font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Detalhes do Estado -->
                    <div style="background-color: #FFF; border: 1px solid #e0e0e0; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border-radius: 8px; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; border-bottom: 1px solid #e0e0e0;">
                            <span style="font-weight: 500; color: #333;">Detalhes do Estado</span>
                            <button type="button" id="clearDetailsBtn" style="background: none; border: none; color: #6c757d; font-size: 0.875rem; cursor: pointer;">
                                <i class="bi bi-trash" style="margin-right: 0.25rem;"></i> Limpar
                            </button>
                        </div>
                        <div style="padding: 1rem;">
                            <textarea name="condicoes" id="condicoes" rows="6" required
                                placeholder="- Sem manchas ou defeitos&#10;- Todas as costuras intactas&#10;- Usado apenas 2 vezes&#10;- Lavado e passado"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">{{ old('condicoes') }}</textarea>
                            @error('condicoes')
                            <div style="color: #e63946; font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Medidas (opcional) -->
                    <div style="background-color: #FFF; border: 1px solid #e0e0e0; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border-radius: 8px; margin-bottom: 1.5rem;">
                        <div style="padding: 0.75rem 1rem; border-bottom: 1px solid #e0e0e0;">
                            <h5 style="margin: 0; font-size: 1rem; font-weight: 600; color: #333;">Medidas (opcional)</h5>
                        </div>
                        <div style="padding: 1rem;">
                            <textarea name="medidas" id="medidas" rows="4"
                                placeholder="Comprimento: 70cm&#10;Largura: 50cm&#10;Manga: 60cm"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">{{ old('medidas') }}</textarea>
                            @error('medidas')
                            <div style="color: #e63946; font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Rodapé com Botões -->
                    <div style="padding: 1rem; display: flex; justify-content: space-between; border-top: 1px solid #e0e0e0;">
                        <button type="button" onclick="prevSection(4)" style="padding: 0.5rem 1rem; background-color: transparent; border: 1px solid #6c757d; border-radius: 5px; color: #6c757d; font-size: 0.875rem; cursor: pointer;">
                            <i class="bi bi-arrow-left" style="margin-right: 0.25rem;"></i> Anterior
                        </button>
                        <button type="submit" style="padding: 0.5rem 1rem; background-color:rgb(36, 104, 250); border: none; border-radius: 5px; color: #FFF; font-size: 0.875rem; cursor: pointer;">
                            <i class="bi bi-send" style="margin-right: 0.25rem;"></i> Publicar Produto
                        </button>
                    </div>

                </form>
            </div>
        </div>
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
    </script>
    @endpush
</x-kaira-layout>