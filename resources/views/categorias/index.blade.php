<x-kaira-layout>
  <div style="max-width: 1280px; margin: 0 auto; padding: 2rem 1rem;">
    <!-- Cabeçalho -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
      <h1 style="font-size: 1.75rem; font-weight: 600; color: #333; margin: 0;">Categorias</h1>
      <a href="{{ route('categorias.create') }}" 
         style="padding: 0.5rem 1rem; background-color:rgb(36, 104, 250); color: #FFF; border-radius: 4px; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center;">
        <i class="bi bi-plus-circle" style="margin-right: 0.5rem;"></i> Nova Categoria
      </a>
    </div>

    <!-- Mensagens de Feedback -->
    @if(session('success'))
      <div style="padding: 0.75rem; background-color: #DCFCE7; border: 1px solid #16A34A; border-radius: 4px; margin-bottom: 1rem; color: #16A34A; position: relative;">
        {{ session('success') }}
        <button onclick="this.parentElement.style.display = 'none'" 
                style="background: none; border: none; position: absolute; top: 0.25rem; right: 0.5rem; font-size: 1.25rem; line-height: 1; cursor: pointer;">&times;</button>
      </div>
    @endif

    @if(session('error'))
      <div style="padding: 0.75rem; background-color: #FEE2E2; border: 1px solid #991B1B; border-radius: 4px; margin-bottom: 1rem; color: #991B1B; position: relative;">
        {{ session('error') }}
        <button onclick="this.parentElement.style.display = 'none'" 
                style="background: none; border: none; position: absolute; top: 0.25rem; right: 0.5rem; font-size: 1.25rem; line-height: 1; cursor: pointer;">&times;</button>
      </div>
    @endif

    <!-- Tabela de Categorias -->
    <div style="background-color: #F9FAFB; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
      <div style="padding: 1rem;">
        <div style="overflow-x: auto;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #F3F4F6; text-align: left;">
              <tr>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Título</th>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Género</th>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;"></th>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Produtos</th>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Ações</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categorias as $categoria)
                <tr style="border-bottom: 1px solid #E5E7EB;">
                  <td style="padding: 0.75rem;">{{ $categoria->titulo }}</td>
                  <td style="padding: 0.75rem;">{{ ucfirst($categoria->genero) }}</td>
                  <td style="padding: 0.75rem;">{{ $categoria->categoria }}</td>
                  <td style="padding: 0.75rem;">{{ $categoria->produtos_count }}</td>
                  <td style="padding: 0.75rem;">
                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" 
                          style="display: inline;" 
                          onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                              style="padding: 0.25rem 0.5rem; background-color: transparent; border: 1px solid #E5E7EB; border-radius: 4px; color: #991B1B; cursor: pointer;">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" style="padding: 1rem; text-align: center; color: #999;">
                    <div style="margin-top: 1rem;">
                      <i class="bi bi-folder-x" style="font-size: 2.5rem;"></i>
                      <p style="margin-top: 0.5rem;">Nenhuma categoria criada.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-kaira-layout>
