<x-web-layout accesskey="" :title="$job->title">
    <!-- Job Detail Section -->
    <section class="job-detail-section">
      <!-- Upper Box -->
      <div class="upper-box">
        <div class="auto-container">
          <!-- Job Block -->
          <div class="job-block-seven">
            <div class="inner-box row">
              <div class="col-lg-8">
                <div class="content">
                  <span class="company-logo">
                    <img src="{{ $job->company_logo }}" alt="" />
                  </span>
                  <h4>{{ $job->title }}</h4>
                  <ul class="job-info">
                    <li><span class="icon flaticon-briefcase"></span> {{ $job->company_name }}</li>
                    <li><span class="icon flaticon-map-locator"></span> {{ $job->location }}</li>
                    <li><span class="icon flaticon-clock-3"></span> {{ $job->postedAt }}</li>
                    <li><span class="icon flaticon-money"></span> {{ $job->salary_display }}</li>
                  </ul>
                  <ul class="job-other-info">
                    <li class="time">{{ $job->job_type }}</li>
                    {{-- <li class="privacy">Private</li>
                    <li class="required">Urgent</li> --}}
                  </ul>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="text-lg-end">
                  @if($job->deadline_display != '')
                  <div class="titles mb-3 mb-sm-0">
                    <h4 class="fz20 fw500 mb-1">Canditatar-se até</h4>
                    <p class="text mb15">{{ $job->deadline_display }}</p>
                  </div>
                  @endif
                  <div class="btn-box justify-content-lg-end mb-0">
                    <a 
                        href="{{ route(
                            'jobs.apply.popup', 
                            [
                                'job' => $job
                                ]
                            ) }}" 
                        class="theme-btn btn-style-one call-modal w-100">
                        Candidatar a vaga <i class="fal fa-long-arrow-right ms-3"></i>
                    </a>
                  </div>
                </div>
              </div>              
            </div>
          </div>
        </div>
      </div>

      <div class="job-detail-outer">
        <div class="auto-container">
          <div class="row">
            <div class="content-column col-lg-8 col-md-12 col-sm-12">
              <div class="job-detail">
                <h4>Descrição da Vaga</h4>
                <p>{!! nl2br(e($job->description)) !!}</p>
                
                <h4>Requisitos</h4>
                <p>{!! nl2br(e($job->requirements)) !!}</p>
                
                @if($job->benefits)
                <h4>Beneficios</h4>
                <p>{!! nl2br(e($job->benefits)) !!}</p>
                @endif
                
                @if($job->observation)
                <h4>Observações</h4>
                <p>{!! nl2br(e($job->observation)) !!}</p>
                @endif
              </div>
              <hr class="opacity-100">


              <!-- Application Ends -->
            <div class="padding-top-0 padding-bottom-45">
              <div class="message-box warning">
                <p>
                  <strong>Aviso importante:</strong> Este portal é <u>independente</u> e <u>não possui qualquer vínculo</u> com o programa “Emprega Paulínia” da Prefeitura Municipal de Paulínia.
                  Todas as oportunidades e informações publicadas aqui são de responsabilidade dos anunciantes e usuários do site.
                </p>
              </div>
            </div>

              <!-- Related Jobs -->
              {{-- @include('web.vagas.inc.related-jobs') --}}
            </div>

            @include('web.vagas.inc.show-sidebar', ['job' => $job])
          </div>
        </div>
      </div>
    </section>
    <!-- End Job Detail Section -->
</x-web-layout>