<header class="main-header header-shaddow">
  <div class="container-fluid">
    <div class="main-box">
      <div class="nav-outer">
        <div class="logo-box">
          <div class="logo">
            <a href="{{ route('home') }}">
              <img src="{{ asset('images/logo.png') }}" alt="" title="">
            </a>
          </div>
        </div>

        <nav class="nav main-menu">
          <ul class="navigation" id="navbar">
            {{-- <li><a href="index.html">Home</a></li> --}}
          </ul>
        </nav>
        <!-- Main Menu End-->
      </div>
      @include('components.layouts.inc.outer-box')
    </div>
  </div>

  <!-- Mobile Header -->
  <div class="mobile-header">
    <div class="logo">
      <a href="{{ route('employer.dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="" title="">
      </a>
    </div>
    <div class="nav-outer clearfix">
      <div class="outer-box">
        <a href="#" class="mobile-nav-toggler navbar-trigger" id="toggle-user-sidebar">
          <span class="flaticon-menu-1"></span>
        </a>
      </div>
    </div>
  </div>
</header>