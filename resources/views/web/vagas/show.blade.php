@php
  $companyName = $company->name ?? ($job->company->name ?? 'Empresa');
  $isCompanyVisible = $job->is_company_visible ?? true;
  if (!$isCompanyVisible) {
    $companyName = 'Empresa confidencial';
    $logo = asset('images/resource/company-logo/5-1.png');
  }
@endphp
<x-web-layout>
  <section class="job-detail-section">
    <div class="job-detail-outer">
      <div class="auto-container">
        <div class="row">
          <div class="content-column col-lg-8 col-md-12 col-sm-12">
            <div class="job-block-outer">
              <!-- Job Block -->
              <div class="job-block-seven">
                <div class="inner-box">
                  <div class="content">
                    <span class="company-logo">
                      <img src="{{ $logo ?? asset('images/resource/company-logo/5-1.png') }}" alt="" />
                    </span>
                    <h4>{{ $job->title }}</h4>
                    <ul class="job-info">
                      <li><span class="icon flaticon-briefcase"></span> {{ $companyName }}</li>
                      <li><span class="icon flaticon-map-locator"></span> {{ $job->location }}</li>
                      <li><span class="icon flaticon-map-locator"></span> {{ $job->job_type }}</li>
                    </ul>
                    <ul class="job-info">
                      <li><span class="icon flaticon-clock-3"></span> {{ $job->postedAt }}</li>
                      <li><span class="icon flaticon-money"></span> {{ $job->salary }}</li>
                    </ul>                    
                  </div>
                </div>
              </div>
            </div>
            
            <div class="job-detail">
              <h4>Descrição da Vaga</h4>
              <p>{{ $job->description }}</p>
              
              <h4>Requisitos</h4>
              <p>{{ $job->requirements }}</p>
              
              @if($job->benefits)
              <h4>Beneficios</h4>
              <p>{{ $job->benefits }}</p>
              @endif
              
              @if($job->observation)
              <h4>Observações</h4>
              <p>{{ $job->observation }}</p>
              @endif
            </div>

            <div class="padding-top-0 padding-bottom-45">
              <div class="message-box warning">
                <p>
                  <strong>Aviso importante:</strong> Este portal é <u>independente</u> e <u>não possui qualquer vínculo</u> com o programa “Emprega Paulínia” da Prefeitura Municipal de Paulínia.
                  Todas as oportunidades e informações publicadas aqui são de responsabilidade dos anunciantes e usuários do site.
                </p>
              </div>
            </div>

            <!-- Related Jobs -->
            @include('web.vagas.inc.related-jobs')
          </div>
          @include('web.vagas.inc.sidebar', ['job' => $job])
        </div>
      </div>
    </div>
  </section>
</x-web-layout>