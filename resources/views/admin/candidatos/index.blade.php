<x-admin-layout title="Candidatos" subtitle="Lista de candidatos cadastrados no sistema">
    <x-ui.table 
        title="Candidatos"
        :headers="['Nome', 'Cidade', 'email', 'Cadastrado em']"
        rowView="admin.candidates._row"
        :items="$candidates"
    />
</x-admin-layout>
