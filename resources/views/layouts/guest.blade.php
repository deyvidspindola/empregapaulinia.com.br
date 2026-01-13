@include('layouts.inc.head')
<body>
    <div class="page-wrapper">
        <div class="preloader"></div>
        <header class="main-header">
            <div class="container-fluid">
                <div class="main-box">
                    <div class="nav-outer">
                        <div class="logo-box">
                            <div class="logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('images/logo-2.png') }}" alt="" title="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-header">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="" title="">
                    </a>
                </div>
            </div>
            <div id="nav-mobile"></div>
        </header>
        <div class="login-section">
            <div class="image-layer" style="background-image: url({{ asset('images/background/12.jpg') }});"></div>
            <div class="outer-box">
                <div class="login-form default-form">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.inc.scripts')
</body>
</html>