<div class="model">
    <!-- Login modal -->
    <div id="login-modal">
        <!-- Login Form -->
        <div class="login-form default-form">
            <div class="form-inner">
                @include('auth.inc.form-login')
                <div class="bottom-box">
                    <div class="text">
                        Não tem conta?
                        <a href="{{ route('register.popup') }}" class="call-modal signup">Se cadastre aqui</a>
                    </div>
                </div>
            </div>          
        </div>
        <!--End Login Form -->
    </div>
    <!-- End Login Module -->

    <script type="text/javascript">
        // Open modal in AJAX callback
        jQuery('.call-modal.signup').on('click', function (event) {
            event.preventDefault();
            this.blur();
            jQuery.get(this.href, function (html) {
                jQuery(html).appendTo('body').modal({
                    fadeDuration: 300,
                    fadeDelay: 0.15
                });
            });
        });
    </script>
</div>