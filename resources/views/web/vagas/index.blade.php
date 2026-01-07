<x-web-layout>

    @include(
        'web.vagas.inc.filters', 
        [ 'categories' => $categories ]
    )

    <!-- Listing Section -->
    <section class="ls-section">
        <div class="auto-container">
            <div class="filters-backdrop"></div>

            <div class="row">
                <!-- Content Column -->
                <div class="content-column col-lg-9 col-md-12 col-sm-12">
                    <div class="ls-outer">

                        @foreach ($jobs as $job)
                        <x-web.job-card :job="$job" />
                        @endforeach

                        <!-- Listing Show More -->
                        <div class="ls-show-more">
                            <p>Mostrando {{$jobs->count()}} de {{$jobs->total()}} Vagas</p>
                            <div class="bar"><span class="bar-inner" style="width: {{ $jobs->total() > 0 ? ($jobs->count() / $jobs->total()) * 100 : 0 }}%"></span></div>
                            <button class="show-more">Ver Mais</button>
                        </div>
                    </div>
                </div>

                @include('web.vagas.inc.ads-sidebar')               
            </div>
        </div>
    </section>
</x-web-layout>