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
                <div class="logo"><a href="#"><img src="images/logo.svg" alt=""></a></div>
                <p class="phone-num"><span>Call us </span><a href="thebeehost@support.com">123 456 7890</a></p>
                <p class="address">329 Queensberry Street, North Melbourne VIC<br> 3051, Australia. <br><a
                    href="mailto:support@superio.com" class="email">support@superio.com</a></p>
              </div>
            </div>

            <div class="big-column col-xl-8 col-lg-9 col-md-12">
              <div class="row">
                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">For Candidates</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Browse Jobs</a></li>
                        <li><a href="#">Browse Categories</a></li>
                        <li><a href="#">Candidate Dashboard</a></li>
                        <li><a href="#">Job Alerts</a></li>
                        <li><a href="#">My Bookmarks</a></li>
                      </ul>
                    </div>
                  </div>
                </div>


                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">For Employers</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Browse Candidates</a></li>
                        <li><a href="#">Employer Dashboard</a></li>
                        <li><a href="#">Add Job</a></li>
                        <li><a href="#">Job Packages</a></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">About Us</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Job Page</a></li>
                        <li><a href="#">Job Page Alternative</a></li>
                        <li><a href="#">Resume Page</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                      </ul>
                    </div>
                  </div>
                </div>


                <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                  <div class="footer-widget links-widget">
                    <h4 class="widget-title">Helpful Resources</h4>
                    <div class="widget-content">
                      <ul class="list">
                        <li><a href="#">Site Map</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Center</a></li>
                        <li><a href="#">Security Center</a></li>
                        <li><a href="#">Accessibility Center</a></li>
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
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              {{-- <a href="#"><i class="fab fa-twitter"></i></a> --}}
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