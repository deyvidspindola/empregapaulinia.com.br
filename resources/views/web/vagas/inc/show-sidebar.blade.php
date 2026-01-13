            <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
              <aside class="sidebar">
                <div class="sidebar-widget at-jsv7">
                  <h4 class="widget-title">Resumo da Vaga</h4>
                  <div class="widget-content">
                    <ul class="job-overview at-sv5">
                      <li>
                        <i class="icon fal fa-circle-dollar"></i>
                        <div class="ml15">
                          <h5>Salário</h5>
                          <span>{{ $job->salary_display }}</span>
                        </div>
                      </li>
                      <li>
                        <i class="icon flaticon-map-locator"></i>
                        <div class="ml15">
                          <h5>Localização</h5>
                          <span>{{ $job->location }}</span>
                        </div>
                      </li>
                      <li>
                        <i class="icon icon-calendar"></i>
                        <div class="ml15">
                          <h5>Publicado</h5>
                          <span>{{ $job->postedAt }}</span>
                        </div>
                      </li>
                      @if($job->expiredAt) 
                      <li>
                        <i class="icon fal fa-hourglass-end"></i>
                        <div class="ml15">
                          <h5>Expira</h5>
                          <span>{{ $job->expiredAt }}</span>
                        </div>
                      </li>
                      @endif
                    </ul>
                  </div>
                </div>
                {{-- <div class="p-0">
                  <!-- Job Skills -->
                  <h4 class="widget-title fz18 mb25 fw500">Location</h4>
                  <div class="widget-content">
                    <div class="map-outer">
                      <div class="map-canvas at-sv5" data-zoom="12" data-lat="-37.817085" data-lng="144.955631" data-type="roadmap" data-hue="#ffc400" data-title="Envato" data-icon-path="images/icons/contact-map-marker.png" data-content="Melbourne VIC 3000, Australia<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
                      </div>
                    </div>
                  </div>
                </div> --}}
              </aside>
            </div>