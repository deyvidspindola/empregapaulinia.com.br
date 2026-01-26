<x-admin-layout title="Candidatos" subtitle="Lista de candidatos cadastrados no sistema">
    <x-ui.table 
        title="Candidatos"
        :headers="['Nome', 'Idade', 'Cidade', 'email', 'Cadastrado em']"
        rowView="admin.candidatos._row"
        :items="$candidates"
    />
</x-admin-layout>
