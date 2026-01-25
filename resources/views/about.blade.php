<x-web-layout>

    <!--Page Title-->
    <section class="page-title">
      <div class="auto-container">
        <div class="title-outer">
          <h1>Sobre Nós</h1>
          <ul class="page-breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li>Sobre Nós</li>
          </ul>
        </div>
      </div>
    </section>
    <!--End Page Title-->

    <!-- Disclaimer Section -->
    <section class="about-section-three" style="padding: 40px 0;">
      <div class="auto-container">
        <div class="alert alert-info" style="background-color: #e3f2fd; border: 2px solid #1967d2; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
          <div style="display: flex; align-items: center;">
            <svg style="width: 24px; height: 24px; margin-right: 15px; flex-shrink: 0;" fill="#1967d2" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <p style="margin: 0; color: #1565c0; font-size: 15px; line-height: 1.6; font-weight: 500;">
              <strong>Aviso Importante:</strong> Este portal é independente e não possui qualquer vínculo com o programa "Emprega Paulínia" da Prefeitura Municipal de Paulínia. Todas as oportunidades e informações publicadas aqui são de responsabilidade dos anunciantes e usuários do site.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- End Disclaimer Section -->

    <!-- About Section Three -->
    <section class="about-section-three">
      <div class="auto-container">
        <div class="text-box">
          <h4>Sobre o Portal Emprega Paulínia</h4>
          <p>O Portal Emprega Paulínia nasceu com o objetivo de conectar talentos e oportunidades na região de Paulínia e arredores. Percebemos a necessidade de criar uma plataforma digital moderna e acessível, onde candidatos em busca de oportunidades de trabalho pudessem encontrar vagas relevantes, e empresas locais pudessem divulgar suas posições em aberto de forma simples e eficiente.</p>
          <p>Nossa missão é facilitar o processo de recrutamento e seleção, tornando-o mais ágil e transparente para todos os envolvidos. Acreditamos que toda pessoa merece encontrar uma oportunidade que valorize suas competências e experiências, e que toda empresa merece encontrar os profissionais ideais para compor sua equipe.</p>
          <p>Com ferramentas intuitivas e recursos desenvolvidos especialmente para atender as necessidades do mercado de trabalho local, oferecemos um espaço onde candidatos podem criar seus perfis profissionais, anexar currículos e se candidatar às vagas de interesse, enquanto empregadores têm acesso a um banco de talentos qualificados e podem gerenciar todo o processo seletivo em um só lugar.</p>
          <p>O Portal Emprega Paulínia é mantido de forma independente, com o compromisso de ser uma ferramenta útil e confiável para a comunidade. Trabalhamos continuamente para melhorar a experiência de nossos usuários e contribuir para o desenvolvimento profissional e econômico da região.</p>
        </div>
      </div>
    </section>
    <!-- End About Section Three -->

    <!-- Call To Action Two -->
    <section class="call-to-action-two" style="background-image: url(images/background/1.jpg);">
      <div class="auto-container">
        <div class="sec-title light text-center">
          <h2>As Vagas dos Seus Sonhos Estão Esperando</h2>
          <div class="text">Conectando talentos e oportunidades em Paulínia e região.</div>
        </div>

        <div class="btn-box">
          <a href="{{ route('jobs') }}" class="theme-btn btn-style-three">Buscar Vagas</a>
          <a href="{{ route('register') }}" class="theme-btn btn-style-two">Cadastre-se Agora</a>
        </div>
      </div>
    </section>
    <!-- End Call To Action -->

        <!-- Work Section -->
    <section class="work-section style-two">
      <div class="auto-container">
        <div class="sec-title text-center">
          <h2>Como Funciona?</h2>
          <div class="text">Oportunidades para todos, em qualquer lugar</div>
        </div>

        <div class="row">
          <!-- Work Block -->
          <div class="work-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <figure class="image"><img src="images/resource/work-1.png" alt=""></figure>
              <h5>Crie Seu Perfil Gratuitamente</h5>
              <p>Cadastre-se, anexe seu currículo e complete seu perfil profissional para que as empresas possam encontrar você.</p>
            </div>
          </div>

          <!-- Work Block -->
          <div class="work-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <figure class="image"><img src="images/resource/work-2.png" alt=""></figure>
              <h5>Encontre Vagas Compatíveis</h5>
              <p>Navegue por centenas de oportunidades e candidate-se às vagas que mais combinam com seu perfil e experiência.</p>
            </div>
          </div>

          <!-- Work Block -->
          <div class="work-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box">
              <figure class="image"><img src="images/resource/work-3.png" alt=""></figure>
              <h5>Acompanhe Suas Candidaturas</h5>
              <p>Gerencie todas as suas aplicações em um só lugar e receba notificações sobre o andamento de cada processo seletivo.</p>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- End Work Section -->

</x-web-layout>