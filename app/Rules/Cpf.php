<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/\D+/', '', (string) ($value ?? ''));

        // 11 dígitos
        if (strlen($cpf) !== 11) {
            $fail('O :attribute deve conter 11 dígitos.');
            return;
        }

        // Rejeita sequências repetidas (000..., 111..., etc.)
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            $fail('O :attribute informado é inválido.');
            return;
        }

        // Dígitos verificadores (módulo 11)
        $dv1 = $this->calcDV(substr($cpf, 0, 9),  range(10, 2));
        $dv2 = $this->calcDV(substr($cpf, 0, 10), range(11, 2));

        if ((int) $cpf[9] !== $dv1 || (int) $cpf[10] !== $dv2) {
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
