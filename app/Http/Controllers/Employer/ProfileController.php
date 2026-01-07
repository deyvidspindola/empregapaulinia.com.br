<?php

namespace App\Http\Controllers\Employer;

use App\Models\User;
use App\Models\Company;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(): View
    {
        $empresa = auth()->user()->company;

        $formConfig = [
            'action' => $empresa ? route('employer.profile.update', $empresa->id) : route('employer.profile.store'),
            'method' => $empresa ? 'PUT' : 'POST',
        ];
        
        return view('employer.profile.index', compact('empresa', 'formConfig'));
    }
    
    public function store(CompanyRequest $request): RedirectResponse
    {
        try {
            $this->beginTransaction();
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
            
            $this->commitTransaction();

            return redirect()->route('employer.profile.index')
                ->with('success', 'Dados da empresa criados com sucesso.');
                
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            $this->logException($e);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao salvar dados da empresa: ' . $e->getMessage());
        }             
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        try {
            $this->beginTransaction();
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
            $this->commitTransaction();

            return redirect()->route('employer.profile.index')
                ->with('success', 'Dados da empresa atualizados com sucesso.');
                
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            $this->logException($e);
                            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar dados da empresa: ' . $e->getMessage());
        }
    }
}
