<x-kaira-layout>
    <div style="max-width: 1024px; margin: 0 auto; padding: 2rem 1rem;">
        <!-- Cabeçalho -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: bold; color: #333; margin: 0;">Nova Categoria</h1>
            <a href="{{ route('categorias.index') }}"
                style="padding: 0.5rem 1rem; border: 1px solid #CCC; color: #666; border-radius: 4px; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center;">
                <i class="bi bi-arrow-left" style="margin-right: 0.5rem;"></i> Voltar
            </a>
        </div>

        <!-- Card de Formulário -->
        <div style="background-color: #FFF; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 2rem;">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <!-- Campo Título -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="titulo" style="display: block; font-size: 1rem; font-weight: 500; color: #333; margin-bottom: 0.5rem;">Título</label>

                    <input type="text" id="titulo" name="titulo"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;"
                        class="@error('titulo') is-invalid @enderror"
                        placeholder="Digite ou seleciona um título..."
                        value="{{ old('titulo') }}"
                        list="tituloOptions">
                    @error('titulo')
                    <div style="color: #d9534f; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Gênero -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="genero" style="display: block; font-size: 1rem; font-weight: 500; color: #333; margin-bottom: 0.5rem;">Gênero</label>
                    <div style="display: flex; gap: 1rem;">
                        <input type="text" id="genero" name="genero"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;"
                            class="@error('genero') is-invalid @enderror"
                            placeholder="Digite o género..."
                            value="{{ old('genero') }}">
                    </div>
                    @error('genero')
                    <div style="color: #d9534f; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>
                

                <!-- Botão de Envio -->
                <div style="text-align: right;">
                    <button type="submit"
                        style="padding: 0.75rem 1.5rem; background-color: rgb(39, 104, 250); color: #FFF; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer;">
                        <i class="bi bi-save" style="margin-right: 0.5rem;"></i> Guardar Categoria
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-kaira-layout>