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
                                    @error('logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror                                       
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
                    id="zip"
                    placeholder="Digite o CEP" 
                    :value="old('zip', $empresa->zip ?? '')"
                    required 
                    data-mask="00000-000"
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Endereço" 
                    name="street"
                    id="street"
                    placeholder="Digite o endereço" 
                    :value="old('street', $empresa->street ?? '')"
                    required
                    cols="col-md-8"
                />
                <x-form.input 
                    label="Número" 
                    name="number"
                    id="number"
                    placeholder="Digite o número" 
                    :value="old('number', $empresa->number ?? '')"
                    required 
                    cols="col-md-2"
                />
                <x-form.input 
                    label="Complemento" 
                    name="complement"
                    id="complement"
                    placeholder="Digite o complemento" 
                    :value="old('complement', $empresa->complement ?? '')"
                    cols="col-md-2"
                />                                            
                <x-form.input 
                    label="Bairro" 
                    name="neighborhood"
                    id="neighborhood"
                    placeholder="Digite o bairro" 
                    :value="old('neighborhood', $empresa->neighborhood ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Cidade" 
                    name="city"
                    id="city"
                    placeholder="Digite a cidade" 
                    :value="old('city', $empresa->city ?? '')"
                    required 
                    cols="col-md-4"
                />
                <x-form.input 
                    label="Estado" 
                    name="state"
                    id="state"
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
        $(document).ready(function() {
            // Preview do logo ao selecionar
            const uploadInput = document.getElementById('upload');
            if (uploadInput) {
                uploadInput.addEventListener('change', function(e) {
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
            }

            // ========== BUSCA DE CEP VIA VIACEP ==========
            const CepAutocomplete = {
                timer: null,
                isSearching: false,
                
                // Cache dos elementos do formulário
                elements: {
                    cep: null,
                    street: null,
                    neighborhood: null,
                    city: null,
                    state: null,
                    number: null
                },
                
                // Inicializa o autocomplete
                init: function() {
                    this.cacheElements();
                    
                    if (!this.elements.cep) {
                        console.error('Campo CEP (#zip) não foi encontrado no formulário');
                        return;
                    }
                    
                    this.bindEvents();
                    console.log('Autocomplete de CEP inicializado com sucesso');
                },
                
                // Armazena referências dos elementos
                cacheElements: function() {
                    this.elements.cep = $('#zip');
                    this.elements.street = $('#street');
                    this.elements.neighborhood = $('#neighborhood');
                    this.elements.city = $('#city');
                    this.elements.state = $('#state');
                    this.elements.number = $('#number');
                },
                
                // Vincula eventos ao campo CEP
                bindEvents: function() {
                    const self = this;
                    
                    // Evento de digitação (com debounce)
                    this.elements.cep.on('input keyup', function() {
                        clearTimeout(self.timer);
                        const cep = self.cleanCep($(this).val());
                        
                        if (cep.length === 8) {
                            self.timer = setTimeout(() => {
                                self.searchCep(cep);
                            }, 600);
                        } else {
                            self.clearAddressFields();
                        }
                    });
                    
                    // Evento de perda de foco
                    this.elements.cep.on('blur', function() {
                        clearTimeout(self.timer);
                        const cep = self.cleanCep($(this).val());
                        
                        if (cep.length === 8) {
                            self.searchCep(cep);
                        }
                    });
                },
                
                // Remove caracteres não numéricos do CEP
                cleanCep: function(cep) {
                    return String(cep || '').replace(/\D/g, '');
                },
                
                // Limpa os campos de endereço
                clearAddressFields: function() {
                    if (!this.isSearching) {
                        this.elements.street.val('');
                        this.elements.neighborhood.val('');
                        this.elements.city.val('');
                        this.elements.state.val('');
                    }
                },
                
                // Busca o CEP na API ViaCEP
                searchCep: function(cep) {
                    if (this.isSearching || cep.length !== 8) {
                        return;
                    }
                    
                    this.isSearching = true;
                    this.setLoadingState(true);
                    
                    const self = this;
                    
                    $.ajax({
                        url: `https://viacep.com.br/ws/${cep}/json/`,
                        method: 'GET',
                        dataType: 'json',
                        timeout: 10000,
                        cache: false
                    })
                    .done(function(data) {
                        if (data.erro) {
                            self.showError('CEP não encontrado. Por favor, verifique o número digitado.');
                            self.clearAddressFields();
                        } else {
                            self.fillAddress(data);
                        }
                    })
                    .fail(function(jqXHR, textStatus) {
                        if (textStatus === 'timeout') {
                            self.showError('Tempo esgotado ao buscar CEP. Verifique sua conexão.');
                        } else {
                            self.showError('Erro ao buscar CEP. Tente novamente.');
                        }
                        console.error('Erro ao buscar CEP:', textStatus);
                    })
                    .always(function() {
                        self.isSearching = false;
                        self.setLoadingState(false);
                    });
                },
                
                // Preenche os campos com os dados do ViaCEP
                fillAddress: function(data) {
                    // Preenche apenas os campos que vieram preenchidos da API
                    if (data.logradouro) {
                        this.elements.street.val(data.logradouro).prop('readonly', true);
                    } else {
                        this.elements.street.val('').prop('readonly', false);
                    }
                    
                    if (data.bairro) {
                        this.elements.neighborhood.val(data.bairro).prop('readonly', true);
                    } else {
                        this.elements.neighborhood.val('').prop('readonly', false);
                    }
                    
                    if (data.localidade) {
                        this.elements.city.val(data.localidade).prop('readonly', true);
                    } else {
                        this.elements.city.val('').prop('readonly', false);
                    }
                    
                    if (data.uf) {
                        this.elements.state.val(data.uf).prop('readonly', true);
                    } else {
                        this.elements.state.val('').prop('readonly', false);
                    }
                    
                    // Move o foco para o campo de número
                    setTimeout(() => {
                        this.elements.number.focus().select();
                    }, 150);
                    
                    console.log('Endereço preenchido com sucesso:', data);
                },
                
                // Define o estado de carregamento dos campos
                setLoadingState: function(isLoading) {
                    const fields = [
                        this.elements.street,
                        this.elements.neighborhood,
                        this.elements.city,
                        this.elements.state
                    ];
                    
                    fields.forEach(($field) => {
                        if ($field && $field.length) {
                            $field.prop('disabled', isLoading);
                            
                            if (isLoading) {
                                $field.css({
                                    'opacity': '0.5',
                                    'cursor': 'wait'
                                });
                            } else {
                                $field.css({
                                    'opacity': '1',
                                    'cursor': ''
                                });
                            }
                        }
                    });
                    
                    // Adiciona indicador visual no campo CEP
                    if (isLoading) {
                        this.elements.cep.addClass('border-primary');
                    } else {
                        this.elements.cep.removeClass('border-primary');
                    }
                },
                
                // Exibe mensagem de erro
                showError: function(message) {
                    // Você pode customizar esta função para usar um sistema de notificações mais sofisticado
                    alert(message);
                }
            };
            
            // Inicializa o autocomplete quando o documento estiver pronto
            CepAutocomplete.init();
        });
    </script>
    @endpush  
</x-admin-layout>