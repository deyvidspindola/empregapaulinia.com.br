<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');
        
        if (empty($secretKey)) {
            $fail('A chave secreta do reCAPTCHA não está configurada.');
            return;
        }

        if (empty($value)) {
            $fail('Por favor, complete a verificação do reCAPTCHA.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!isset($result['success']) || $result['success'] !== true) {
                $fail('Falha na verificação do reCAPTCHA. Por favor, tente novamente.');
            }
        } catch (\Exception $e) {
            $fail('Erro ao verificar o reCAPTCHA. Por favor, tente novamente.');
        }
    }
}
