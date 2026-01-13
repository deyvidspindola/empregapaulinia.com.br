<div class="ls-show-more">
    <p>Mostrando {{$jobs->count()}} de {{$jobs->total()}} Vagas</p>
    <div class="bar">
        <span class="bar-inner" style="width: {{ $jobs->total() > 0 ? ($jobs->count() / $jobs->total()) * 100 : 0 }}%"></span>
    </div>
    <button class="show-more">Ver Mais</button>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showMoreButton = document.querySelector('.ls-show-more .show-more');
        const jobCardsContainer = document.querySelector('.ls-outer');
        let currentPage = 1;
        const totalJobs = {{ $jobs->total() }};
        const jobsPerPage = {{ $jobs->perPage() }};
        const totalPages = Math.ceil(totalJobs / jobsPerPage);
        showMoreButton.addEventListener('click', function () {
            if (currentPage < totalPages) {
                currentPage++;
                fetch(`/jobs?page=${currentPage}`)
                    .then(response => response.json())
                    .then(data => {
                        data.jobs.forEach(job => {
                            const jobCard = document.createElement('div');
                            jobCard.classList.add('job-card');
                            jobCard.innerHTML = `
                                <h3>${job.title}</h3>
                                <p>${job.description}</p>
                            `;
                            jobCardsContainer.appendChild(jobCard);
                        });
                        document.querySelector('.ls-show-more p').innerText = `Mostrando ${jobCardsContainer.children.length} de ${totalJobs} Vagas`;
                    })
                    .catch(error => console.error('Erro ao carregar mais vagas:', error));
            }
        });
    });
</script>
@endpush