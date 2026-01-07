<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\WebVagasService;
use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\JobCategory as Category;

class VagasController extends Controller
{

    public function __construct(
        private WebVagasService $webVagasService,
        private Category $category
    ){}

    public function index(Request $request)
    {
        $jobs = $this->webVagasService->getAllVagas($request);
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
        $job = $this->webVagasService->getVagaBySlugOrId($slugOrId);
        $this->webVagasService->track($job->id, $request);
        return view('web.vagas.show', compact('job'));
    }

    public function apply(JobPosting $job, Request $request)
    {
         try {
            $applicationResult = $this->webVagasService->applyToJob($job, $request);
            
            if ($applicationResult['success']) {
                return redirect()->back()->with('success', 'Candidatura realizada com sucesso!');
            } else {
                return redirect()->back()->with('error', $applicationResult['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua candidatura. Por favor, tente novamente.');
        }
    }

}
