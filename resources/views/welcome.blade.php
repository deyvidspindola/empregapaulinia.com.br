<x-web-layout>
      <!-- Banner Section-->
    <section class="banner-section-seven">
      <div class="image-outer">
        <figure class="image"><img src="images/resource/banner-img-8.png" alt=""></figure>
      </div>
      <div class="auto-container">
        <div class="row">
          <div class="content-column col-lg-7 col-md-12 col-sm-12">
            <div class="inner-column">
              <div class="title-box wow fadeInUp" data-wow-delay="500ms">
                <h3>Encontre e publique <br> vagas de emprego.</h3>
                <div class="text">Empresas e candidatos de Paulínia e região usam Emprega Paulínia para contratar com rapidez.</div>
              </div>

              <!-- Job Search Form -->
              <div class="job-search-form wow fadeInUp" data-wow-delay="1000ms">
                <form method="get" action="{{ route('jobs') }}">
                  <div class="row">
                    <div class="form-group col-lg-5 col-md-12 col-sm-12">
                      <span class="icon flaticon-search-1"></span>
                      <input type="text" name="search" placeholder="Título da vaga, palavras-chave">
                    </div>
                    <!-- Form Group -->
                    <div class="form-group col-lg-4 col-md-12 col-sm-12 location">
                      <span class="icon flaticon-map-locator"></span>
                      <input type="text" name="location" placeholder="Cidade ou Remoto">
                    </div>
                    <!-- Form Group -->
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 btn-box">
                      <button type="submit" class="theme-btn btn-style-one"><span class="btn-title">Buscar Vagas</span></button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- Job Search Form -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Banner Section-->

    <section class="registeration-banners">
      <div class="auto-container">
        <div class="row wow fadeInUp">
          <!-- Banner Style One -->
          <div class="banner-style-one col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <h3>Empregador</h3>
                <p>Encontre os melhores profissionais para sua empresa de forma rápida e eficiente. Publique vagas, gerencie candidaturas e contrate com mais segurança.</p>
                <a href="{{ route('register') }}" class="theme-btn btn-style-five">Cadastre-se</a>
              </div>
              <figure class="image"><img src="images/resource/employ.png" alt=""></figure>
            </div>
          </div>

          <!-- Banner Style Two -->
          <div class="banner-style-two col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box">
              <div class="content">
                <h3>Candidato</h3>
                <p>Encontre as melhores oportunidades de emprego que se alinham com suas habilidades e aspirações. Candidate-se facilmente e avance em sua carreira.</p>
                <a href="{{ route('register') }}" class="theme-btn btn-style-five">Cadastre-se</a>
              </div>
              <figure class="image"><img src="images/resource/candidate.png" alt=""></figure>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Job Section -->
    <section class="job-section-five style-two">
      <div class="auto-container">
        <div class="row wow fadeInUp">
          <div class="featured-column col-xl-9 col-lg-12 col-md-12 col-sm-12">
            <div class="sec-title">
              <h2>Últimas Vagas</h2>
              <div class="text">Conheça seu valor e encontre o emprego que qualifica sua vida</div>
            </div>
            <div class="outer-box">
              @foreach ($data['published_jobs'] as $jobPosting)
                <x-web.home-job-card :job="$jobPosting"/>
              @endforeach
            </div>
          </div>

          <div class="recent-column col-xl-3 col-lg-12 col-md-12 col-sm-12">
            <div class="sec-title">
              <h2>Vagas Recentes</h2>
              <div class="text">Conheça seu valor e encontre o emprego</div>
            </div>

            <!-- Job Block -->
            <div class="job-block-four">
              <div class="inner-box">
                <ul class="job-other-info">
                  <li class="time">Full Time</li>
                </ul>
                <span class="company-logo"><img src="images/resource/company-logo/3-4.png" alt=""></span>
                <span class="company-name">Catalyst</span>
                <h4><a href="#">Software Engineer (Android), Libraries</a></h4>
                <div class="location"><span class="icon flaticon-map-locator"></span> London, UK</div>
              </div>
            </div>

            <!-- Job Block -->
            <div class="job-block-four">
              <div class="inner-box">
                <ul class="job-other-info">
                  <li class="time">Full Time</li>
                </ul>
                <span class="company-logo"><img src="images/resource/company-logo/3-1.png" alt=""></span>
                <span class="company-name">Catalyst</span>
                <h4><a href="#">Software Engineer (Android), Libraries</a></h4>
                <div class="location"><span class="icon flaticon-map-locator"></span> London, UK</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Job Section -->

</x-web-layout>