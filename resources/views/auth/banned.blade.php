<x-quickbites-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-danger">
                    <div class="card-header bg-danger text-white text-center py-3">
                        <h3 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Conta Suspensa</h3>
                    </div>
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <div class="rounded-circle bg-light d-inline-flex justify-content-center align-items-center mb-4"
                                style="width: 120px; height: 120px;">
                                <i class="bi bi-lock-fill text-danger fs-1"></i>
                            </div>
                        </div>
                        
                        
                        <h4 class="mb-4">A sua conta foi suspensa</h4>
                        
                        <p class="lead mb-4">
                            Lamentamos informar que a sua conta foi suspensa por violar os termos de utilização do QuickBites.
                        </p>
                        
                        <div class="alert alert-light border mb-4">
                            <p class="mb-0">
                                Se acredita que isto foi um erro ou deseja apelar desta decisão, por favor contacte a nossa equipe de suporte.
                            </p>
                        </div>
                        
                        <div class="d-grid gap-3">
                            <a href="mailto:suporte@quickbites.com" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-envelope me-2"></i>Contactar Suporte
                            </a>
                            <a href="{{ route('welcome') }}" class="btn btn-secondary">
                                <i class="bi bi-house-door me-2"></i>Voltar à Página Inicial
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-muted">
                                    <i class="bi bi-box-arrow-right me-1"></i>Terminar Sessão
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center py-3">
                        <small class="text-muted">
                            Para mais informações, consulte os nossos <a href="#">Termos de Utilização</a> e <a href="#">Política de Privacidade</a>.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-quickbites-layout>
