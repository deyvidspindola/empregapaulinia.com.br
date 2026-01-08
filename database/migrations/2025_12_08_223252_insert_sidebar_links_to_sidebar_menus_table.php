<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('sidebar_menus')->insert([
            // admin links
            [ 'label' => 'Dashboard',       'icon' => 'la-tachometer-alt',  'route' => 'admin.dashboard',      'position' => 1, 'role' => 'admin'],
            [ 'label' => 'Empresas',        'icon' => 'la-building',        'route' => 'admin.empresas',       'position' => 2, 'role' => 'admin'],
            [ 'label' => 'Candidatos',      'icon' => 'la-user-tie',        'route' => 'admin.candidatos',     'position' => 3, 'role' => 'admin'],
            [ 'label' => 'Anúncios',        'icon' => 'la-bullhorn',        'route' => 'admin.anuncios',       'position' => 4, 'role' => 'admin'],            
            [ 'label' => 'Menus',           'icon' => 'la-bullhorn',        'route' => 'admin.menus',          'position' => 5, 'role' => 'admin'],            
            [ 'label' => 'Configurações',   'icon' => 'la-cog',             'route' => 'admin.configuracoes',  'position' => 6, 'role' => 'admin'],

            // employer links
            [ 'label' => 'Dashboard',        'icon' => 'la-tachometer-alt',  'route' => 'employer.dashboard',     'position' => 1, 'role' => 'employer'],
            [ 'label' => 'Vagas',            'icon' => 'la-briefcase',       'route' => 'employer.vagas.index',   'position' => 2, 'role' => 'employer'],
            [ 'label' => 'Candidatos',       'icon' => 'la-users',           'route' => 'employer.candidatos',    'position' => 3, 'role' => 'employer'],
            [ 'label' => 'Carteira',         'icon' => 'la-wallet',          'route' => 'employer.carteira',      'position' => 4, 'role' => 'employer'],
            [ 'label' => 'Planos',           'icon' => 'la-layer-group',     'route' => 'employer.planos',        'position' => 5, 'role' => 'employer'],
            [ 'label' => 'Dados da Empresa', 'icon' => 'la-building',        'route' => 'employer.profile.index', 'position' => 6, 'role' => 'employer'],
            
            // candidate links
            [ 'label' => 'Dashboard',     'icon' => 'la-tachometer-alt', 'route' => 'candidate.dashboard',     'position' => 1, 'role' => 'candidate'],
            [ 'label' => 'Candidaturas',  'icon' => 'la-check-circle',   'route' => 'candidate.candidaturas',  'position' => 3, 'role' => 'candidate'],
            [ 'label' => 'Perfil',        'icon' => 'la-user',           'route' => 'candidate.profile.index', 'position' => 4, 'role' => 'candidate'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('sidebar_menus')->truncate();
    }
};
