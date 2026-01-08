@php
$genders = ['Male' => 'Masculino','Female' => 'Feminino','Other' => 'Outro','Prefer not to say' => 'Prefiro não informar'];
@endphp
<x-admin-layout title="Meus Dados" subtitle="Informe seus dados">

    @if(session('success'))
        <x-ui.message type="success" :message="session('success')" />
    @endif

    <x-form :formConfig="$formConfig">
        <x-ui.card title="Dados Pessoais">
            <div class="uploading-outer">
            <div class="uploadButton">
                <input class="uploadButton-input" type="file" name="logo" accept="image/*" id="upload" />
                <label class="uploadButton-button ripple-effect" for="upload">Escolher Logo</label>
                <span class="uploadButton-file-name"></span>
            </div>
            <div class="text">Max file size is 1MB, Minimum dimension: 330x300 And Suitable files are .jpg & .png</div>
            </div>            
            <div class="row">
                <x-form.input 
                    label="Nome Completo" 
                    name="full_name" 
                    placeholder="Digite seu nome completo" 
                    :value="old('full_name', auth()->user()->name ?? '')"
                    required 
                    cols="col-md-9"
                />
                <x-form.input-mask 
                    label="CPF" 
                    name="cpf" 
                    placeholder="000.000.000-00" 
                    :value="old('cpf', $user->cpf ?? '')"
                    data-mask="000.000.000-00"
                    required
                    cols="col-md-3"
                />
                <x-form.input 
                    label="Data de Nascimento" 
                    name="birth_date" 
                    placeholder="Digite a data de nascimento" 
                    :value="old('birth_date', $user->birth_date ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.select
                    cols="col-md-4"
                    label="Gênero (opcional)"
                    name="gender"
                    :options="collect($genders)->all()"                    
                    :selected="old('gender', $user->gender ?? '')"
                />                                                                            
            </div>
        </x-ui.card>

        <x-ui.card title="Endereço">
            <div class="row">
                <x-form.input-mask
                    label="CEP" 
                    name="zip" 
                    placeholder="00000-000" 
                    :value="old('zip', $user->zip ?? '')"
                    required 
                    daa-mask="00000-000"
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Endereço" 
                    name="street" 
                    placeholder="Digite o endereço" 
                    :value="old('street', $user->street ?? '')"
                    required
                    cols="col-md-8"
                />
                <x-form.input 
                    label="Número" 
                    name="number" 
                    placeholder="Digite o número" 
                    :value="old('number', $user->number ?? '')"
                    required 
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Complemento" 
                    name="complement" 
                    placeholder="Digite o complemento" 
                    :value="old('complement', $user->complement ?? '')"
                    cols="col-md-2"
                />                                            
                <x-form.input 
                    label="Bairro" 
                    name="neighborhood" 
                    placeholder="Digite o bairro" 
                    :value="old('neighborhood', $user->neighborhood ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Cidade" 
                    name="city" 
                    placeholder="Digite a cidade" 
                    :value="old('city', $user->city ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Estado" 
                    name="state" 
                    placeholder="UF (ex: SP)" 
                    :value="old('state', $user->state ?? '')"
                    required 
                    cols="col-md-2"
                />                                                
            </div>
        </x-ui.card>

        <x-ui.card title="Contato">
            <div class="row">
                <x-form.input-mask
                    label="Telefone" 
                    name="phone" 
                    placeholder="(00) 00000-0000" 
                    :value="old('phone', $user->phone ?? '')"
                    required
                    data-mask="(00) 00000-0000"
                    cols="col-md-4"
                />                                               
            </div>
        </x-ui.card>
    </x-form>  
</x-admin-layout>
@push('scripts')   
    <script>
        $(document).ready(function() {

            // Inicializar o datepicker para o campo de deadline
            $('#birth_date').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true,
                todayHighlight: true,
            });
        });

    </script>
    @endpush