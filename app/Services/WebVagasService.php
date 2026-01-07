<?php

namespace App\Services;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Models\JobPostingView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\JobPostingApplication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Sentry\Laravel\Facade as Sentry;

class WebVagasService
{
    /**
     * Retorna todas as vagas ativas (simplificado)
     */
    public function getVagas()
    {
        return JobPosting::query()
            ->active()
            ->with(['company', 'category']) // Eager loading para evitar N+1
            ->get();
    }

    /**
     * Retorna vagas com filtros e paginação
     */
    public function getAllVagas(Request $request): LengthAwarePaginator
    {
        $query = JobPosting::query()
            ->with(['company', 'category', 'user']);

        $query = $this->applyFilters($query, $request);

        return $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Busca vaga por slug ou ID
     */
    public function getVagaBySlugOrId(string $slugOrId): JobPosting
    {
        return JobPosting::query()
            ->with(['company', 'category', 'user'])
            ->where('slug', $slugOrId)
            ->orWhere('id', $slugOrId)
            ->firstOrFail();
    }

    /**
     * Registra visualização da vaga (apenas uma vez por dia por sessão)
     */
    public function track(int $postingId, Request $request): void
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

    /**
     * Processa candidatura para uma vaga
     */
    public function applyToJob(JobPosting $job, Request $request): array
    {
        DB::beginTransaction();
        $resumePath = null;

        try {
            $user = auth()->user();

            // Verifica duplicata
            if ($this->hasAlreadyApplied($user->id, $job->id)) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Você já se candidatou a esta vaga.'
                ];
            }

            // Upload do currículo (se fornecido)
            if ($request->hasFile('resume')) {
                $resumePath = $this->uploadResume($request->file('resume'));
            }

            // Cria a candidatura
            $application = $this->createApplication($user, $job, $request, $resumePath);

            // Envia emails de notificação
            $this->sendApplicationEmails($application, $job);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Candidatura realizada com sucesso!'
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            // Limpa arquivo em caso de erro
            $this->cleanupResumeFile($resumePath);

            Sentry::captureException($e);

            return [
                'success' => false,
                'message' => 'Não foi possível concluir sua candidatura. Tente novamente.'
            ];
        }
    }

    /**
     * Upload do arquivo de currículo
     */
    public function uploadResume($file): string
    {
        // Gera nome único para evitar conflitos
        $filename = uniqid('resume_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('resumes', $filename, 'public');
    }

    // ========================================
    // Métodos Privados
    // ========================================

    /**
     * Aplica filtros na query
     */
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

    /**
     * Verifica se usuário já se candidatou
     */
    private function hasAlreadyApplied(int $userId, int $jobId): bool
    {
        return JobPostingApplication::query()
            ->where('user_id', $userId)
            ->where('job_posting_id', $jobId)
            ->exists();
    }

    /**
     * Cria o registro de candidatura
     */
    private function createApplication($user, JobPosting $job, Request $request, ?string $resumePath): JobPostingApplication
    {
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

        Mail::to($emailTo)->send(
            new \App\Mail\NewJobApplicationMailEmployer($application, $job)
        );

        if (count(Mail::failures()) > 0) {
            throw new \Exception('Falha ao enviar email para o empregador.');
        }
    }

    /**
     * Envia email para o candidato
     */
    private function sendMailToCandidate(JobPostingApplication $application, $user): void
    {
        Mail::to($user->email)->send(
            new \App\Mail\NewJobApplicationMailCandidate($application, $user)
        );

        if (count(Mail::failures()) > 0) {
            throw new \Exception('Falha ao enviar email para o candidato.');
        }
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
}
