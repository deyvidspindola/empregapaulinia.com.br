@php

    $items = collect([
        [
            'id' => 1,
            'name' => 'Empresa XYZ',
            'email' => 'contato@empresaxyz.com',
            'telefone' => '(11) 99999-9999',
        ],
        [
            'id' => 2,
            'name' => 'Empresa ABC',
            'email' => 'contato@empresaabc.com',
            'telefone' => '(11) 98888-8888',
        ],
    ]);

@endphp
<x-admin-layout>
    <x-ui.table 
        title="Candidatos"
        :headers="['Nome', 'Email', 'Telefone', 'Ações']"
        rowView="admin.candidatos._row"
        :items="$items"
    >
        <x-slot name="toolbar">
            <x-ui.button 
                label="Adicionar Candidato" 
                :route="route('admin.candidatos')" 
            />
        </x-slot>
    </x-ui.table>
</x-admin-layout>