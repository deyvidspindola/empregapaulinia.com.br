<?php

namespace App\Exceptions;

/**
 * Exception para erros de validação personalizados
 */
class ValidationException extends BusinessException
{
    public function __construct(
        string $message = 'Dados inválidos',
        array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            message: $message,
            httpCode: 422,
            context: $context,
            shouldReport: false, // Erros de validação geralmente não precisam ir pro Sentry
            previous: $previous
        );
    }
}
