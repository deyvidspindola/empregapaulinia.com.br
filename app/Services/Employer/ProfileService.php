<?php

namespace App\Services\Employer;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;
use App\Services\Employer\WalletService;

class ProfileService
{

    public function __construct(
        private WalletService $walletService
    )
    {}

    public function store(array $data): Company
    {
        try {
            DB::beginTransaction();            

            if (isset($data['logo'])) {
                $data['logo_path'] = $data['logo']->store('companies/logos', 'public');
            }

            unset($data['logo']);

            $company = Company::create([
                ...$data,
                'user_id' => auth()->id(),
            ]);

            User::where('id', auth()->id())
                ->update(['email_verified_at' => now()]);

            // Credita créditos iniciais
            $initialCredits = setting('initial_credits', 30);
            $this->walletService->credit(
                companyId: $company->id,
                amount: $initialCredits,
                reason: 'initial_credits',
                meta: ['profile_creation' => true],
                actorUserId: auth()->id()
            );

            DB::commit();
            return $company;
                
        } catch (\Exception $e) {
            DB::rollBack();
            throw new BusinessException('Erro ao criar perfil da empresa', previous: $e);
        }    
    }

    public function update(Company $company, array $data): Company
    {
        try {
            DB::beginTransaction();

            if (isset($data['logo'])) {
                // Remove logo antiga se existir
                if ($company->logo_path && \Storage::disk('public')->exists($company->logo_path)) {
                    \Storage::disk('public')->delete($company->logo_path);
                }

                $data['logo_path'] = $data['logo']->store('companies/logos', 'public');
            }

            unset($data['logo']);

            $company->update($data);

            DB::commit();
            return $company;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new BusinessException('Erro ao atualizar perfil da empresa', previous: $e);
        }
    }

}