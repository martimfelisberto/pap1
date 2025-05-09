<x-kaira-layout>
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
</x-kaira-layout>
