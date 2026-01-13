@php
$sizes = ['1-10','11-50','51-200','201-500','501-1000','1000+'];
@endphp
<x-admin-layout title="Dados da Empresa" subtitle="Insira os dados da sua empresa">
    <x-form :formConfig="$formConfig">
        <x-ui.card title="Dados Da Empresa">
            <div class="row mb-4">
                <div class="col-12">
                    <label class="form-label fw-semibold">Logo da Empresa</label>
                    <div class="d-flex align-items-start gap-4">
                        <!-- Preview do Logo -->
                        @if($empresa && $empresa->logo_path)    
                            <div id="logo-preview-container" class="flex-shrink-0">
                                <div class="logo-preview-box">
                                    <img id="current-logo" src="{{ asset('storage/' . $empresa->logo_path) }}" alt="Logo da empresa">
                                </div>
                            </div>
                        @endif
                        
                        <!-- Botão de Upload -->
                        <div class="flex-grow-1">
                            <div class="uploadButton">
                                <input class="uploadButton-input" type="file" name="logo" accept="image/*" id="upload" />
                                <label class="uploadButton-button ripple-effect" for="upload">
                                    <i class="la la-cloud-upload"></i> {{ $empresa && $empresa->logo_path ? 'Alterar Logo' : 'Escolher Logo' }}
                                </label>
                                <span class="uploadButton-file-name"></span>
                            </div>
                            <div class="text mt-2">
                                <small class="text-muted">
                                    <i class="la la-info-circle"></i> 
                                    Tamanho máximo: 1MB | Dimensão mínima: 330x300px | Formatos: .jpg, .png
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
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
    
    @push('styles')
    <style>
        .logo-preview-box {
            width: 150px;
            height: 150px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .logo-preview-box:hover {
            border-color: #1967d2;
            box-shadow: 0 4px 12px rgba(25,103,210,0.15);
        }
        
        .logo-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .logo-preview-empty {
            flex-direction: column;
            background: #f8f9fa;
            border-style: dashed;
        }
    </style>
    @endpush
    
    @push('scripts')
    <script>
        document.getElementById('upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let currentLogo = document.getElementById('current-logo');
                    let emptyPreview = document.getElementById('empty-preview');
                    
                    if (currentLogo) {
                        // Atualiza logo existente
                        currentLogo.src = e.target.result;
                    } else if (emptyPreview) {
                        // Substitui o preview vazio por uma imagem
                        emptyPreview.classList.remove('logo-preview-empty');
                        emptyPreview.innerHTML = `<img id="current-logo" src="${e.target.result}" alt="Preview do logo">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush  
</x-admin-layout>