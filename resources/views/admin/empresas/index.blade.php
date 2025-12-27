@php

    $items = collect([
        [
            'name' => 'Empresa XYZ',
            'email' => 'contato@empresaxyz.com',
            'telefone' => '(11) 99999-9999',
        ],
        [
            'name' => 'Empresa ABC',
            'email' => 'contato@empresaabc.com',
            'telefone' => '(11) 98888-8888',
        ],
    ]);

@endphp
<x-admin-layout>
    <x-ui.table 
        title="Empresas"
        :headers="['Nome', 'Email', 'Telefone']"
        rowView="admin.empresas._row"
        :items="$items"
    />
</x-admin-layout>
