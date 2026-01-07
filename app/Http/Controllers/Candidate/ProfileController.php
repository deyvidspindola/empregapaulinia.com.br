<?php

namespace App\Http\Controllers\Candidate;

use App\Models\User;
use App\Models\Candidate;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CandidateRequest;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = auth()->user()->candidate;

        $formConfig = [
            'action' => $user ? route('candidate.profile.update', $user->id) : route('candidate.profile.store'),
            'method' => $user ? 'PUT' : 'POST',
        ];
        
        return view('candidate.profile.index', compact('user', 'formConfig'));
    }

    public function store(CandidateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('candidates/logos', 'public');
        }
        
        unset($data['logo']);
        
        Candidate::create([
            ...$data,
            'user_id' => auth()->id(),
        ]);

        User::where('id', auth()->id())
            ->update([
                'name' => $data['full_name'],
                'email_verified_at' => now()
            ]);
        
        return redirect()->route('candidate.profile.index')
            ->with('success', 'Dados do candidato criados com sucesso.');   
    }

    public function update(CandidateRequest $request, Candidate $candidate): RedirectResponse
    {
        $data = $request->validated();
        
        // Processa upload da logo
        if ($request->hasFile('logo')) {
            // Remove logo antiga se existir
            if ($candidate->logo_path && \Storage::disk('public')->exists($candidate->logo_path)) {
                \Storage::disk('public')->delete($candidate->logo_path);
            }
            
            $data['logo_path'] = $request->file('logo')->store('candidates/logos', 'public');
        }
        
        // Remove o campo 'logo' se existir, já que salvamos 'logo_path'
        unset($data['logo']);
        
        $candidate->update($data);

        return redirect()->route('candidate.profile.index')
            ->with('success', 'Dados do candidato atualizados com sucesso.');
    }


}
