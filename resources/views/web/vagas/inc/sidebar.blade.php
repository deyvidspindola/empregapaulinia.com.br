<div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
    <aside class="sidebar">
        @if(auth()->user()->IsCandidate)
        <div class="btn-box">
            <a 
                href="{{ route(
                    'jobs.apply.popup', 
                    [
                        'job' => $job
                        ]
                    ) }}" 
                class="theme-btn btn-style-one call-modal">
                Candidatar
            </a>
        </div>
        @endif

        <div class="sidebar-widget">
            <!-- Job Overview -->
            <h4 class="widget-title">Resumo da Vaga</h4>
            <div class="widget-content">
                <ul class="job-overview">
                    <li>
                        <i class="icon icon-calendar"></i>
                        <h5>Publicado</h5>
                        <span>{{ $job->postedAt }}</span>
                    </li>
                    <li>
                        <i class="icon icon-expiry"></i>
                        <h5>Expira</h5>
                        <span>{{ $job->expiredAt }}</span>
                    </li>
                    <li>
                        <i class="icon icon-location"></i>
                        <h5>Localização</h5>
                        <span>{{ $job->location }}</span>
                    </li>
                    <li>
                        <i class="icon icon-location"></i>
                        <h5>Tipo de Vaga</h5>
                        <span>{{ $job->job_type }}</span>
                    </li>                    
                    <li>
                        <i class="icon icon-briefcase"></i>
                        <h5>Modalidade</h5>
                        <span>London, UK</span>
                    </li>                    
                    <li>
                        <i class="icon icon-salary"></i>
                        <h5>Salário</h5>
                        <span>{{ $job->salary }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</div>