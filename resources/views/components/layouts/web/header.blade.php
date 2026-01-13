<header class="main-header alternate">
    <div class="auto-container">
        <!-- Main box -->
        <div class="main-box">
            <!--Nav Outer -->
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
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('jobs') }}">Vagas</a></li>
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
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="" title="">
            </a>
        </div>

        <!--Nav Box-->
        <div class="nav-outer clearfix">
            <div class="outer-box">
                <!-- Login/Register -->
                <div class="login-box">
                    <a href="{{ route('login') }}" class="call-modal">
                        <span class="icon-user"></span>
                    </a>
                </div>

                <a href="#nav-mobile" class="mobile-nav-toggler navbar-trigger">
                    <span class="flaticon-menu-1"></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Nav -->
    <div id="nav-mobile"></div>
</header>