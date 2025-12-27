<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cnpj implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cnpj = preg_replace('/\D+/', '', (string) ($value ?? ''));

        // 14 dígitos
        if (strlen($cnpj) !== 14) {
            $fail('O :attribute deve conter 14 dígitos.');
            return;
        }

        // Rejeita sequências repetidas (000..., 111..., etc.)
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            $fail('O :attribute informado é inválido.');
            return;
        }

        // Calcula dígitos verificadores (módulo 11)
        $dv1 = $this->calcDV(substr($cnpj, 0, 12), [5,4,3,2,9,8,7,6,5,4,3,2]);
        $dv2 = $this->calcDV(substr($cnpj, 0, 13), [6,5,4,3,2,9,8,7,6,5,4,3,2]);

        if ((int) $cnpj[12] !== $dv1 || (int) $cnpj[13] !== $dv2) {
            $fail('O :attribute informado é inválido.');
        }
    }

    private function calcDV(string $base, array $weights): int
    {
        $sum = 0;
        foreach ($weights as $i => $w) {
            $sum += (int) $base[$i] * $w;
        }
        $rest = $sum % 11;
        return $rest < 2 ? 0 : 11 - $rest;
    }
}
