@include('layouts.inc.head')

<body data-anm=".anm">

  <div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Header Span -->
    <span class="header-span"></span>

    <!-- Main Header-->
    <x-layouts.web.header />
    <!--End Main Header -->

    <x-ui.message />

    {{ $slot }}

    <!-- Ads Section -->
    <section class="ads-section">
      <div class="auto-container">
        <div class="row wow fadeInUp">
          <!-- Ads Block -->
          <div class="advrtise-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box" style="background-image: url({{ asset('images/resource/ads-bg-1.png') }});">
              <h4><span>Recruiting </span>Now</h4>
              <a href="#" class="theme-btn btn-style-one">View All</a>
            </div>
          </div>

          <!-- Ads Block -->
          <div class="advrtise-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box" style="background-image: url({{ asset('images/resource/ads-bg-2.png') }});">
              <h4><span>Membership </span>Opportunities</h4>
              <a href="#" class="theme-btn btn-style-one">View All</a>
            </div>
          </div>

          <!-- Ads Block -->
          <div class="advrtise-block col-lg-4 col-md-6 col-sm-12">
            <div class="inner-box" style="background-image: url({{ asset('images/resource/ads-bg-3.png') }});">
              <h4><span>Post a </span>Vacancy</h4>
              <a href="#" class="theme-btn btn-style-one">View All</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Ads Section -->

    <!-- Main Footer -->
    <footer class="main-footer alternate3">
      <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
          <div class="row">
            <div class="big-column col-xl-4 col-lg-3 col-md-12">
              <div class="footer-column about-widget">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.svg') }}" alt="">
                    </a>
                </div>
                <div class="text">Emprega Paulínia é uma plataforma de empregos dedicada a conectar candidatos talentosos com empresas inovadoras na região de Paulínia. Nossa missão é facilitar o processo de recrutamento, oferecendo uma experiência intuitiva e eficiente para ambos os lados.</div>
              </div>
            </div>

            <div class="big-column col-xl-8 col-lg-9 col-md-12">
              <div class="row">
                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">Para Candidatos</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="{{ route('jobs') }}">Vagas</a></li>
                        <li><a href="#">Cadastrar Currículo</a></li>
                        <li><a href="{{ route('candidate.dashboard') }}">Painel do Candidato</a></li>
                      </ul>
                    </div>
                  </div>
                </div>


                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">Para Empresas</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="{{ route('employer.dashboard') }}">Painel do Empregador</a></li>
                        <li><a href="#">Adicionar Vaga</a></li>
                        <li><a href="#">Pacotes</a></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">Sobre Nós</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="{{ route('jobs') }}">Página de Vagas</a></li>
                        <li><a href="{{ route('polices') }}">Politica de Privacidade</a></li>
                        <li><a href="{{ route('terms') }}">Termos de Uso</a></li>
                        <li><a href="#">Blog</a></li>
                      </ul>
                    </div>
                  </div>
                </div>


                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">Recursos Úteis</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Criar Conta</a></li>
                        <li><a href="{{ route('contact') }}">Contato</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!--Bottom-->
      <div class="footer-bottom">
        <div class="auto-container">
          <div class="outer-box">
            <div class="copyright-text">© {{date('Y')}} <a href="#">{{ config('app.name', 'Emprega Paulínia') }}</a>.
              Todos os direitos reservados. | Desenvolvido por <a href="#">DMTA</a>.</div>
            <div class="social-links">
              <a href="https://www.facebook.com/profile.php?id=61579735320956" target="_blank"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Scroll To Top -->
      <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
    </footer>
    <!-- End Main Footer -->
  </div><!-- End Page Wrapper -->

  @include('layouts.inc.scripts')

</body>

</html>