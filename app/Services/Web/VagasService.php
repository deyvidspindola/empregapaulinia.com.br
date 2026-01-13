<?php

namespace App\Services\Web;

use Carbon\Carbon;
use App\Mail\SendMail;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Models\JobPostingView;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;
use App\Models\JobPostingApplication;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Storage;

class VagasService
{

    public function getPublishedJobs(Request $request, $perPage = 10, $allowExpired = false)
    {
           
        $jobs = JobPosting::query()
            ->with(['company', 'category', 'user']);
    
        $jobs = $this->applyFilters($jobs, $request);
    
        return $jobs
            ->orderBy('created_at', 'desc')
            ->where(function ($query) use ($allowExpired) {
                if (!$allowExpired) {
                    $query->where('deadline', '>=', now())
                          ->orWhereNull('deadline');
                }
            })
            ->paginate($perPage);

    }

    public function getPublishedJobsForHome() 
    {
        $jobs = JobPosting::query()
            ->with(['company', 'category', 'user']);
        
        $limit = (int) setting('home_min_cards', 8);
        // $fillRandom = setting('home_fill_random', true);

        return $jobs
            ->orderBy('created_at', 'desc')
            ->where(function ($query) {
                $query->where('deadline', '>=', now())
                      ->orWhereNull('deadline');
            })
            ->limit($limit)
            ->get();

    }

    public function getJobBySlugOrId(string $slugOrId, Request $request): JobPosting
    {
        $job = JobPosting::query()
            ->with(['company', 'category', 'user'])
            ->where('slug', $slugOrId)
            ->orWhere('id', $slugOrId)
            ->firstOrFail();

        $companyName = $job->is_company_visible && $job->company
            ? $job->company->name
            : 'Empresa confidencial';

        $logo = $job->is_company_visible && $job->company && $job->company->logo_path
            ? asset('storage/' . $job->company->logo_path)
            : asset('images/resource/company-logo/5-1.png');

        $salary = $this->formatSalary($job->salary, 'BRL');
                
        $deadline = $job->deadline
            ? Carbon::parse($job->deadline)->locale('pt_BR')->isoFormat('D MMMM, YYYY')
            : '';

        $job->company_name = $companyName;
        $job->company_logo = $logo;
        $job->salary_display = $salary;
        $job->deadline_display = $deadline;

        $this->track($job->id, $request);

        return $job;
    }

    public function applyToJob(JobPosting $job, $data, $user): void
    {
        $resumePath = null;
        try {
            DB::transaction(function () use ($job, $data, $user):  void {

                if($this->hasAlreadyApplied($user->id, $job->id)) {
                    throw new ValidationException('Você já se candidatou a esta vaga.');
                }

                // Upload do currículo (se fornecido)                
                if (isset($data['resume'])) {
                    $resumePath = $this->uploadResume($data['resume']);
                }

                // Cria a candidatura
                $application = $this->createApplication($user, $job, $data, $resumePath);

                // Envia emails de notificação
                $this->sendApplicationEmails($application, $job);

            });    

        } catch (\Exception $e) {
            $this->cleanupResumeFile($resumePath);
            throw new BusinessException($e->getMessage());
        }

    }

    /**
     * Registra visualização da vaga (apenas uma vez por dia por sessão)
     */
    private function track(int $postingId, Request $request): void
    {
        $sessionId = $request->session()->getId();
        $today = now()->toDateString();

        // Verifica se já existe visualização hoje
        $exists = JobPostingView::query()
            ->where('job_posting_id', $postingId)
            ->where('session_id', $sessionId)
            ->where('viewed_on', $today)
            ->exists();

        if ($exists) {
            return; // Já contou hoje
        }

        JobPostingView::create([
            'job_posting_id' => $postingId,
            'user_id' => auth()->id(),
            'session_id' => $sessionId,
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'viewed_on' => $today,
        ]);
    }

    private function applyFilters($query, Request $request)
    {
        // Busca por palavra-chave
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('requirements', 'like', "%{$searchTerm}%")
                  ->orWhere(function ($subQ) use ($searchTerm) {
                      $subQ->whereHas('company', function ($compQ) use ($searchTerm) {
                          $compQ->where('name', 'like', "%{$searchTerm}%")
                                ->where('is_company_visible', true);
                      });
                  });
            });
        }

        // Filtro por localização
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where('location', 'like', "%{$location}%");
        }

        // Filtro por categoria
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        return $query;
    }


    private function uploadResume($file): string
    {
        // Gera nome único para evitar conflitos
        $filename = uniqid('resume_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('resumes', $filename, 'public');
    }

    private function hasAlreadyApplied(int $userId, int $jobId): bool
    {
        return JobPostingApplication::query()
            ->where('user_id', $userId)
            ->where('job_posting_id', $jobId)
            ->exists();
    }    

    private function createApplication($user, JobPosting $job, Request $request, ?string $resumePath): JobPostingApplication
    {
     
        try {
            return DB::transaction(function () use ($user, $job, $request, $resumePath): JobPostingApplication {
                return $user->jobApplications()->create([
                    'job_posting_id' => $job->id,
                    'company_id'     => $job->company_id,
                    'status'         => 'submitted',
                    'cover_letter'   => $request->input('cover_letter'),
                    'resume_path'    => $resumePath,
                    'meta' => [
                        'ip'         => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'applied_at' => now()->toDateTimeString(),
                    ],
                ]);
            });
        } catch (\Exception $e) {
            throw new BusinessException('Erro ao criar candidatura: ' . $e->getMessage());
        }

    }

    /**
     * Envia emails de notificação
     */
    private function sendApplicationEmails(JobPostingApplication $application, JobPosting $job): void
    {
        $application->load('user'); // Garante que user está carregado
        
        $this->sendMailToEmployer($application, $job);
        $this->sendMailToCandidate($application, $application->user);
    }

    /**
     * Envia email para o empregador
     */
    private function sendMailToEmployer(JobPostingApplication $application, JobPosting $job): void
    {
        $emailTo = $job->apply_method === 'email'
            ? $job->apply_email
            : $job->company->user->email;

        SendMail::to($emailTo)
            ->template(\App\Mail\NewJobApplicationMailEmployer::class, [$application, $job])
            ->send();
    }

    /**
     * Envia email para o candidato
     */
    private function sendMailToCandidate(JobPostingApplication $application, $user): void
    {
     
        SendMail::to($user->email)
            ->template(\App\Mail\NewJobApplicationMailCandidate::class, [$application, $user])
            ->send();        
    }

    /**
     * Remove arquivo de currículo em caso de erro
     */
    private function cleanupResumeFile(?string $resumePath): void
    {
        if ($resumePath && Storage::disk('public')->exists($resumePath)) {
            Storage::disk('public')->delete($resumePath);
        }
    }
    
    private function formatSalary($salary, $currency)
    {
        if ($salary === null || $salary <= 0) {
            return 'A Combinar';
        }

        if ($currency === 'BRL') {
            $salary = str_replace('.', '', $salary);
            $salary = str_replace(',', '.', $salary);
            return 'R$ ' . number_format((float) $salary, 2, ',', '.');
        }

        return $currency . ' ' . number_format($salary, 2);
    }


}