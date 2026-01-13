<?php

namespace App\Services\Employer;

use App\Models\JobPosting;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;

class VagasService
{
    
    public function store(array $data, $user): mixed
    {
        try {

            return DB::transaction(function () use ($data, $user): JobPosting {
                return JobPosting::create([
                    ...$data,
                    'user_id' => $user->id,
                    'company_id' => $user->company?->id,
                    'slug' => \Str::slug($data['title']),
                ]);
            });

        } catch (\Exception $e) {
            throw new BusinessException('Erro ao criar vaga: ' . $e->getMessage());
        }
    }

    public function update(JobPosting $jobPosting, array $data): mixed
    {
        try {

            return DB::transaction(function () use ($jobPosting, $data): JobPosting {
                $jobPosting->update([
                    ...$data,
                    'slug' => \Str::slug($data['title']),
                ]);
                return $jobPosting;
            });

        } catch (\Exception $e) {
            throw new BusinessException('Erro ao atualizar vaga: ' . $e->getMessage());
        }
    }

    public function delete(JobPosting $jobPosting): void
    {
        try {

            DB::transaction(function () use ($jobPosting): void {

                if($jobPosting->applications()->count() > 0) {
                    throw new BusinessException('Não é possível deletar uma vaga que possui candidaturas.');
                }

                $jobPosting->delete();
            });

        } catch (\Exception $e) {
            throw new BusinessException('Erro ao deletar vaga: ' . $e->getMessage());
        }
    }

}