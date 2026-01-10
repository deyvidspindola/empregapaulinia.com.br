<x-admin-layout>
  <div class="row">
    <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
      <div class="ui-item">
        <div class="left">
          <i class="icon la la-briefcase"></i>
        </div>
        <div class="right">
          <h4>{{ $data['published_jobs'] }}</h4>
          <p>Vagas Publicadas</p>
        </div>
      </div>
    </div>

    <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
      <div class="ui-item ui-red">
        <div class="left">
          <i class="icon la la-coins"></i>
        </div>
        <div class="right">
          <h4>{{ $data['wallet_balance'] }}</h4>
          <p>Créditos Disponíveis</p>
        </div>
      </div>
    </div>

    <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
      <div class="ui-item ui-yellow">
        <div class="left">
          <i class="icon la la-eye"></i>
        </div>
        <div class="right">
          <h4>{{ $data['job_views'] }}</h4>
          <p>Visualizações (30 dias)</p>
        </div>
      </div>
    </div>

    <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
      <div class="ui-item ui-green">
        <div class="left">
          <i class="icon la la-user-check"></i>
        </div>
        <div class="right">
          <h4>{{ $data['applications'] }}</h4>
          <p>Candidaturas (30 dias)</p>
        </div>
      </div>
    </div>
  </div>

  {{-- <div class="row">

    <div class="col-xl-7 col-lg-12">
      <!-- Graph widget -->
      <div class="graph-widget ls-widget">
        <div class="tabs-box">
          <div class="widget-title">
            <h4>Visualizações nas Vagas</h4>
            <div class="chosen-outer">
              <!--Tabs Box-->
              <select class="chosen-select">
                <option value="7" >Últimos 7 Dias</option>
                <option value="15">Últimos 15 Dias</option>
                <option value="30">Últimos 30 Dias</option>
                <option value="60">Últimos 60 Dias</option>
              </select>
            </div>
          </div>

          <div class="widget-content">
            <canvas id="chart" width="100" height="45"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-5 col-lg-12">
      <!-- Notification Widget -->
      <div class="notification-widget ls-widget">
        <div class="widget-title">
          <h4>Notifications</h4>
        </div>
        <div class="widget-content">
          <ul class="notification-list">
            <li><span class="icon flaticon-briefcase"></span> <strong>Wade Warren</strong> applied for a job <span
                class="colored">Web Developer</span></li>
            <li><span class="icon flaticon-briefcase"></span> <strong>Henry Wilson</strong> applied for a job <span
                class="colored">Senior Product Designer</span></li>
            <li class="success"><span class="icon flaticon-briefcase"></span> <strong>Raul Costa</strong> applied for a
              job <span class="colored">Product Manager, Risk</span></li>
            <li><span class="icon flaticon-briefcase"></span> <strong>Jack Milk</strong> applied for a job <span
                class="colored">Technical Architect</span></li>
            <li class="success"><span class="icon flaticon-briefcase"></span> <strong>Michel Arian</strong> applied for
              a job <span class="colored">Software Engineer</span></li>
            <li><span class="icon flaticon-briefcase"></span> <strong>Ali Tufan</strong> applied for a job <span
                class="colored">UI Designer</span></li>
          </ul>
        </div>
      </div>
    </div>

  </div> --}}

  @push('scripts')

    <!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
      Chart.defaults.global.defaultFontFamily = "Sofia Pro";
      Chart.defaults.global.defaultFontColor = '#888';
      Chart.defaults.global.defaultFontSize = '14';

      var ctx = document.getElementById('chart').getContext('2d');

      var chart = new Chart(ctx, {

        type: 'line',
        // The data for our dataset
        data: {
          labels: ["January", "February", "March", "April", "May", "June"],
          // Information about the dataset
          datasets: [{
            label: "Views",
            backgroundColor: 'transparent',
            borderColor: '#1967D2',
            borderWidth: "1",
            data: [196, 132, 215, 362, 210, 252],
            pointRadius: 3,
            pointHoverRadius: 3,
            pointHitRadius: 10,
            pointBackgroundColor: "#1967D2",
            pointHoverBackgroundColor: "#1967D2",
            pointBorderWidth: "2",
          }]
        },

        // Configuration options
        options: {

          layout: {
            padding: 10,
          },

          legend: {
            display: false
          },
          title: {
            display: false
          },

          scales: {
            yAxes: [{
              scaleLabel: {
                display: false
              },
              gridLines: {
                borderDash: [6, 10],
                color: "#d8d8d8",
                lineWidth: 1,
              },
            }],
            xAxes: [{
              scaleLabel: {
                display: false
              },
              gridLines: {
                display: false
              },
            }],
          },

          tooltips: {
            backgroundColor: '#333',
            titleFontSize: 13,
            titleFontColor: '#fff',
            bodyFontColor: '#fff',
            bodyFontSize: 13,
            displayColors: false,
            xPadding: 10,
            yPadding: 10,
            intersect: false
          }
        },
      });
    </script>

  @endpush

</x-admin-layout>