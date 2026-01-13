<?php

namespace App\Http\Controllers\Employer;

use App\Models\JobPosting;
use App\Http\Enum\JobTypes;
use App\Models\JobCategory;
use App\Http\Requests\VagasRequest;
use App\Http\Controllers\Controller;
use App\Services\Employer\VagasService;

class VagasController extends Controller
{

    public function __construct(
        protected JobPosting $jobPosting,
        protected JobCategory $jobCategory,
        protected VagasService $vagasService
    ) {}

    public function index()
    {
        $jobs = $this->jobPosting
            ->where('company_id', auth()->user()->company?->id)
            ->paginate(10);
            
        return view('employer.vagas.index', 
            compact(
                'jobs'
            )
        );
    }

    public function create()
    {
        $categories = $this->jobCategory->all()->pluck('name', 'id');
        $jobTypes = JobTypes::options();
        $formConfig = [
            'method' => 'POST',
            'action' => route('employer.vagas.store'),
        ];
        return view('employer.vagas.form', 
            compact(
                'categories',
                'jobTypes',
                'formConfig'
                )
        );
    }

    public function store(VagasRequest $request) 
    {
        $this->vagasService->store(
            $request->validated(),
            auth()->user()
        );

        return redirect()->route('employer.vagas.index')
            ->with('success', 'Vaga criada com sucesso!');
    }

    public function edit(JobPosting $vaga)
    {
        $categories = $this->jobCategory->all()->pluck('name', 'id');
        $jobTypes = JobTypes::options();
        $formConfig = [
            'method' => 'PUT',
            'action' => route('employer.vagas.update', $vaga),
        ];
        return view('employer.vagas.form', 
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
        $this->vagasService->update(
            $vaga,
            $request->validated()
        );

        return redirect()->route('employer.vagas.index')
            ->with('success', 'Vaga atualizada com sucesso!');
    }

    public function destroy(JobPosting $vaga)
    {
        $this->vagasService->delete($vaga);

        return redirect()->route('employer.vagas.index')
            ->with('success', 'Vaga deletada com sucesso!');
    }

}
