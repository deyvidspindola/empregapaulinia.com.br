@php

    $items = collect([
        [
            'id' => 1,
            'key' => 'below-list',
            'name' => 'Below list',
            'status' => 'Inativo',
            'network' => '',
            'creators' => '0',
        ],
        [
            'id' => 2,
            'key' => 'sidebar',
            'name' => 'Sidebar',
            'status' => 'Ativo',
            'network' => 'Google Ads',
            'creators' => '3',
        ],
        [
            'id' => 3,
            'key' => 'header',
            'name' => 'Header',
            'status' => 'Ativo',
            'network' => 'Facebook',
            'creators' => '2',
        ],
        [
            'id' => 4,
            'key' => 'footer',
            'name' => 'Footer',
            'status' => 'Inativo',
            'network' => '',
            'creators' => '1',
        ],
    ]);

@endphp
<x-admin-layout>
    <x-ui.table 
        title="Anuncios"
        :headers="['Chave', 'Nome', 'Status', 'Rede', 'Criativos', 'Ações']"
        rowView="admin.anuncios._row"
        :items="$items"
    >
        <x-slot name="toolbar">
            <x-ui.button 
                label="Adicionar Anuncio" 
                :route="route('admin.anuncios')" 
            />
        </x-slot>
    </x-ui.table>
</x-admin-layout>