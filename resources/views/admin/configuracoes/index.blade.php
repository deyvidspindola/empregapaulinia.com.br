<x-admin-layout>

    <x-slot name="pageHeader">
        <div class="upper-title-box">
          <h3>Configurações Gerais</h3>
          <div class="text"></div>
        </div>
    </x-slot>

    <x-form>
        <x-ui.card title="Ads">
            <div class="row">
                <x-form.input 
                    label="Google AdSense Código" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-4"
                    value=""
                />
                <x-form.input 
                    label="Google AdSense Código" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-4"
                    value=""
                />
                <x-form.input 
                    label="Google AdSense Código" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-4"
                    value=""
                />                                           
            </div>
        </x-ui.card>

        <x-ui.card title="Home">
            <div class="row">
                <x-form.input 
                    label="Minimo de cards na home" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-4"
                    value=""
                />
                <x-form.input 
                    label="Exibir ads a cada quantas vagas? (Home)" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-4"
                    value=""
                />
                <x-form.input 
                    label="Exibir ads a cada quantas vagas (Vagas)?" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-4"
                    value=""
                />
                <x-form.switch 
                    name="show_partner_companies" 
                    :options="[
                        ['value' => 1, 'label' => 'Preencher com vagas aleatórias'],
                    ]" 
                    :checked="1"
                    class="col-lg-4"
                />                             
            </div>
        </x-ui.card> 
        
        <x-ui.card title="Pagamentos">
            <div class="row">
                <x-form.input 
                    label="InfinitePay Handle" 
                    name="infinitepay_handle" 
                    type="text" 
                    placeholder="InfinitePay Handle" 
                    class="col-lg-2"
                    value=""
                />
                <x-form.input 
                    label="URL de Retorno" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-5"
                    value=""
                />
                <x-form.input 
                    label="Prefixo do item" 
                    name="adsense_code" 
                    type="text" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-5"
                    value=""
                />
                <x-form.textarea 
                    label="Planos de Créditos (JSON)" 
                    name="adsense_code" 
                    placeholder="Insira o código do Google AdSense" 
                    class="col-lg-6"
                    value=""
                />                          
            </div>
        </x-ui.card> 
    </x-form>

</x-admin-layout>