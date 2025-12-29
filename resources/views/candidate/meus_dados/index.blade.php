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
                    label="Nome" 
                    name="name" 
                    placeholder="Digite seu nome" 
                    :value="old('name', $candidato->name ?? '')"
                    required 
                    cols="col-md-9"
                />
                <x-form.input 
                    label="CPF" 
                    name="cpf" 
                    placeholder="Digite o CPF" 
                    :value="old('cpf', $candidato->cpf ?? '')"
                    cols="col-md-3"
                />
                <x-form.input 
                    label="Data de Nascimento" 
                    name="birth_date" 
                    placeholder="Digite a data de nascimento" 
                    :value="old('birth_date', $candidato->birth_date ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.select
                    cols="col-md-4"
                    label="Gênero (opcional)"
                    name="gender"
                    :options="collect($genders)->all()"                    
                    :selected="old('gender', $candidato->gender ?? '')"
                />                                                                            
            </div>
        </x-ui.card>

        <x-ui.card title="Endereço">
            <div class="row">
                <x-form.input 
                    label="CEP" 
                    name="zip" 
                    placeholder="Digite o CEP" 
                    :value="old('zip', $candidato->zip ?? '')"
                    required 
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Endereço" 
                    name="street" 
                    placeholder="Digite o endereço" 
                    :value="old('street', $candidato->street ?? '')"
                    required
                    cols="col-md-8"
                />
                <x-form.input 
                    label="Número" 
                    name="number" 
                    placeholder="Digite o número" 
                    :value="old('number', $candidato->number ?? '')"
                    required 
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Complemento" 
                    name="complement" 
                    placeholder="Digite o complemento" 
                    :value="old('complement', $candidato->complement ?? '')"
                    cols="col-md-2"
                />                                            
                <x-form.input 
                    label="Bairro" 
                    name="neighborhood" 
                    placeholder="Digite o bairro" 
                    :value="old('neighborhood', $candidato->neighborhood ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Cidade" 
                    name="city" 
                    placeholder="Digite a cidade" 
                    :value="old('city', $candidato->city ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Estado" 
                    name="state" 
                    placeholder="Digite o estado" 
                    :value="old('state', $candidato->state ?? '')"
                    required 
                    cols="col-md-2"
                />                                                
            </div>
        </x-ui.card>

        <x-ui.card title="Contato">
            <div class="row">
                <x-form.input 
                    label="Telefone" 
                    name="phone" 
                    placeholder="Digite o telefone" 
                    :value="old('phone', $candidato->phone ?? '')"
                    required 
                    cols="col-md-4"
                />                                               
            </div>
        </x-ui.card>
    </x-form>  
</x-admin-layout>