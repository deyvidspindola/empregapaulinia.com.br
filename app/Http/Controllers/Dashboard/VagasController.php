<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\JobPosting;
use App\Http\Enum\JobTypes;
use App\Models\JobCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\VagasRequest;

class VagasController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::paginate(10);
        return view('dashboard.vagas.index', 
            compact(
                'jobs'
            )
        );
    }

    public function create()
    {
        $categories = JobCategory::all()->pluck('name', 'id');
        $jobTypes = JobTypes::options();
        $formConfig = [
            'method' => 'POST',
            'action' => route('dashboard.vagas.store'),
        ];
        return view('dashboard.vagas.form', 
            compact(
                'categories',
                'jobTypes',
                'formConfig'
                )
        );
    }

    public function store(VagasRequest $request) 
    {
        $user = auth()->user();
        JobPosting::create([
            ...$request->validated(),
            'user_id' => $user->id,
            'company_id' => $user->company?->id,
            'slug' => \Str::slug($request->validated('title')),
        ]);
        
        return redirect()->route('dashboard.vagas.index')
            ->with('success', 'Vaga criada com sucesso!');
    }

    public function edit(JobPosting $vaga)
    {
        $categories = JobCategory::all()->pluck('name', 'id');
        $jobTypes = JobTypes::options();
        $formConfig = [
            'method' => 'PUT',
            'action' => route('dashboard.vagas.update', $vaga),
        ];
        return view('dashboard.vagas.form', 
            compact(
                'vaga',
                'categories',
                'jobTypes',
                'formConfig'
                )
        );
    }

    public function update(VagasRequest $request, JobPosting $vaga)
    {
        $vaga->update($request->validated());

        return redirect()->route('dashboard.vagas.index')
            ->with('success', 'Vaga atualizada com sucesso!');
    }

    public function destroy(JobPosting $vaga)
    {
        $vaga->delete();

        return redirect()->route('dashboard.vagas.index')
            ->with('success', 'Vaga excluída com sucesso!');
    }

}
