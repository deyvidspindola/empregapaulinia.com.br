<x-admin-layout title="Empresas" subtitle="Lista de empresas cadastradas no sistema">
    <x-ui.table 
        title="Empresas"
        :headers="['Empresa', 'Responsavel', 'Cidade', 'industry', 'Cadastrado em']"
        rowView="admin.empresas._row"
        :items="$companies"
    />
</x-admin-layout>
