<x-kaira-layout>
    <div style="padding: 2rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 1rem;">
            <!-- Cabeçalho -->
            <div style="margin-bottom: 1.5rem;">
                <h2 style="font-size: 2rem; font-weight: bold; color: #333; margin: 0;">
                    Editar Produto
                </h2>
                 </div>

            <!-- Formulário de Edição -->
            <form action="{{ route('produtos.update', $produto) }}" method="POST" enctype="multipart/form-data"
                style="background-color: #F9FAFB; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                @csrf
                @method('PUT')

                <!-- Nome do Produto -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="nome" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Nome do Produto</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $produto->nome) }}"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;" required>
                </div>

                <!-- Descrição -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="descricao" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">{{ old('descricao', $produto->descricao) }}</textarea>
                </div>

                <!-- Preço -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="preco" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Preço (€)</label>
                    <input type="number" id="preco" name="preco" value="{{ old('preco', $produto->preco) }}" step="0.01"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;" required>
                </div>

                <!-- Categoria -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="categoria" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Categoria</label>
                    <select id="categoria" name="categoria_id"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $produto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Marca -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="marca" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Marca</label>
                    <input type="text" id="marca" name="marca" value="{{ old('marca', $produto->marca) }}"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
                </div>

                <!-- Tamanho -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="tamanho" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Tamanho</label>
                    <input type="text" id="tamanho" name="tamanho" value="{{ old('tamanho', $produto->tamanho) }}"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
                </div>

                <!-- Estado -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="estado" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Estado</label>
                    <select id="estado" name="estado"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
                        <option value="">Selecione o estado</option>
                        <option value="Novo" {{ $produto->estado == 'Novo' ? 'selected' : '' }}>Novo</option>
                        <option value="Semi-novo" {{ $produto->estado == 'Semi-novo' ? 'selected' : '' }}>Semi-novo</option>
                        <option value="Usado" {{ $produto->estado == 'Usado' ? 'selected' : '' }}>Usado</option>
                    </select>
                </div>

                <!-- Imagem -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="imagem" style="font-size: 0.875rem; color: #333; display: block; margin-bottom: 0.5rem;">Imagem</label>
                    <input type="file" id="imagem" name="imagem"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px;">
                    @if($produto->imagem)
                        <div style="margin-top: 0.5rem;">
                            <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}"
                                style="width: 100px; height: auto; border-radius: 8px;">
                        </div>
                    @endif
                </div>

                <!-- Botões -->
                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                    <a href="{{ route('produtos.index') }}"
                        style="padding: 0.75rem 1.5rem; background-color: #F3F4F6; color: #374151; border: none; border-radius: 8px; text-decoration: none; text-align: center;">
                        Cancelar
                    </a>
                    <button type="submit"
                        style="padding: 0.75rem 1.5rem; background-color: #2563EB; color: #FFF; border: none; border-radius: 8px; cursor: pointer;">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-kaira-layout>