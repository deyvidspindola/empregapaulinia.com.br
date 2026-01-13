<x-admin-layout title="Menus" subtitle="Lista de menus cadastrados no sistema">
    <x-ui.table 
        title="Menus"
        :headers="['Menu', 'Role', 'Status', 'Cadastrado em', 'Atualizado em', 'Ações']"
        rowView="admin.menus._row"
        :items="$menus"
    >
        <x-slot name="toolbar">
            <x-ui.button 
                label="Adicionar Menu" 
                :route="route('admin.menus.create')" 
            />
        </x-slot>
    </x-ui.table>
</x-admin-layout>
