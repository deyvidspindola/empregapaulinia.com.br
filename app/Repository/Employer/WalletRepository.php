<?php

namespace App\Repository\Employer;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Exceptions\ValidationException;

class WalletRepository
{
    
    public function __construct(
        private Wallet $model
    ) {}


    /**
     * Retorna a carteira (lock for update); cria se não existir.
     * Importante: chame dentro de uma DB::transaction().
     */
    public function getByCompanyIdForUpdate(int $companyId): Wallet
    {
        $wallet = $this->model->where('company_id', $companyId)->lockForUpdate()->first();

        if (!$wallet) {
            // cria sob a transação corrente
            $wallet = $this->model->create([
                'company_id' => $companyId,
                'balance'    => 0,
            ]);

            // reforça lock na mesma transação
            $wallet->refresh();
            $wallet = $this->model->whereKey($wallet->id)->lockForUpdate()->firstOrFail();
        }

        return $wallet;
    }

    /**
     * Retorna a carteira (cria se não existir), sem lock.
     */
    public function getOrCreateByCompanyId(int $companyId): Wallet
    {
        return Wallet::firstOrCreate(
            ['company_id' => $companyId],
            ['balance' => 0]
        );
    }

    /**
     * Incrementa saldo e persiste.
     */
    public function incrementBalance(Wallet $wallet, int $amount): Wallet
    {
        $wallet->balance += $amount;
        $wallet->save();

        return $wallet;
    }

    /**
     * Decrementa saldo e persiste (não valida negativo aqui).
     * Validação de saldo deve ocorrer no Service.
     */
    public function decrementBalance(Wallet $wallet, int $amount): Wallet
    {
        $wallet->balance -= $amount;
        $wallet->save();

        return $wallet;
    }
    
    /**
     * Cria transação no extrato e guarda snapshot do saldo após.
     *
     * @param 'credit'|'debit' $type
     */
    public function createTransaction(
        Wallet $wallet,
        string $type,
        int $amount,
        ?string $reason = null,
        ?int $actorUserId = null,
        array $meta = []
    ): WalletTransaction {
        if ($type !== 'credit' && $type !== 'debit') {
            throw new ValidationException('Tipo de transação inválido.');
        }
        if ($amount <= 0) {
            throw new ValidationException('Quantidade deve ser > 0.');
        }

        return WalletTransaction::create([
            'wallet_id'      => $wallet->id,
            'type'           => $type,
            'amount'         => $amount,
            'reason'         => $reason,
            'actor_user_id'  => $actorUserId,
            'meta'           => $meta,
            'balance_after'  => $wallet->balance,
        ]);
    }
    
}
