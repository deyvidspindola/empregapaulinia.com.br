<?php

namespace App\Http\Controllers\Web;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Services\Web\VagasService;
use App\Http\Controllers\Controller;
use App\Models\JobCategory as Category;

class VagasController extends Controller
{

    public function __construct(
        private VagasService $vagasService,
        private Category $category
    ){}

    public function index(Request $request)
    {
        $jobs = $this->vagasService->getPublishedJobs($request, 10, true);
        $categories = $this->category->all();
        $jobTypes = \App\Http\Enum\JobTypes::options();
        return view(
            'web.vagas.index', 
            compact(
                'jobs', 
                'categories', 
                'jobTypes'
            )
        );
    }

    public function show($city, $slugOrId, Request $request)
    {
        $job = $this->vagasService->getJobBySlugOrId($slugOrId, $request);
        return view('web.vagas.show', compact('job'));
    }

    public function apply(JobPosting $job, Request $request)
    {
        $this->vagasService->applyToJob($job, $request, auth()->user());

        return redirect()
            ->back()
            ->with('success', 'Candidatura enviada com sucesso!');
    }

}
