<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;

class DadosDaEmpresaController extends Controller
{
 
    public function index()
    {
        $empresa = auth()->user()->company;

        $formConfig = [
            'action' => $empresa ? route('dashboard.dados-da-empresa.update', $empresa->id) : route('dashboard.dados-da-empresa.store'),
            'method' => $empresa ? 'PUT' : 'POST',
        ];
        
        return view('dashboard.dados_empresa.index', compact('empresa', 'formConfig'));
    }
    
    public function store(CompanyRequest $request)
    {
        logger('=== STORE METHOD CALLED ===');
        logger('Request Data:', $request->all());
        dd('Store method reached!', $request->all());

        Company::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        User::where('id', auth()->id())
        ->update(['email_verified_at' => now()]);
        
        return redirect()->route('dashboard.dados-da-empresa.index')
            ->with('success', 'Dados da empresa criados com sucesso.');             
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect()->route('dashboard.dados-da-empresa.index')
            ->with('success', 'Dados da empresa atualizados com sucesso.');
    }

}
