<?php

namespace App\Services\Employer;

use App\Exceptions\ValidationException;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;
use App\Repository\Employer\WalletRepository;

class WalletService
{

    public function __construct(
        private WalletRepository $repository
    ) {}

    /**
     * Credita créditos na carteira, registrando no extrato.
     */
    public function credit(
        int $companyId,
        int $amount,
        ?string $reason = 'purchase',
        array $meta = [],
        ?int $actorUserId = null
    ): Wallet {

        try {
            $this->validateAmount($amount);

            return DB::transaction(function () use ($companyId, $amount, $reason, $meta, $actorUserId): Wallet {
                // lock pessimista + cria se não existir
                $wallet = $this->repository->getByCompanyIdForUpdate($companyId);

                // ajusta saldo
                $wallet = $this->repository->incrementBalance($wallet, $amount);

                // registra transação (usar argumentos nomeados evita troca de ordem)
                $this->repository->createTransaction(
                    wallet: $wallet,
                    type: 'credit',
                    amount: $amount,
                    reason: $reason,
                    actorUserId: $actorUserId,
                    meta: $meta
                );

                return $wallet;
            });

        } catch (\Exception $e) {
            throw new BusinessException(
                message: 'Erro ao creditar a carteira',
                httpCode: 500,
                context: [
                    'companyId' => $companyId,
                    'amount' => $amount,
                    'reason' => $reason,
                    'meta' => $meta,
                    'actorUserId' => $actorUserId,
                    'originalMessage' => $e->getMessage(),
                ],
                shouldReport: true,
                previous: $e
            );
        }            
    }

    /**
     * Debita créditos da carteira, registrando no extrato.
     */
    public function debit(
        int $companyId,
        int $amount,
        ?string $reason = 'debit',
        array $meta = [],
        ?int $actorUserId = null
    ): Wallet {
        try {
            $this->validateAmount($amount);

            return DB::transaction(function () use ($companyId, $amount, $reason, $meta, $actorUserId) {
                $wallet = $this->repository->getByCompanyIdForUpdate($companyId);

                if ($wallet->balance < $amount) {
                    throw new ValidationException('Créditos insuficientes.');
                }

                $wallet = $this->repository->decrementBalance($wallet, $amount);

                // manter argumentos nomeados aqui também
                $this->repository->createTransaction(
                    wallet: $wallet,
                    type: 'debit',
                    amount: $amount,
                    reason: $reason,
                    actorUserId: $actorUserId,
                    meta: $meta
                );

                return $wallet;
            });
        } catch (\Exception $e) {
            throw new BusinessException(
                message: 'Erro ao debitar a carteira',
                httpCode: 500,
                context: [
                    'companyId' => $companyId,
                    'amount' => $amount,
                    'reason' => $reason,
                    'meta' => $meta,
                    'actorUserId' => $actorUserId,
                    'originalMessage' => $e->getMessage(),
                ],
                shouldReport: true,
                previous: $e
            );
        }         
    }

    /**
     * Crédito direto por companyId (usado no retorno do checkout, por exemplo).
     * Mantive transação e padronizei para argumentos nomeados.
     */
    public function creditByCompanyId(
        int $companyId,
        int $credits,
        string $reason = 'purchase',
        array $meta = [],
        ?int $actorUserId = null
    ): void {
        try {
            DB::transaction(function () use ($companyId, $credits, $reason, $meta, $actorUserId) {
                $wallet = $this->repository->getByCompanyIdForUpdate($companyId);
                $this->repository->incrementBalance($wallet, $credits);

                $this->repository->createTransaction(
                    wallet: $wallet,
                    type: 'credit',
                    amount: $credits,
                    reason: $reason,
                    actorUserId: $actorUserId,
                    meta: $meta
                );
            });
        } catch (\Exception $e) {
            throw new BusinessException(
                message: 'Erro ao creditar a carteira por companyId',
                httpCode: 500,
                context: [
                    'companyId' => $companyId,
                    'credits' => $credits,
                    'reason' => $reason,
                    'meta' => $meta,
                    'actorUserId' => $actorUserId,
                    'originalMessage' => $e->getMessage(),
                ],
                shouldReport: true,
                previous: $e
            );
        }
    }

    private function validateAmount(int $amount): void
    {
        if ($amount <= 0) {
            throw new ValidationException('Quantidade deve ser maior que zero.', [
                'amount' => $amount,
            ]);
        }
    }

}