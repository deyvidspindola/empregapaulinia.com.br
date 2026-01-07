<section class="page-title style-two">
    <div class="auto-container">

        <!-- Job Search Form -->
        <div class="job-search-form">
            <form id="jobs-filter-form" method="get" action="{{ route('jobs') }}">
                <div class="row">
                    <!-- Form Group -->
                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                        <span class="icon flaticon-search-1"></span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Título da vaga, palavras-chave ou empresa">
                    </div>

                    <!-- Form Group -->
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 location">
                        <span class="icon flaticon-map-locator"></span>
                        <input type="text" name="location" value="{{ request('location') }}" placeholder="Cidade ou Remoto">
                    </div>

                    <!-- Form Group -->
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 location">
                        <span class="icon flaticon-briefcase"></span>
                        <select class="chosen-select">
                            <option value="">Escolha uma categoria</option>
                            @forelse ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @empty
                                <option disabled>Nenhuma categoria encontrada</option>
                            @endforelse
                        </select>
                    </div>

                    <!-- Form Group -->
                    <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                        <button type="submit" class="theme-btn btn-style-one">Buscar Vagas</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Job Search Form -->
    </div>
</section>