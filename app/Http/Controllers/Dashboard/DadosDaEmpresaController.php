<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Company;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\RedirectResponse;

class DadosDaEmpresaController extends Controller
{
 
    public function index(): View
    {
        $empresa = auth()->user()->company;

        $formConfig = [
            'action' => $empresa ? route('dashboard.dados-da-empresa.update', $empresa->id) : route('dashboard.dados-da-empresa.store'),
            'method' => $empresa ? 'PUT' : 'POST',
        ];
        
        return view('dashboard.dados_empresa.index', compact('empresa', 'formConfig'));
    }
    
    public function store(CompanyRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('logo')) {
                $data['logo_path'] = $request->file('logo')->store('companies/logos', 'public');
            }
            
            unset($data['logo']);
            
            Company::create([
                ...$data,
                'user_id' => auth()->id(),
            ]);

            User::where('id', auth()->id())
                ->update(['email_verified_at' => now()]);
            
            return redirect()->route('dashboard.dados-da-empresa.index')
                ->with('success', 'Dados da empresa criados com sucesso.');
                
        } catch (\Exception $e) {
            logger()->error('Erro ao criar empresa: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'data' => $request->validated(),
                'trace' => $e->getTraceAsString()
            ]);            

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao salvar dados da empresa: ' . $e->getMessage());
        }             
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        try {
            $data = $request->validated();
            
            // Processa upload da logo
            if ($request->hasFile('logo')) {
                // Remove logo antiga se existir
                if ($company->logo_path && \Storage::disk('public')->exists($company->logo_path)) {
                    \Storage::disk('public')->delete($company->logo_path);
                }
                
                $data['logo_path'] = $request->file('logo')->store('companies/logos', 'public');
            }
            
            // Remove o campo 'logo' se existir, já que salvamos 'logo_path'
            unset($data['logo']);
            
            $company->update($data);

            return redirect()->route('dashboard.dados-da-empresa.index')
                ->with('success', 'Dados da empresa atualizados com sucesso.');
                
        } catch (\Exception $e) {
            logger()->error('Erro ao atualizar empresa: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'company_id' => $company->id,
                'data' => $request->validated(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar dados da empresa: ' . $e->getMessage());
        }
    }
}
