<?php

namespace App\Http\Controllers\Employer;

use App\Models\JobPosting;
use App\Http\Enum\JobTypes;
use App\Models\JobCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\VagasRequest;

class VagasController extends Controller
{

    public function __construct(
        protected JobPosting $jobPosting,
        protected JobCategory $jobCategory
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
        try {
            $this->beginTransaction();
            $user = auth()->user();
            $this->jobPosting->create([
                ...$request->validated(),
                'user_id' => $user->id,
                'company_id' => $user->company?->id,
                'slug' => \Str::slug($request->validated('title')),
            ]);
            $this->commitTransaction();

            return redirect()->route('employer.vagas.index')
                ->with('success', 'Vaga criada com sucesso!');

        } catch (\Throwable $e) {
            $this->rollbackTransaction();
            $this->logException($e);
            return back()->with('error', 'Houve um erro ao criar a vaga. Por favor, tente novamente mais tarde.');
        }
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
        try{
            $this->beginTransaction();
            $vaga->update([
                ...$request->validated(),
                'slug' => \Str::slug($request->validated('title')),
            ]);
            $this->commitTransaction();

            return redirect()->route('employer.vagas.index')
            ->with('success', 'Vaga atualizada com sucesso!');

        } catch (\Throwable $e) {
            $this->rollbackTransaction();
            $this->logException($e);
            return back()->with('error', 'Houve um erro ao atualizar a vaga. Por favor, tente novamente mais tarde.');
        }
    }

    public function destroy(JobPosting $vaga)
    {
        try{
            $this->beginTransaction();
            $vaga->delete();
            $this->commitTransaction();

            return redirect()->route('employer.vagas.index')
                ->with('success', 'Vaga excluída com sucesso!');

        } catch (\Throwable $e) {
            $this->rollbackTransaction();
            $this->logException($e);
            return back()->with('error', 'Houve um erro ao excluir a vaga. Por favor, tente novamente mais tarde.');
        }
    }

}
