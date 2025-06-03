<x-kaira-layout>
  <!-- Container: fundo único e centralização vertical/horizontal com padding superior reduzido -->
  <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #F9FAFB; padding: 0.5rem 2rem;">
    
    <!-- Card central: fundo branco, sombra suave e bordas arredondadas -->
    <div style="max-width: 800px; width: 100%; background-color: #F9FAFB; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem; margin: 1rem;">
      
      <!-- Cabeçalho -->
      <div style="text-align: center; margin-bottom: 1rem;">
        <h1 style="font-size: 1.875rem; font-weight: 600; color: #333;">Contacte-nos</h1>
        <p style="margin-top: 0.5rem; font-size: 0.875rem; color: #6c757d;">
          Tem alguma dúvida ou problema? Preencha o formulário abaixo e a nossa equipa entrará em contacto o mais brevemente possível.
        </p>
      </div>

      <!-- Mensagem de sucesso -->
      @if(session('success'))
        <div style="background-color: #d1e7dd; border: 1px solid #badbcc; color: #0f5132; padding: 0.75rem; border-radius: 4px; text-align: center;" role="alert">
          <p>{{ session('success') }}</p>
        </div>
      @endif

      <!-- Formulário de contacto -->
      <form action="{{ route('contactos.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 0.75rem;">
        @csrf

        <!-- Campo Nome -->
        <div>
          <label for="nome" style="display: block; font-size: 0.875rem; font-weight: 500; color: #333; margin-bottom: 0.5rem;">Nome *</label>
          <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required
                 style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ccc; border-radius: 4px; outline: none;">
          @error('nome')
            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Campo Email -->
        <div>
          <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #333; margin-bottom: 0.5rem;">Email *</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}" required
                 style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ccc; border-radius: 4px; outline: none;">
          @error('email')
            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Campo Telefone (opcional) -->
        <div>
          <label for="telefone" style="display: block; font-size: 0.875rem; font-weight: 500; color: #333; margin-bottom: 0.5rem;">Telefone (opcional)</label>
          <input type="tel" name="telefone" id="telefone" value="{{ old('telefone') }}"
                 style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ccc; border-radius: 4px; outline: none;">
          @error('telefone')
            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Campo Mensagem -->
        <div>
          <label for="mensagem" style="display: block; font-size: 0.875rem; font-weight: 500; color: #333; margin-bottom: 0.5rem;">Mensagem *</label>
          <textarea name="mensagem" id="mensagem" rows="5" required
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ccc; border-radius: 4px; outline: none;">{{ old('mensagem') }}</textarea>
          @error('mensagem')
            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Botão de envio -->
        <div style="text-align: center;">
          <button type="submit"
                  style="width: 100%; padding: 0.75rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; font-weight: 600; border: none; border-radius: 4px; cursor: pointer;">
            Enviar mensagem
          </button>
        </div>
      </form>
    </div>
  </div>
</x-kaira-layout>
