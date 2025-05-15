<x-kaira-layout>
  <div style="max-width: 600px; margin: 0 auto; padding: 2rem 1rem;">
    <!-- Cabeçalho -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
      <h1 style="font-size: 1.75rem; font-weight: 600; color: #333; margin: 0;">Editar Utilizador</h1>
      <a href="{{ route('users.index') }}" 
         style="padding: 0.5rem 1rem; background-color:#6B7280; color: #FFF; border-radius: 4px; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center;">
        <i class="bi bi-arrow-left" style="margin-right: 0.5rem;"></i> Voltar
      </a>
    </div>

    <!-- Mensagem de Feedback -->
    @if(session('success'))
      <div style="padding: 0.75rem; background-color: #DCFCE7; border: 1px solid #16A34A; border-radius: 4px; margin-bottom: 1rem; color: #16A34A; position: relative;">
        {{ session('success') }}
        <button onclick="this.parentElement.style.display = 'none'" 
                style="background: none; border: none; position: absolute; top: 0.25rem; right: 0.5rem; font-size: 1.25rem; line-height: 1; cursor: pointer;">&times;</button>
      </div>
    @endif

    <!-- Formulário de Edição -->
    <div style="background-color: #FFF; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 2rem;">
      <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Campo Nome -->
        <div style="margin-bottom: 1.5rem;">
          <label for="name" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Nome</label>
          <input type="text" id="name" name="name"
                 style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;"
                 class="@error('name') is-invalid @enderror"
                 value="{{ old('name', $user->name) }}" required>
          @error('name')
            <div style="color: #d9534f; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
          @enderror
        </div>

        <!-- Campo Email -->
        <div style="margin-bottom: 1.5rem;">
          <label for="email" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Email</label>
          <input type="email" id="email" name="email"
                 style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;"
                 class="@error('email') is-invalid @enderror"
                 value="{{ old('email', $user->email) }}" required>
          @error('email')
            <div style="color: #d9534f; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
          @enderror
        </div>

        <!-- Campo Administrador -->
        <div style="margin-bottom: 1.5rem;">
          <label for="is_admin" style="display: block; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">Administrador</label>
          <select id="is_admin" name="is_admin"
                  style="width: 100%; padding: 0.75rem; border: 1px solid #CCC; border-radius: 4px; font-size: 1rem;">
            <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Sim</option>
            <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>Não</option>
          </select>
          @error('is_admin')
            <div style="color: #d9534f; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
          @enderror
        </div>

        <!-- Botão de Envio -->
        <div style="text-align: right;">
          <button type="submit" 
                  style="padding: 0.75rem 1.5rem; background-color: #2563EB; color: #FFF; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer;">
            <i class="bi bi-save" style="margin-right: 0.5rem;"></i> Salvar Alterações
          </button>
        </div>
      </form>
    </div>
  </div>
</x-kaira-layout>
