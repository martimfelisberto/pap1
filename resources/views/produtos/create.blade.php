<x-kaira-layout>
    <div style="padding: 1.5rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1rem;">
            <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); border-radius: 15px; padding: 1.5rem; margin-bottom: 2rem;">
                <h2 style="font-size: 1.75rem; font-weight: 600; text-align: center; margin-bottom: 1rem; color: #333;">
                    Novo Produto
                </h2>
                <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
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
                    <div style="margin-bottom: 1.5rem;">
                        <label for="marca" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Marca</label>
                        <select id="marca" name="marca" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px;">
                            <option value="">Seleciona a marca</option>
                            <optgroup label="Marcas de Sapatilhas">
                                @foreach(['Nike', 'Adidas', 'Puma', 'New Balance', 'Reebok'] as $marca)
                                <option value="{{ $marca }}" {{ old('marca') == $marca ? 'selected' : '' }}>{{ $marca }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Marcas de Roupas">
                                @foreach(['Zara', 'H&M', 'Pull&Bear', 'Bershka', 'Stradivarius'] as $marca)
                                <option value="{{ $marca }}" {{ old('marca') == $marca ? 'selected' : '' }}>{{ $marca }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <!-- Gênero e Categoria -->
                    <div style="margin-bottom: 1rem;">
                        <!-- Gênero -->
                        <div style="margin-bottom: 1rem;">
                            <label for="genero" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Gênero <span style="color: #e63946;">*</span>
                            </label>
                            <select id="genero" name="genero" required onchange="filterCategorias()"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                                <option value="">Seleciona o género</option>
                                @php
                                $generos = \App\Models\Categoria::select('genero')->distinct()->pluck('genero');
                                @endphp
                                @foreach($generos as $genero)
                                <option value="{{ $genero }}" {{ old('genero') == $genero ? 'selected' : '' }}>
                                    {{ ucfirst($genero) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Categoria -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="categoria" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Categoria</label>
                            <select id="categoria" name="categoria" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px;">
                                <option value="">Seleciona uma categoria</option>
                                @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->titulo }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tamanho -->
                        <div style="margin-bottom: 1rem;">
                            <label for="tamanho" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Tamanho do produto<span style="color: #e63946;">*</span>
                            </label>
                            <select id="tamanho" name="tamanho" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                                <option value="">Seleciona o tamanho do teu produto</option>
                                <option value="XS" {{ old('tamanho') == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ old('tamanho') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('tamanho') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('tamanho') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('tamanho') == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="2XL" {{ old('tamanho') == '2XL' ? 'selected' : '' }}>2XL</option>
                                <option value="3XL" {{ old('tamanho') == '3XL' ? 'selected' : '' }}>3XL</option>
                            </select>
                            @error('tamanho')
                            <div style="color: #e63946; font-size: 0.875rem;">{{ $message }}</div>
                            @enderror
                        </div>



                        <!-- Tamanho se for sapatilhas-->

                        <div style="margin-bottom: 1rem;">
                            <label for="tamanhosapatilhas" style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">
                                Tamanho das sapatilhas
                            </label>
                            <select id="tamanhosapatilhas" name="tamanhosapatilhas" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 5px;">
                                <option value="">Seleciona o tamanho das suas sapatilhas</option>
                                <option value="nenhum" {{ old('tamanhosapatilhas') == 'nenhum' ? 'selected' : '' }}>Nenhum</option>
                                <option value="35" {{ old('tamanhosapatilhas') == '35' ? 'selected' : '' }}>35</option>
                                <option value="36" {{ old('tamanhosapatilhas') == '36' ? 'selected' : '' }}>36</option>
                                <option value="37" {{ old('tamanhosapatilhas') == '37' ? 'selected' : '' }}>37</option>
                                <option value="38" {{ old('tamanhosapatilhas') == '38' ? 'selected' : '' }}>38</option>
                                <option value="39" {{ old('tamanhosapatilhas') == '39' ? 'selected' : '' }}>39</option>
                                <option value="40" {{ old('tamanhosapatilhas') == '40' ? 'selected' : '' }}>40</option>
                                <option value="41" {{ old('tamanhosapatilhas') == '41' ? 'selected' : '' }}>41</option>
                                <option value="42" {{ old('tamanhosapatilhas') == '42' ? 'selected' : '' }}>42</option>
                                <option value="43" {{ old('tamanhosapatilhas') == '43' ? 'selected' : '' }}>43</option>
                                <option value="44" {{ old('tamanhosapatilhas') == '44' ? 'selected' : '' }}>44</option>
                                <option value="45" {{ old('tamanhosapatilhas') == '45' ? 'selected' : '' }}>45</option>
                                <option value="46" {{ old('tamanhosapatilhas') == '46' ? 'selected' : '' }}>46</option>

                            </select>
                        </div>


                        <!-- Tipo de Sola -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="tipo_sola" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Tipo de Sola</label>
                            <select id="tipo_sola" name="tipo_sola"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px;">
                                <option value="">Seleciona o tipo de sola</option>
                                @foreach(['Nenhum', 'Borracha', 'EVA', 'PU', 'TPU', 'Phylon', 'Espuma', 'Outros'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo_sola') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipo de Produto -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="tipo_produto" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Tipo de Produto</label>
                            <select id="tipo_produto" name="tipo_produto" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px;">
                                <option value="">Seleciona o tipo de produto</option>
                                <option value="Sapatilhas" {{ old('tipo_produto') == 'Sapatilhas' ? 'selected' : '' }}>Sapatilhas</option>
                                <option value="Roupas" {{ old('tipo_produto') == 'Roupas' ? 'selected' : '' }}>Roupas</option>
                            </select>
                        </div>


                        <!-- Estado do Produto -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="estado" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Estado</label>
                            <select id="estado" name="estado" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px;">
                                <option value="">Seleciona o estado</option>
                                <option value="novo" {{ old('estado') == 'novo' ? 'selected' : '' }}>Novo</option>
                                <option value="semi-novo" {{ old('estado') == 'semi-novo' ? 'selected' : '' }}>Semi-novo</option>
                                <option value="usado" {{ old('estado') == 'usado' ? 'selected' : '' }}>Usado</option>
                            </select>
                            @error('estado')
                            <div style="color: #d9534f; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cores -->
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 1rem; color:#333; margin-bottom: 0.5rem;">Cores</label>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                @php
                                $cores = ['preto', 'branco', 'azul', 'vermelho', 'verde', 'amarelo', 'laranja', 'roxo', 'rosa', 'cinza', 'castanho'];
                                $oldCores = old('cores', []);
                                @endphp

                                @foreach($cores as $cor)
                                <div class="flex items-center">
                                    <input type="checkbox"
                                        name="cores[]"
                                        value="{{ $cor }}"
                                        id="cor-{{ $cor }}"
                                        {{ in_array($cor, $oldCores) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600">
                                    <label for="cor-{{ $cor }}" class="ml-2 text-sm text-gray-700">
                                        {{ ucfirst($cor) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('cores')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload da Imagem -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="imagem" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">
                                Foto do Produto <span style="color: #e63946;">*</span>
                            </label>
                            <input type="file" name="imagem" id="imagem" accept="image/*" required value="{{ old('imagem') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px;">
                            @error('imagem')
                            <div style="color: #d9534f; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror

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
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Rodapé com Botões -->
                        <div style="padding: 1rem; display: flex; justify-content: space-between; border-top: 1px solid #e0e0e0;">
                            <button type="submit"
                                style="padding: 0.5rem 1rem; background-color:rgb(36, 104, 250); border: none; border-radius: 5px; color: #FFF; font-size: 0.875rem; cursor: pointer;">
                                <i class="bi bi-send" style="margin-right: 0.25rem;"></i> Publicar Produto
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



   
</x-kaira-layout>