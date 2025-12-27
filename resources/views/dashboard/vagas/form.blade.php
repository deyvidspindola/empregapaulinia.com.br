<x-admin-layout title="Vagas" subtitle="Cadastrar nova vaga">
    <x-ui.card title="Dados da Vaga">
        <x-form :action="$formConfig['action']" :method="$formConfig['method']">
            <x-form.input 
                label="Título da Vaga" 
                name="title" 
                placeholder="Digite o título da vaga" 
                :value="old('title', $vaga->title ?? '')"
                required 
                cols="col-md-9"
            />
            <x-form.select
                cols="col-md-3"
                label="Tipo de Contrato"
                name="job_type"
                :options="$jobTypes"
                :selected="old('job_type', $vaga->job_type ?? '')"
                required
            />    
            <x-form.select
                cols="col-md-4"
                label="Categoria"
                name="category_id"
                :options="$categories"
                :selected="old('category_id', $vaga->category_id ?? '')"
                required
            />     
            <x-form.input 
                label="Localização (Cidade/Estado ou “Remoto”)" 
                name="location" 
                placeholder="Digite a localização da vaga" 
                :value="old('location', $vaga->location ?? '')"
                required 
                cols="col-md-4"
            />
            <x-form.input 
                label="Remuneração" 
                name="salary" 
                placeholder="Digite a remuneração da vaga" 
                :value="old('salary', $vaga->salary ?? '')"
                required 
                cols="col-md-4"
            />            
            <x-form.textarea 
                label="Descrição da Vaga" 
                name="description" 
                placeholder="Digite a descrição da vaga" 
                :value="old('description', $vaga->description ?? '')"
                required 
            />
            <x-form.textarea 
                label="Requisitos" 
                name="requirements" 
                placeholder="Digite os requisitos da vaga" 
                :value="old('requirements', $vaga->requirements ?? '')"
                required 
            />
            <x-form.textarea 
                label="Benefícios" 
                name="benefits" 
                placeholder="Digite os benefícios da vaga" 
                :value="old('benefits', $vaga->benefits ?? '')" 
            />
            <x-form.textarea 
                label="Observações" 
                name="observation" 
                placeholder="Digite as observações da vaga" 
                :value="old('observation', $vaga->observation ?? '')" 
            />
            <x-form.input 
                label="Quantidade de Vagas" 
                name="openings" 
                placeholder="Digite a quantidade de vagas" 
                :value="old('openings', $vaga->openings ?? '')"
                required 
                cols="col-md-4"
            />                                                
            <x-form.input 
                label="Data de Expiração" 
                name="deadline" 
                placeholder="Digite a data de expiração da vaga" 
                :value="old('deadline', $vaga->deadline_formatted ?? '')"
                required 
                cols="col-md-4"                
            />
            <x-form.switch 
                label="Publicar agora?" 
                name="is_published" 
                :options="[1 => 'Sim']"
                :checked="old('is_published', $vaga->is_published ?? true)" 
                cols="col-md-2"
            />
            <x-form.switch 
                label="Exibir nome da empresa?" 
                name="is_company_visible" 
                :options="[1 => 'Sim']"
                :checked="old('is_company_visible', $vaga->is_company_visible ?? true)" 
                cols="col-md-2"
            />

            {{-- como cliente se aplica a vaga --}}
            <x-form.radiobox
                label="Como o candidato deve se candidatar?" 
                name="apply_method" 
                :options="[
                    'platform' => 'Pela plataforma',
                    'email' => 'Via e-mail',
                ]" 
                :checked="old('apply_method', $vaga->apply_method ?? 'platform')" 
                cols="col-md-4"
                inline
            />
            <x-form.input
                label="E-mail para candidatura" 
                name="apply_email" 
                type="email"
                placeholder="Email para recebimento de candidaturas" 
                :value="old('apply_email', $vaga->apply_email ?? '')"
                cols="col-md-4"
            />
            <span style="clear: both"></span>

        </x-form>
    </x-ui.card>

    @push('scripts')   
    <script>
        $(document).ready(function() {

            toggleApplyEmail();

            // Inicializar o datepicker para o campo de deadline
            $('#deadline').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true,
                todayHighlight: true,
            });
        });

        function toggleApplyEmail() {
            const applyMethod = $('input[name="apply_method"]:checked').val();
            const emailInput = $('#apply_email');
            
            if (applyMethod === 'email') {
                $('#apply_email-group').show();
                emailInput.attr('required', true).attr('data-parsley-required', 'true');
            } else {
                $('#apply_email-group').hide();
                emailInput.attr('required', false).attr('data-parsley-required', 'false');
            }

            $('input[name="apply_method"]').on('change', function() {
                if ($(this).val() === 'email') {
                    $('#apply_email-group').show();
                    emailInput.attr('required', true).attr('data-parsley-required', 'true');
                } else {
                    $('#apply_email-group').hide();
                    emailInput.attr('required', false).attr('data-parsley-required', 'false');
                }
            });
        }
    </script>
    @endpush

</x-admin-layout>