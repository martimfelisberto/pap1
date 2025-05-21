<x-kaira-layout>
  <section id="billboard" style="padding: 2rem 0; background-color: #F9FAFB;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
      <!-- Cabeçalho -->
      <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: bold; color: #333; margin: 0;">Em Destaque</h1>
        <p style="font-size: 1rem; color: #666; margin-top: 0.5rem;">
          Moda sustentável e cheia de estilo! Aqui celebramos o charme e a autenticidade das roupas de segunda mão.
          Descubra peças únicas e mergulhe no universo da moda sustentável!
        </p>
      </div>

      <!-- Slider Principal -->
      <div style="position: relative;">
        <!-- Swiper Wrapper -->
        <div class="swiper" style="overflow: hidden;">
          <div class="swiper-wrapper" style="display: flex; gap: 1rem; transition: transform 0.3s ease;">
            @foreach($produtosDestaque as $produto)
            <div class="swiper-slide" style="flex: 0 0 calc(100%/5 - 1rem);">
              <div style="background-color: #FFF; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <!-- Imagem -->
                <div style="overflow: hidden;">
                  <a href="{{ route('produtos.show', $produto) }}">
                    <img src="{{ asset('storage/' . json_decode($produto->imagem)[0]) }}"
                         alt="{{ $produto->nome }}"
                         style="width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s;">
                  </a>
                </div>
                <!-- Conteúdo -->
                <div style="padding: 1rem; text-align: center;">
                  <h5 style="margin: 0 0 0.5rem; font-size: 1rem; font-weight: 600; text-transform: uppercase;">
                    <a href="{{ route('produtos.show', $produto) }}" style="text-decoration: none; color:rgb(4, 23, 85);">
                        {{ $produto->nome }}
                    </a>
                  </h5>
                  <p style="font-size: 0.875rem; color: #666; margin: 0 0 1rem;">
                    {{ number_format($produto->preco, 2) }}€
                  </p>
                  <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-heart-fill" style="color: #d9534f;"></i>
                    <span style="color: #666;">{{ $produto->favoritos_count }}</span>
                  </div>
                  
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Navegação com Setas -->
        <div style="position: absolute; top: 50%; left: 0; transform: translateY(-50%); cursor: pointer;">
          <svg width="50" height="50" viewBox="0 0 24 24">
            <use xlink:href="#arrow-left"></use>
          </svg>
        </div>
        <div style="position: absolute; top: 50%; right: 0; transform: translateY(-50%); cursor: pointer;">
          <svg width="50" height="50" viewBox="0 0 24 24">
            <use xlink:href="#arrow-right"></use>
          </svg>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" style="padding: 2rem 0; background-color: #F9FAFB;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem;">
        <!-- Embalagem Especial -->
        <div style="flex: 1 1 45%; text-align: center;" data-aos="fade-in" data-aos-delay="600">
          <div style="padding: 2rem;">
            <svg width="38" height="38" viewBox="0 0 24 24" style="fill: rgb(4, 23, 85);">
              <use xlink:href="#gift"></use>
            </svg>
            <h4 style="margin: 1rem 0; font-size: 1.25rem; font-weight: 600; text-transform: capitalize;">Embalagem Especial</h4>
            <p style="font-size: 1rem; color: #666; line-height: 1.5;">
              Para ocasiões especiais, oferecemos embalagem personalizada. Garantimos que os seus presentes cheguem em perfeitas condições.
            </p>
          </div>
        </div>
        <!-- Devoluções Globais Gratuitas -->
        <div style="flex: 1 1 45%; text-align: center;" data-aos="fade-in" data-aos-delay="900">
          <div style="padding: 2rem;">
            <svg width="38" height="38" viewBox="0 0 24 24" style="fill: rgb(4, 23, 85);">
              <use xlink:href="#arrow-cycle"></use>
            </svg>
            <h4 style="margin: 1rem 0; font-size: 1.25rem; font-weight: 600; text-transform: capitalize;">Devoluções Globais Gratuitas</h4>
            <p style="font-size: 1rem; color: #666; line-height: 1.5;">
              Acreditamos na qualidade das nossas peças. Oferecemos devoluções gratuitas em todo o mundo, sem custos adicionais.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Categories Section -->
  <section id="categories" style="padding: 2rem 0; background-color: #FFF;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
      <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
        <!-- Categoria 1 -->
        <div style="flex: 1 1 30%;" data-aos="zoom-out">
          <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <a href="{{ route('produtos.categoria', ['categoria' => 'casacos', 'genero' => 'homem']) }}" style="display: block; overflow: hidden;">
              <img src="{{ asset('/images/homem.jpg') }}" alt="Casacos para Homem" style="width: 100%; display: block;">
            </a>
            <div style="padding: 1rem; text-align: center;">
              <a href="{{ route('produtos.categoria', ['categoria' => 'casacos', 'genero' => 'homem']) }}"
                 style="display: inline-block; padding: 0.75rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; text-transform: uppercase; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                Comprar casacos para homem
              </a>
            </div>
          </div>
        </div>
        <!-- Categoria 2 -->
        <div style="flex: 1 1 30%;" data-aos="zoom-out" data-aos-delay="200">
          <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <a href="{{ route('produtos.categoria', ['categoria' => 'sapatilhas', 'genero' => 'mulher']) }}" style="display: block; overflow: hidden;">
              <img src="{{ asset('/images/mulher.jpg') }}" alt="Sapatilhas para Mulher" style="width: 100%; display: block;">
            </a>
            <div style="padding: 1rem; text-align: center;">
              <a href="{{ route('produtos.categoria', ['categoria' => 'sapatilhas', 'genero' => 'mulher']) }}"
                 style="display: inline-block; padding: 0.75rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; text-transform: uppercase; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                Comprar sapatilhas para mulher
              </a>
            </div>
          </div>
        </div>
        <!-- Categoria 3 -->
        <div style="flex: 1 1 30%;" data-aos="zoom-out" data-aos-delay="400">
          <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <a href="{{ route('produtos.categoria', ['categoria' => 'calcas', 'genero' => 'criança']) }}" style="display: block; overflow: hidden;">
              <img src="{{ asset('/images/criança.jpg') }}" alt="Calças para Criança" style="width: 100%; display: block;">
            </a>
            <div style="padding: 1rem; text-align: center;">
              <a href="{{ route('produtos.categoria', ['categoria' => 'calcas', 'genero' => 'criança']) }}"
                 style="display: inline-block; padding: 0.75rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; text-transform: uppercase; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                Comprar calças para criança
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Collection Section -->
  <section id="collection" style="padding: 2rem 0; background-color: #fff; position: relative;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
      <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 2rem;">
        <div style="flex: 1 1 50%;">
          <!-- Espaço para imagem ou conteúdo visual -->
        </div>
        <div style="flex: 1 1 50%; background-color: #FFF; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <div style="padding: 2rem;">
            <h3 style="font-size: 1.75rem; font-weight: 600; text-transform: uppercase; color: #333; margin: 0 0 1rem;">A nossa loja</h3>
            <p style="font-size: 1rem; color: #666; line-height: 1.5;">
              Na Reshopping.pt, acreditamos que a moda pode ser sustentável, acessível e solidária. Ao
              escolher roupas em segunda mão, você encontra peças únicas e cheias de história, além de contribuir
              para um planeta mais verde, promovendo o consumo consciente.
            </p>
            <a href="#" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; text-transform: uppercase; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
              Descubra as categorias em destaque!
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Instagram Section -->
  <section id="instagram" style="position: relative; padding: 2rem 0; background-color: #FFF;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; text-align: center;">
      <a href="https://www.instagram.com/reshopping.pt/" 
         style="display: inline-block; padding: 1rem 2rem; background-color:rgb(4, 23, 85); color: #FFF; text-transform: uppercase; text-decoration: none; border-radius: 4px;">
        Segue-nos no Instagram!
      </a>
    </div>
  </section>
</x-kaira-layout>
