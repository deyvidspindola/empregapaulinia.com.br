<?php

namespace App\Services;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Models\JobPostingView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class WebVagasService
{
    private $data = [];

    public function getVagas()
    {
        return JobPosting::active()->get();
    }

    public function getVagaBySlugOrId($slugOrId)
    {
        return JobPosting::active()
            ->where('slug', $slugOrId)
            ->orWhere('id', $slugOrId)
            ->firstOrFail();
    }

    public function track(int $postingId, Request $request): void
    {
        $sessionId = $request->session()->getId();

        $findForToday = JobPostingView::where('job_posting_id', $postingId)
            ->where('session_id', $sessionId)
            ->where('viewed_on', now()->toDateString())
            ->first();

        if ($findForToday) {
            return; // já contou hoje
        }

        JobPostingView::create([
            'job_posting_id' => $postingId,
            'user_id' => auth()->id(),
            'session_id' => $sessionId,
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'viewed_on' => now()->toDateString(),
        ]);
    }

    public function applyToJob(JobPosting $job, Request $request): array
    {
        DB::beginTransaction();
        $resumePath = null;

        try {
            $user = auth()->user();

            if (
                $user->jobApplications()
                    ->where('job_posting_id', $job->id)
                    ->exists()
            ) {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => 'Você já se candidatou a esta vaga.'
                ];
            }

            if ($request->hasFile('resume')) {
                $resumePath = $this->uploadResume($request->file('resume'));
            }

            $apply = $user->jobApplications()->create([
                'job_posting_id' => $job->id,
                'company_id'     => $job->company_id,
                'method'         => $job->apply_method,
                'status'         => 'submitted',
                'cover_letter'   => $request->input('cover_letter'),
                'resume_path'    => $resumePath,
                'meta' => [
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
            ]);

            if (!$apply) {
                throw new \Exception('Erro ao criar candidatura.');
            }

            $this->sendMailToEmployer($apply, $job);
            $this->sendMailToCandidate($apply, $user);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Candidatura realizada com sucesso!'
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            // 🔥 remove arquivo se algo falhou
            if ($resumePath && Storage::disk('public')->exists($resumePath)) {
                Storage::disk('public')->delete($resumePath);
            }

            logger()->error('Erro ao aplicar para vaga', [
                'error' => $e->getMessage(),
                'job_id' => $job->id,
                'user_id' => auth()->id(),
            ]);

            return [
                'success' => false,
                'message' => 'Não foi possível concluir sua candidatura. Tente novamente.'
            ];
        }
    }

    public function uploadResume($file): string
    {
        return $file->store('resumes', 'public');
    }

    private function sendMailToEmployer($application, JobPosting $job): void
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

    private function sendMailToCandidate($application, $user): void
    {
        Mail::to($user->email)->send(
            new \App\Mail\NewJobApplicationMailCandidate($application, $user)
        );

        if (count(Mail::failures()) > 0) {
            throw new \Exception('Falha ao enviar email para o candidato.');
        }
    }

}