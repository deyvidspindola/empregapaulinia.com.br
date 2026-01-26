<?php

namespace App\Services\Employer;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;
use App\Services\Employer\WalletService;

class ProfileService
{
    private string $fileSystem;
    public function __construct(
        private WalletService $walletService
    )
    {
        $this->fileSystem = env('APP_FILE_SYSTEM', 'local');;
    }

    public function store(array $data, $user): Company
    {
        try {

            return DB::transaction(function () use ($data, $user): Company {
                if (isset($data['logo'])) {
                    $data['logo_path'] = $data['logo']->store('companies/image_profile', $this->fileSystem);
                }

                unset($data['logo']);

                $company = Company::create([
                    ...$data,
                    'user_id' => $user->id,
                ]);

                User::whereKey($user->id)
                    ->update(['email_verified_at' => now()]);

                // Credita créditos iniciais
                $initialCredits = setting('initial_credits', 30);
                $this->walletService->credit(
                    companyId: $company->id,
                    amount: $initialCredits,
                    reason: 'initial_credits',
                    meta: ['profile_creation' => true],
                    actorUserId: $user->id
                );

                return $company;
            });
                
        } catch (\Exception $e) {
            throw new BusinessException('Erro ao criar perfil da empresa', previous: $e);
        }    
    }

    public function update(Company $company, array $data, $user): Company
    {

        try {

            return DB::transaction(function () use ($company, $data, $user): Company {
                if (isset($data['logo'])) {
                    // Remove logo antiga se existir
                    if ($company->logo_path && \Storage::disk($this->fileSystem)->exists($company->logo_path)) {
                        \Storage::disk($this->fileSystem)->delete($company->logo_path);
                    }

                    $data['logo_path'] = $data['logo']->store('companies/logos', $this->fileSystem);
                    unset($data['logo']);
                }
                
                $company->update($data);
                $company->refresh();

                User::whereKey($user->id)
                    ->update(['email_verified_at' => now()]);

                return $company;
            });

        } catch (\Exception $e) {
            throw new BusinessException('Erro ao atualizar perfil da empresa', previous: $e);
        }
    }

}