<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h1 class="text-2xl font-bold leading-tight text-white mb-2 md:mb-0">
                <i class="bi bi-bag-plus me-2"></i>{{ __('Adicionar Novo Produto') }}
            </h1>
            <a href="/"
                class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="bi bi-house-door me-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Mensagens de Feedback -->
            @if(session('success'))
            <div class="p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-md" role="alert"
                id="successAlert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle-fill text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                    <div class="pl-3 ml-auto">
                        <button type="button" class="inline-flex text-green-700"
                            onclick="document.getElementById('successAlert').remove()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 md:p-6 text-gray-900">
                    <!-- Progresso do Formulário -->
                    <div class="mb-8">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Progresso do formulário</span>
                            <span class="text-sm font-medium text-gray-700" id="formProgress">0%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full">
                            <div class="h-2 bg-warning rounded-full transition-all duration-300" id="progressBar" style="width: 0%"></div>
                        </div>
                    </div>

                    <form method="post" action="{{ route('produtos.store') }}" enctype="multipart/form-data"
                        id="productForm" class="product-form">
                        @csrf
                        <div class="space-y-12">
                            <!-- Seção 1: Informações Básicas -->
                            <div class="pb-12 border-b border-gray-900/10" id="section1">
                                <h2 class="text-xl font-bold text-warning flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 mr-2 text-white bg-warning rounded-full flex-shrink-0">1</span>
                                    Informações Básicas
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">Informações essenciais do produto</p>

                                <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="nome" class="block text-sm font-medium text-gray-900">
                                            Nome do Produto <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-warning">
                                                <input type="text" name="nome" id="nome" required
                                                    class="block w-full border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                    placeholder="Ex: Camisola Nike Vintage"
                                                    value="{{ old('nome') }}">
                                            </div>
                                            @error('nome')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="descricao" class="block text-sm font-medium text-gray-900">
                                            Descrição <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-2">
                                            <textarea name="descricao" id="descricao" rows="3" required
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-warning sm:text-sm sm:leading-6"
                                                placeholder="Descreva o estado, material, medidas e outros detalhes relevantes do produto...">{{ old('descricao') }}</textarea>
                                            @error('descricao')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="imagem" class="block text-sm font-medium text-gray-900">
                                            Foto do Produto <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
                                            id="dropzone">
                                            <div class="text-center">
                                                <i class="bi bi-image text-gray-300 text-5xl"></i>
                                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                                    <label for="imagem"
                                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-warning focus-within:outline-none focus-within:ring-2 focus-within:ring-warning focus-within:ring-offset-2 hover:text-warning-dark">
                                                        <span>Carregar imagem</span>
                                                        <input id="imagem" name="imagem" type="file"
                                                            class="sr-only" accept="image/*" onchange="previewImage(event)">
                                                    </label>
                                                    <p class="pl-1">ou arraste e solte</p>
                                                </div>
                                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF até 10MB</p>
                                            </div>
                                        </div>
                                        @error('imagem')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div>
    <label for="condicoes" class="block text-sm font-medium text-gray-900">
        Condições do Produto <span class="text-red-500">*</span>
    </label>
    <p class="mt-1 text-sm text-gray-500">Descreva o estado e condições do produto em detalhes.</p>
    
    <div class="mt-2">
        <div class="rounded-md border border-gray-300 overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-300">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Detalhes do Estado</span>
                    <button type="button" class="text-xs text-gray-600 hover:text-gray-900 flex items-center" id="clearDetailsBtn">
                        <i class="bi bi-trash mr-1"></i> Limpar
                    </button>
                </div>
            </div>
            
            <textarea name="condicoes" id="condicoes" rows="6" required
                class="block w-full border-0 py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                placeholder="- Sem manchas ou defeitos&#10;- Todas as costuras intactas&#10;- Usado apenas 2 vezes&#10;- Lavado e passado">{{ old('condicoes') }}</textarea>
        </div>
        @error('condicoes')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label for="medidas" class="block text-sm font-medium text-gray-900">
        Medidas (opcional)
    </label>
    <p class="mt-1 text-sm text-gray-500">Forneça as medidas detalhadas do produto.</p>
    
    <div class="mt-2">
        <textarea name="medidas" id="medidas" rows="4"
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-warning sm:text-sm sm:leading-6"
            placeholder="Comprimento: 70cm&#10;Largura: 50cm&#10;Manga: 60cm">{{ old('medidas') }}</textarea>
        @error('medidas')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<!-- Seção 4: Revisão e Envio -->
<div class="pb-12 hidden" id="section4">
    <h2 class="text-xl font-bold text-warning flex items-center">
        <span class="inline-flex items-center justify-center w-8 h-8 mr-2 text-white bg-warning rounded-full flex-shrink-0">4</span>
        Revisar e Publicar
    </h2>
    <p class="mt-1 text-sm text-gray-600">Revise todas as informações antes de publicar seu produto.</p>

    <div class="mt-8 bg-gray-50 rounded-lg p-6">
        <div class="space-y-6">
            <!-- Prévia do Produto -->
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-medium text-gray-900" id="preview-title">Nome do Produto</h3>
                <p class="mt-1 text-sm text-gray-500" id="preview-description">Descrição do produto...</p>
                
                <div class="mt-4 flex flex-wrap items-center gap-4">
                    <div class="flex items-center">
                        <i class="bi bi-tag text-warning mr-1"></i>
                        <span class="text-sm text-gray-700" id="preview-price">0.00€</span>
                    </div>
                    <div class="flex items-center">
                        <i class="bi bi-box text-warning mr-1"></i>
                        <span class="text-sm text-gray-700" id="preview-size">Tamanho</span>
                    </div>
                    <div class="flex items-center">
                        <i class="bi bi-stars text-warning mr-1"></i>
                        <span class="text-sm text-gray-700" id="preview-condition">Estado</span>
                    </div>
                    <div class="flex items-center">
                        <i class="bi bi-folder text-warning mr-1"></i>
                        <span class="text-sm text-gray-700" id="preview-category">Categoria</span>
                    </div>
                </div>
                
                <div class="mt-4" id="preview-image-container">
                    <img id="preview-image" class="h-48 w-full object-cover rounded-md" src="" alt="Preview do Produto">
                </div>
            </div>
            
            <!-- Condições e Medidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-2">Condições do Produto</h4>
                    <div class="text-sm text-gray-700" id="preview-conditions">
                        <!-- Condições serão inseridas aqui -->
                    </div>
                </div>
                
                <div id="preview-measurements-container">
                    <h4 class="text-md font-medium text-gray-900 mb-2">Medidas</h4>
                    <div class="text-sm text-gray-700" id="preview-measurements">
                        <!-- Medidas serão inseridas aqui -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="bi bi-exclamation-triangle text-yellow-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Ao publicar, você confirma que este produto é seu e as informações fornecidas são verdadeiras.
                </p>
            </div>
        </div>
    </div>

    <div class="flex justify-between mt-8">
        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors" onclick="prevSection(4)">
            <i class="bi bi-arrow-left mr-1"></i> Anterior
        </button>
        <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-warning rounded-md hover:bg-warning-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning transition-colors">
            <i class="bi bi-send mr-1"></i> Publicar Produto
        </button>
    </div>
</div>

<input type="hidden" name="vendedor" value="{{ Auth::user()->name }}">
<input type="hidden" name="vendedor_id" value="{{ Auth::id() }}">

<script>
    // Funções de manipulação de imagem
    function previewImage(event) {
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            imagePreviewContainer.classList.add('hidden');
        }
    }
    
    function removeImage() {
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const fileInput = document.getElementById('imagem');
        
        imagePreview.src = '';
        imagePreviewContainer.classList.add('hidden');
        fileInput.value = '';
    }
    
    // Variáveis globais
    let currentSection = 1;
    const totalSections = 4;
    
    // Funções de navegação entre seções
    function nextSection(currentSectionNum) {
        if (!validateSection(currentSectionNum)) return;
        
        document.getElementById(`section${currentSectionNum}`).classList.add('hidden');
        const nextSectionNum = currentSectionNum + 1;
        document.getElementById(`section${nextSectionNum}`).classList.remove('hidden');
        
        currentSection = nextSectionNum;
        
        if (currentSection === 4) {
            generatePreview();
        }
        
        updateProgressBar();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function prevSection(currentSectionNum) {
        document.getElementById(`section${currentSectionNum}`).classList.add('hidden');
        const prevSectionNum = currentSectionNum - 1;
        document.getElementById(`section${prevSectionNum}`).classList.remove('hidden');
        
        currentSection = prevSectionNum;
        updateProgressBar();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // Função de validação
    function validateSection(sectionNum) {
        let isValid = true;
        
        const errorMessages = document.querySelectorAll('.validation-error');
        errorMessages.forEach(el => el.remove());
        
        const errorFields = document.querySelectorAll('.border-red-500, .ring-red-500');
        errorFields.forEach(el => {
            el.classList.remove('border-red-500', 'ring-red-500');
        });
        
        switch(sectionNum) {
            case 1:
                // Validar nome, descrição e imagem
                const nome = document.getElementById('nome').value.trim();
                const descricao = document.getElementById('descricao').value.trim();
                const foto = document.getElementById('imagem').files.length;
                
                if (!nome) {
                    showError('nome', 'O nome do produto é obrigatório');
                    isValid = false;
                }
                
                if (!descricao) {
                    showError('descricao', 'A descrição do produto é obrigatória');
                    isValid = false;
                }
                
                if (foto === 0) {
                    showError('dropzone', 'Uma foto do produto é obrigatória');
                    isValid = false;
                }
                break;
                
            case 2:
                // Validar preço, tamanho, estado e categoria
                const preco = document.getElementById('preco').value.trim();
                const tamanho = document.getElementById('tamanho').value;
                const estado = document.getElementById('estado').value;
                const categoria = document.getElementById('categoria').value;
                
                if (!preco || preco <= 0) {
                    showError('preco', 'Informe um preço válido');
                    isValid = false;
                }
                
                if (!tamanho) {
                    showError('tamanho', 'Selecione o tamanho');
                    isValid = false;
                }
                
                if (!estado) {
                    showError('estado', 'Selecione o estado do produto');
                    isValid = false;
                }
                
                if (!categoria) {
                    showError('categoria', 'Selecione uma categoria');
                    isValid = false;
                }
                break;
                
            case 3:
                // Validar condições
                const condicoes = document.getElementById('condicoes').value.trim();
                
                if (!condicoes) {
                    showError('condicoes', 'Descreva as condições do produto');
                    isValid = false;
                }
                break;
        }
        
        return isValid;
    }
    
    // Função para mostrar erros de validação
    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('p');
        errorDiv.className = 'mt-1 text-sm text-red-600 validation-error';
        errorDiv.textContent = message;
        
        field.parentElement.appendChild(errorDiv);
        
        if (fieldId === 'dropzone') {
            field.classList.add('border-red-500');
        } else {
            field.classList.add('ring-red-500', 'border-red-500');
        }
        
        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    // Atualizar a barra de progresso
    function updateProgressBar() {
        const progress = Math.min(((currentSection - 1) / (totalSections - 1)) * 100, 100);
        document.getElementById('progressBar').style.width = `${progress}%`;
        document.getElementById('formProgress').textContent = `${Math.round(progress)}%`;
    }
    
    // Configurar o drag and drop para upload de imagem
    document.addEventListener('DOMContentLoaded', function() {
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('imagem');
        
        if (!dropzone || !fileInput) return;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, function() {
                dropzone.classList.add('bg-yellow-50', 'border-warning');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, function() {
                dropzone.classList.remove('bg-yellow-50', 'border-warning');
            }, false);
        });
        
        dropzone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileInput.files = files;
                previewImage({ target: fileInput });
            }
        }, false);
    });
    
    // Gerar prévia do produto
    function generatePreview() {
        // Informações básicas
        document.getElementById('preview-title').textContent = document.getElementById('nome').value || 'Nome do Produto';
        document.getElementById('preview-description').textContent = document.getElementById('descricao').value || 'Descrição do produto...';
        
        // Detalhes
        document.getElementById('preview-price').textContent = `${document.getElementById('preco').value || '0.00'}€`;
        
        const tamanhoSelect = document.getElementById('tamanho');
        document.getElementById('preview-size').textContent = tamanhoSelect.options[tamanhoSelect.selectedIndex]?.text || 'Não informado';
        
        const estadoSelect = document.getElementById('estado');
        document.getElementById('preview-condition').textContent = estadoSelect.options[estadoSelect.selectedIndex]?.text || 'Não informado';
        
        const categoriaSelect = document.getElementById('categoria');
        document.getElementById('preview-category').textContent = categoriaSelect.options[categoriaSelect.selectedIndex]?.text || 'Não informada';
        
        // Imagem
        const imagePreview = document.getElementById('imagePreview');
        if (imagePreview.src) {
            document.getElementById('preview-image').src = imagePreview.src;
            document.getElementById('preview-image-container').classList.remove('hidden');
        } else {
            document.getElementById('preview-image-container').classList.add('hidden');
        }
        
        // Condições
        const condicoesTextarea = document.getElementById('condicoes');
        const condicoesPreview = document.getElementById('preview-conditions');
        condicoesPreview.innerHTML = condicoesTextarea.value
            .split('\n')
            .filter(c => c.trim())
            .map(c => `<p>${c}</p>`)
            .join('');
        
        // Medidas (opcional)
        const medidasTextarea = document.getElementById('medidas');
        const medidasContainer = document.getElementById('preview-measurements-container');
        const medidasPreview = document.getElementById('preview-measurements');
        
        if (medidasTextarea.value.trim()) {
            medidasPreview.innerHTML = medidasTextarea.value
                .split('\n')
                .filter(m => m.trim())
                .map(m => `<p>${m}</p>`)
                .join('');
            medidasContainer.classList.remove('hidden');
        } else {
            medidasContainer.classList.add('hidden');
        }
    }
</script>
</x-app-layout>
