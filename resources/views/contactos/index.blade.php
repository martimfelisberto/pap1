<x-kaira-layout>
  <div style="max-width: 1280px; margin: 0 auto; padding: 2rem 1rem;">
    
    
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

    <!-- Tabela de Contactos -->
    <div style="background-color: #FFF; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
      <div style="padding: 1rem;">
        <div style="overflow-x: auto;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #F3F4F6; text-align: left;">
              <tr>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Nome</th>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Email</th>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Telefone</th>
                <th style="padding: 0.75rem; border-bottom: 2px solid #E5E7EB;">Ações</th>
              </tr>
            </thead>
            <tbody>
         
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Paginação -->
    <div style="margin-top: 1rem;">
      {{ $contacts->links() }}
    </div>
  </div>
</x-kaira-layout>
