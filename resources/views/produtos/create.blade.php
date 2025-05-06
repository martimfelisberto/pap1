<x-kaira-layout>
    @section('content')
        <div id="page-about" class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <br>
                    <h1>Vender um Produto</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Basic fields -->
                        <div class="form-group">
                            <label for="nome">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="preco">Preço</label>
                            <input type="number" class="form-control" id="preco" name="preco" step="0.01" required>
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

                        <!-- Categoria e Tamanhos Dinâmicos -->
                        <div class="form-group">
                            <label for="categoria">Categoria</label>
                            <select class="form-control" id="categoria" name="categoria" required>
                                <option value="">Selecione uma categoria</option>
                                <option value="sapatilhas">Sapatilhas</option>
                                <option value="tshirts">T-Shirts</option>
                                <option value="calcas">Calças</option>
                                <option value="calcoes">Calções</option>
                                <option value="camisolas">Camisolas</option>
                                <option value="casacos">Casacos</option>
                            </select>
                        </div>

                        <!-- Tamanhos Dinâmicos -->
                        <div class="form-group">
                            <label for="tamanho">Tamanho</label>
                            <select class="form-control" id="tamanho" name="tamanho" required>
                                <option value="">Selecione o tamanho</option>
                            </select>
                        </div>

                        <!-- Especificações de Sapatilhas -->
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

                        <div class="form-group">
                            <label for="imagem">Imagem do Produto</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            const tamanhosPorCategoria = {
                sapatilhas: Array.from({length: 12}, (_, i) => (35 + i).toString()),
                calcas: ['34', '36', '38', '40', '42', '44', '46', '48'],
                default: ['XS', 'S', 'M', 'L', 'XL', 'XXL']
            };

            document.getElementById('categoria').addEventListener('change', function() {
                const categoria = this.value;
                const tamanhoSelect = document.getElementById('tamanho');
                const especSapatilhas = document.getElementById('especificacoes-sapatilhas');
                const especRoupas = document.getElementById('especificacoes-roupas');

                // Clear existing options
                tamanhoSelect.innerHTML = '<option value="">Selecione o tamanho</option>';

                // Add new options based on category
                const tamanhos = categoria === 'sapatilhas' 
                    ? tamanhosPorCategoria.sapatilhas 
                    : categoria === 'calcas'
                        ? tamanhosPorCategoria.calcas
                        : tamanhosPorCategoria.default;

                tamanhos.forEach(tamanho => {
                    const option = document.createElement('option');
                    option.value = tamanho;
                    option.textContent = tamanho;
                    tamanhoSelect.appendChild(option);
                });

                // Show/hide specifications
                especSapatilhas.style.display = categoria === 'sapatilhas' ? 'block' : 'none';
                especRoupas.style.display = ['tshirts', 'calcas', 'calcoes', 'camisolas', 'casacos'].includes(categoria) ? 'block' : 'none';
            });
        </script>
    @endsection
</x-kaira-layout>


