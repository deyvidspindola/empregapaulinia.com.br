<?php

namespace App\Http\Controllers\Employer;

use App\Models\Company;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\RedirectResponse;
use App\Services\Employer\ProfileService;

class ProfileController extends Controller
{

    public function __construct(
        private ProfileService $profileService
    ){}

    public function index(): View
    {
        $empresa = auth()->user()->company;
        
        $formConfig = [
            'action' => $empresa ? route('employer.profile.update') : route('employer.profile.store'),
            'method' => $empresa ? 'PUT' : 'POST',
        ];
        
        return view('employer.profile.index', compact('empresa', 'formConfig'));
    }
    
    public function store(CompanyRequest $request): RedirectResponse
    {
        $this->profileService->store(
            $request->validated(), 
            auth()->user()
        );

        return redirect()->route('employer.profile.index')
            ->with('success', 'Perfil da empresa criado com sucesso.');         
    }

    public function update(CompanyRequest $request): RedirectResponse
    {
        $company = auth()->user()->company;
        
        if (!$company) {
            return redirect()->route('employer.profile.index')
                ->with('error', 'Empresa não encontrada.');
        }
        
        $this->profileService->update($company, $request->validated(), auth()->user());

        return redirect()->route('employer.profile.index')
            ->with('success', 'Perfil da empresa atualizado com sucesso.');
    }
}
