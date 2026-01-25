<div class="model">
    <!-- Apply modal -->
    <div id="login-modal">
        <!-- Apply Form -->
        <div class="login-form default-form">
            <div class="form-inner">
                <h3>Candidatar-se para a Vaga</h3>                
                @guest
                    <p>Para se candidatar, você precisa estar logado.</p>
                    <a href="{{ route('login.popup') }}" class="call-modal login-link">Faça login aqui</a>
                    <span> ou </span>
                    <a href="{{ route('register') }}" class="register-link">Se cadastre aqui</a>
                @else
                    <form method="POST" action="{{ route('jobs.apply', ['job' => $jobId]) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label>Mensagem de Apresentação</label>
                            <textarea name="cover_letter" class="form-control" rows="5" placeholder="Conte sobre sua experiência e interesse nesta vaga"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Currículo (Opcional)</label>
                            <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                            <small class="form-text text-muted">Formatos aceitos: PDF, DOC, DOCX (Máx: 5MB)</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="theme-btn btn-style-one">Enviar Candidatura</button>
                        </div>
                    </form>
                @endguest
            </div>          
        </div>
        <!--End Apply Form -->
    </div>
    <!-- End Apply Module -->

    <script type="text/javascript">
        // Open modal in AJAX callback
        jQuery('.call-modal').on('click', function (event) {
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