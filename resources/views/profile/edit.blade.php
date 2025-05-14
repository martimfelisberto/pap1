<x-kaira-layout>
    <!-- Header de Perfil (Display) -->
    <div style="padding: 2rem 0; background-color: #F9FAFB;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
            <!-- Card do Perfil -->
            <div style="background-color: #FFF; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 20px; padding: 2rem; margin-bottom: 2rem; position: relative;">
                <div style="display: flex; align-items: center;">

                    <div style="margin-left: 1.5rem;">
                        <h1 style="font-size: 2rem; font-weight: bold; color: #333; margin: 0;">{{ $user->name }}</h1>
                    </div>
                </div>

                <!-- "Membro desde" no canto inferior direito -->
                <div style="position: absolute; bottom: 10px; right: 10px; font-size: 0.875rem; color: #666;">
                    Membro desde {{ $user->created_at->format('d/m/Y') }}
                </div>

                <!-- Seções de Atualização do Perfil (sem repetir a função de alteração da foto) -->
                <div style="padding: 2rem 0; background-color: #F9FAFB;">
                    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 2rem;">

                        <!-- Seções de Atualização do Perfil -->
                        <div style="padding: 3rem 0; background-color: #F9FAFB;">
                            <div style="max-width: 1280px; margin: 0 auto; padding: 0 1rem;">
                                <!-- Profile Photo Section -->
                                <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                                    <!-- Member since text -->
                                    <!-- Member since text -->
                                    <div style="position: absolute; top: 1.5rem; right: 1.5rem; font-size: 0.875rem; color: #666;">
                                        Membro desde {{ $user->created_at->format('d/m/Y') }}
                                    </div>


                                    <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 1rem;">Foto de Perfil</h2>
                                    <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
                                        @csrf
                                        @method('PATCH')
                                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                                            <!-- Current Photo -->
                                            <div style="position: relative;">
                                                @if($user->profile_photo)
                                                <div style="width: 96px; height: 96px; border-radius: 50%; border: 4px solid #cce5ff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
                                                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                                        alt="Profile photo"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                                @else
                                                <div style="width: 96px; height: 96px; border-radius: 50%; 
                                            background: linear-gradient(to right, #3b82f6, #1e40af); 
                                            border: 4px solid #cce5ff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
                                            display: flex; align-items: center; justify-content: center;">
                                                    <span style="font-size: 1.5rem; font-weight: bold; color: #FFF;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Upload New Photo -->
                                            <div style="flex: 1;">
                                                <input type="file"
                                                    name="profile_photo"
                                                    id="profile_photo"
                                                    accept="image/*"
                                                    style="width: 100%; padding: 0.5rem; font-size: 0.875rem; border: 1px solid #ccc; border-radius: 4px;">
                                                <p style="margin-top: 0.5rem; font-size: 0.875rem; color: #6c757d;">PNG, JPG até 2MB</p>
                                            </div>
                                        </div>
                                        @error('profile_photo')
                                        <p style="color: #e63946; font-size: 0.875rem;">{{ $message }}</p>
                                        @enderror
                                        <div style="display: flex; justify-content: flex-end;">
                                            <button type="submit" style="padding: 0.5rem 1rem; background-color: #3b82f6; color: #FFF; border: none; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                                Atualizar Foto
                                            </button>
                                        </div>
                                    </form>
                                </div>


                                <!-- Informações do Perfil -->
                                <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
                                    <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 1rem;">Informações do Perfil</h2>
                                    <form action="{{ route('profile.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                                        @csrf
                                        @method('PATCH')
                                        <div>
                                            <label for="name" style="display: block; font-size: 0.875rem; color: #333; margin-bottom: 0.5rem;">Nome</label>
                                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                            @error('name')
                                            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="email" style="display: block; font-size: 0.875rem; color: #333; margin-bottom: 0.5rem;">Email</label>
                                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                            @error('email')
                                            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div style="display: flex; justify-content: flex-end;">
                                            <button type="submit" style="padding: 0.5rem 1rem; background-color: rgb(36, 104, 250); color: #FFF; border: none; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                                Atualizar Informações
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Alterar Password -->
                                <div style="background-color: #FFF; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
                                    <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin-bottom: 1rem;">Alterar Password</h2>
                                    <form action="{{ route('profile.password') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label for="current_password" style="display: block; font-size: 0.875rem; color: #333; margin-bottom: 0.5rem;">Password Atual</label>
                                            <input type="password"
                                                name="current_password"
                                                id="current_password"
                                                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                            @error('current_password')
                                            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- New Password -->
                                        <div>
                                            <label for="password" style="display: block; font-size: 0.875rem; color: #333; margin-bottom: 0.5rem;">Nova Password</label>
                                            <input type="password"
                                                name="password"
                                                id="password"
                                                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                            @error('password')
                                            <p style="color: #e63946; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Confirm New Password -->
                                        <div>
                                            <label for="password_confirmation" style="display: block; font-size: 0.875rem; color: #333; margin-bottom: 0.5rem;">Confirmar Nova Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                        </div>
                                        <div style="display: flex; justify-content: flex-end;">
                                            <button type="submit" style="padding: 0.5rem 1rem; background-color: rgb(36, 104, 250); color: #FFF; border: none; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                                Atualizar Password
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Row com 3 cols para Produtos, Favoritos e Vendas -->
                                <div style="display: flex; justify-content: space-between;">
                                    <!-- Coluna 1: Produtos -->
                                    <div style="flex: 1; text-align: center; margin: 0 0.5rem;">
                                        <div style="padding: 1rem; background-color: #FFF; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                            <i class="bi bi-bag" style="color: rgb(36, 104, 250); font-size: 1.5rem;"></i>
                                            <div style="font-size: 1.25rem; font-weight: bold; margin-top: 0.5rem;">
                                                {{ optional($user->produtos)->count() ?? 0 }}
                                            </div>
                                            <div style="color: #666;">Produtos</div>
                                        </div>
                                    </div>
                                    <!-- Coluna 2: Favoritos -->
                                    <div style="flex: 1; text-align: center; margin: 0 0.5rem;">
                                        <div style="padding: 1rem; background-color: #FFF; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                            <i class="bi bi-heart-fill" style="color: #d9534f; font-size: 1.5rem;"></i>
                                            <div style="font-size: 1.25rem; font-weight: bold; margin-top: 0.5rem;">
                                                {{ optional($user->favoriteProdutos)->count() ?? 0 }}
                                            </div>
                                            <div style="color: #666;">Favoritos</div>
                                        </div>
                                    </div>
                                    <!-- Coluna 3: Vendas -->
                                    <di style="flex: 1; text-align: center; margin: 0 0.5rem;">
                                        <div style="padding: 1rem; background-color: #FFF; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                            <i class="bi bi-cart-check" style="color: #5cb85c; font-size: 1.5rem;"></i>
                                            <div style="font-size: 1.25rem; font-weight: bold; margin-top: 0.5rem;">
                                                {{ optional($user->vendas)->count() ?? 0 }}
                                            </div>
                                            <div style="color: #666;">Vendas</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Script para preview da imagem (caso implemente atualização via outro componente) -->
                    @push('scripts')
                    <script>
                        // Caso seja necessário prever a nova imagem de perfil (exemplo para outro input)
                        document.getElementById('profile_photo')?.addEventListener('change', function(e) {
                            if (e.target.files && e.target.files[0]) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const img = document.querySelector('[style*="border-radius: 50%"] img');
                                    if (img) {
                                        img.src = e.target.result;
                                    }
                                }
                                reader.readAsDataURL(e.target.files[0]);
                            }
                        });

                        document.addEventListener('DOMContentLoaded', function() {
                            // Tab functionality
                            const tabButtons = document.querySelectorAll('.tab-button');
                            const tabContents = document.querySelectorAll('.tab-content');

                            tabButtons.forEach(button => {
                                button.addEventListener('click', () => {
                                    // Remove active classes
                                    tabButtons.forEach(btn => {
                                        btn.classList.remove('active');
                                        btn.classList.remove('text-warning');
                                        btn.classList.remove('border-warning');
                                        btn.classList.add('text-gray-500');
                                        btn.classList.add('border-transparent');
                                    });

                                    // Hide all tab contents
                                    tabContents.forEach(content => {
                                        content.classList.add('hidden');
                                    });

                                    // Show active tab
                                    button.classList.add('active');
                                    button.classList.add('text-warning');
                                    button.classList.add('border-warning');
                                    button.classList.remove('text-gray-500');
                                    button.classList.remove('border-transparent');

                                    const targetId = button.dataset.target;
                                    document.getElementById(targetId).classList.remove('hidden');
                                });
                            });

                            // Profile photo preview
                            const photoInput = document.getElementById('profile_photo_upload');
                            const photoPreview = document.querySelector('.profile-photo-preview');

                            if (photoInput) {
                                photoInput.addEventListener('change', function(e) {
                                    if (this.files && this.files[0]) {
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            if (photoPreview) {
                                                photoPreview.style.backgroundImage = `url('${e.target.result}')`;
                                            }
                                        }

                                        reader.readAsDataURL(this.files[0]);
                                    }
                                });
                            }

                            // Animation for cards
                            const animateCards = () => {
                                const cards = document.querySelectorAll('.card-animate');
                                cards.forEach(card => {
                                    const rect = card.getBoundingClientRect();
                                    const isVisible = (rect.top >= 0 && rect.bottom <= window.innerHeight);

                                    if (isVisible) {
                                        card.classList.add('animate-fade-in');
                                    }
                                });
                            };

                            // Initial animation check
                            animateCards();

                            // Animate on scroll
                            window.addEventListener('scroll', animateCards);
                        });
                    </script>
                    @endpush


                    <!-- Add this in the head section or in your layout file -->
                    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
</x-kaira-layout>