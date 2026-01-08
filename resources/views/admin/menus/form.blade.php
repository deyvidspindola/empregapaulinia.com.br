@php
    $parentMenus = [
        'admin' => 'Admin',
        'employee' => 'Empresa',
        'candidate' => 'Candidato',
    ];
@endphp
<x-admin-layout title="Menus" subtitle="">
    <x-ui.card title="Dados do Menu">
        <x-form :formConfig="$formConfig">
            <x-form.switch 
                label="Ativo?" 
                name="active" 
                :options="[1 => 'Sim']"
                :checked="old('active', $menu->active ?? true)" 
                cols="col-md-12"
            />            
            <x-form.input 
                label="Menu" 
                name="label" 
                placeholder="Digite o título do menu" 
                :value="old('label', $menu->label ?? '')"
                required 
                cols="col-md-8"
            />  
            <x-form.input 
                label="Ícone" 
                name="icon" 
                placeholder="Digite o ícone do menu" 
                :value="old('icon', $menu->icon ?? '')"
                required 
                cols="col-md-4"
            />
            <x-form.input 
                label="Rota" 
                name="route" 
                placeholder="Digite a rota do menu" 
                :value="old('route', $menu->route ?? '')"
                required 
                cols="col-md-4"
            />
            <x-form.input 
                label="Posição" 
                name="position" 
                placeholder="Digite a posição do menu" 
                :value="old('position', $menu->position ?? '')"
                required 
                cols="col-md-4"
            />
            <x-form.select 
                label="Role" 
                name="role" 
                :options="$parentMenus" 
                :selected="old('role', $menu->role ?? '')" 
                placeholder="Selecione a role do menu"
                required
                cols="col-md-4"
            /> 
        </x-form>
    </x-ui.card>
</x-admin-layout>