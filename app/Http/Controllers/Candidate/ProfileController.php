<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CandidateRequest;
use App\Services\Candidate\ProfileService;

class ProfileController extends Controller
{

    public function __construct(
        private ProfileService $profileService
    ){}

    public function index(): View
    {
        $user = auth()->user()->candidate;

        $formConfig = [
            'action' => $user ? route('candidate.profile.update') : route('candidate.profile.store'),
            'method' => $user ? 'PUT' : 'POST',
        ];
        
        return view('candidate.profile.index', compact('user', 'formConfig'));
    }

    public function store(CandidateRequest $request): RedirectResponse
    {
        $this->profileService->store(
            $request->validated(), 
            auth()->user()
        );

        return redirect()->route('candidate.profile.index')
            ->with('success', 'Perfil do candidato criado com sucesso.');
    }

    public function update(CandidateRequest $request): RedirectResponse
    {
        $candidate = auth()->user()->candidate;
        
        if (!$candidate) {
            return redirect()->route('candidate.profile.index')
                ->with('error', 'Perfil não encontrado.');
        }
        
        $this->profileService->update($candidate, $request->validated());

        return redirect()->route('candidate.profile.index')
            ->with('success', 'Perfil do candidato atualizado com sucesso.');
    }


}
