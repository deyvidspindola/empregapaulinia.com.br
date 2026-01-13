<x-web-layout>
  <!-- Map Section -->
  <section class="map-section">
    <div class="map-outer">
      <div class="map-image" style="height: 500px; overflow: hidden;">
        <img src="{{ asset('images/maps.png') }}" alt="Mapa de Localização - Paulínia, SP"
          style="width: 100%; height: 100%; object-fit: cover;">
      </div>
    </div>
  </section>
  <!-- End Map Section -->

  <!-- Contact Section -->
  <section class="contact-section">
    <div class="auto-container">
      <!-- Contact Form -->
      <div class="contact-form default-form upper-box">
        <h3>Deixe uma Mensagem</h3>
        <!--Contact Form-->
        <form method="post" action="{{ route('contact.send') }}" id="email-form">
          @csrf
          <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
              <div class="response"></div>
            </div>

            <x-form.input 
              label="Seu Nome" 
              name="name" 
              placeholder="Seu Nome" 
              required 
              cols="col-lg-6 col-md-12 col-sm-12"
            />

            <x-form.input 
              label="Seu E-mail" 
              name="email" 
              placeholder="Seu E-mail" 
              required 
              cols="col-lg-6 col-md-12 col-sm-12"
            />

            <x-form.input 
              label="Assunto" 
              name="subject" 
              placeholder="Assunto" 
              required 
              cols="col-lg-12 col-md-12 col-sm-12"
            />

            <x-form.textarea 
              label="Sua Mensagem" 
              name="message" 
              placeholder="Escreva sua mensagem..." 
              required 
              cols="col-lg-12 col-md-12 col-sm-12"
            />

            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
              <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
              @error('g-recaptcha-response')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
              <button class="theme-btn btn-style-one" type="submit">
                Enviar Mensagem
              </button>
            </div>
          </div>
        </form>
      </div>
      <!--End Contact Form -->
    </div>
  </section>
  <!-- Contact Section -->

  <!-- Call To Action -->
  @include('inc.ads')
  <!-- End Call To Action -->
</x-web-layout>