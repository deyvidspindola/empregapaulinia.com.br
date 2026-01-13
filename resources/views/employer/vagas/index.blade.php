<x-admin-layout title="Vagas" subtitle="Lista de vagas cadastradas">
    <x-ui.table 
        title="Vagas"
        :headers="['Vaga', 'Status', 'Publicada em', 'Atualizada em', 'Expira em', 'Ações']"
        rowView="employer.vagas._row"
        :items="$jobs"
    >
        <x-slot name="toolbar">
            <x-ui.button 
                label="Adicionar Vaga" 
                :route="route('employer.vagas.create')" 
            />
        </x-slot>
    </x-ui.table>
</x-admin-layout>