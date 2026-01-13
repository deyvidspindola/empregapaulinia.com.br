<x-web-layout title="Vagas de Emprego">

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
                        <hr class="opacity-100">
                        {{ $jobs->links('vendor.pagination.custom') }}
                    </div>
                </div>

                {{-- @include('web.vagas.inc.ads-sidebar')                --}}
            </div>
        </div>
    </section>
</x-web-layout>