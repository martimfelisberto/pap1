<x-kaira-layout>
  

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
  <section id="categories" style="padding: 2rem 0; background-color: #F9FAFB;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
      <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
        <!-- Categoria 1 -->
        <div style="flex: 1 1 30%;" data-aos="zoom-out">
          <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <a href="{{ route('produtos.categoria', ['categoria' => 'casacos', 'genero' => 'homem']) }}" style="display: block; overflow: hidden;">
              <img src="{{ asset('/images/homem.jpg') }}" alt="Casacos para Homem" style="width: 100%; display: block;">
            </a>
            <div style="padding: 1rem; text-align: center;">
              <a href="{{ Auth::check() ? route('produtos.categoria', ['categoria' => 'casacos', 'genero' => 'homem']) : route('login') }}"
                 style="display: inline-block; padding: 0.75rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; text-transform: uppercase; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                Comprar casacos para homem
              </a>
            </div>
          </div>
        </div>
        <!-- Categoria 2 -->
        <div style="flex: 1 1 30%;" data-aos="zoom-out" data-aos-delay="200">
          <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <a href="{{ route('produtos.categoria', ['categoria' => 'Sapatilhas', 'genero' => 'Mulher']) }}" style="display: block; overflow: hidden;">
              <img src="{{ asset('/images/mulher.jpg') }}" alt="Sapatilhas para Mulher" style="width: 100%; display: block;">
            </a>
            <div style="padding: 1rem; text-align: center;">
              <a href="{{ Auth::check() ? route('produtos.categoria', ['categoria' => 'sapatilhas', 'genero' => 'mulher']) : route('login') }}"
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
              <a href="{{ Auth::check() ? route('produtos.categoria', ['categoria' => 'calcas', 'genero' => 'criança']) : route('login') }}"
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
  <section id="collection" style="padding: 2rem 0; background-color: #F9FAFB; position: relative;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
      <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 2rem;">
        <div style="flex: 1 1 50%;">
          <!-- Espaço para imagem ou conteúdo visual -->
        </div>
        <div style="flex: 1 1 50%; background-color: #F9FAFB; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <div style="padding: 2rem;">
            <h3 style="font-size: 1.75rem; font-weight: 600; text-transform: uppercase; color: #333; margin: 0 0 1rem;">A nossa loja</h3>
            <p style="font-size: 1rem; color: #666; line-height: 1.5;">
              Na Reshopping.pt, acreditamos que a moda pode ser sustentável, acessível e solidária. Ao
              escolher roupas em segunda mão, você encontra peças únicas e cheias de história, além de contribuir
              para um planeta mais verde, promovendo o consumo consciente.
            </p>
            <a href="https://www.instagram.com/reshopping.pt/" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; text-transform: uppercase; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
            Segue-nos no Instagram!
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

</x-kaira-layout>
