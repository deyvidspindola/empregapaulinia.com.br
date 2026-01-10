@php
$sizes = ['1-10','11-50','51-200','201-500','501-1000','1000+'];
@endphp
<x-admin-layout title="Dados da Empresa" subtitle="Insira os dados da sua empresa">

    @if(session('success'))
        <x-ui.message type="success" :message="session('success')" />
    @endif
    
    <x-form :formConfig="$formConfig">
        <x-ui.card title="Dados Da Empresa">
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
                    label="Nome da Empresa" 
                    name="name" 
                    placeholder="Digite o nome da empresa" 
                    :value="old('name', $empresa->name ?? '')"
                    required 
                    cols="col-md-6"
                />
                <x-form.input 
                    label="Nome Fantasia (opcional)" 
                    name="trade_name" 
                    placeholder="Digite o nome fantasia da empresa" 
                    :value="old('trade_name', $empresa->trade_name ?? '')"
                    cols="col-md-6"
                />
                <x-form.input 
                    label="CNPJ" 
                    name="tax_id" 
                    placeholder="Digite o CNPJ da empresa" 
                    :value="old('tax_id', $empresa->tax_id ?? '')"
                    required
                    data-mask="00.000.000/0000-00"
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Setor de Atividade" 
                    name="industry" 
                    placeholder="Digite o setor de atividade da empresa" 
                    :value="old('industry', $empresa->industry ?? '')"

                    cols="col-md-4"
                />
                <x-form.select
                    cols="col-md-4"
                    label="Categoria"
                    name="company_size"
                    :options="collect($sizes)->mapWithKeys(fn($s)=>[$s=> $s.' colaboradores'])->all()"                    
                    :selected="old('company_size', $empresa->company_size ?? '')"
                />                                                                            
            </div>
        </x-ui.card>

        <x-ui.card title="Endereço">
            <div class="row">
                <x-form.input-mask
                    label="CEP" 
                    name="zip" 
                    placeholder="Digite o CEP" 
                    :value="old('zip', $empresa->zip ?? '')"
                    required 
                    data-mask="00000-000"
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Endereço" 
                    name="street" 
                    placeholder="Digite o endereço" 
                    :value="old('street', $empresa->street ?? '')"
                    required
                    cols="col-md-8"
                />
                <x-form.input 
                    label="Número" 
                    name="number" 
                    placeholder="Digite o número" 
                    :value="old('number', $empresa->number ?? '')"
                    required 
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Complemento" 
                    name="complement" 
                    placeholder="Digite o complemento" 
                    :value="old('complement', $empresa->complement ?? '')"
                    cols="col-md-2"
                />                                            
                <x-form.input 
                    label="Bairro" 
                    name="neighborhood" 
                    placeholder="Digite o bairro" 
                    :value="old('neighborhood', $empresa->neighborhood ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Cidade" 
                    name="city" 
                    placeholder="Digite a cidade" 
                    :value="old('city', $empresa->city ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Estado" 
                    name="state" 
                    placeholder="Digite o estado" 
                    :value="old('state', $empresa->state ?? '')"
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
                    placeholder="Digite o telefone" 
                    :value="old('phone', $empresa->phone ?? '')"
                    required 
                    data-mask="(00) 00000-0000"
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Site (opcional)" 
                    name="website" 
                    placeholder="Digite o site" 
                    :value="old('website', $empresa->website ?? '')"
                    cols="col-md-8"
                />                                                
            </div>
        </x-ui.card>
    </x-form>  
</x-admin-layout>