<?php

namespace App\Exceptions;

/**
 * Exception para erros de autorização
 */
class UnauthorizedException extends BusinessException
{
    public function __construct(
        string $message = 'Você não tem permissão para realizar esta ação',
        array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            message: $message,
            httpCode: 403,
            context: $context,
            shouldReport: false, // Erros de autorização geralmente não precisam ir pro Sentry
            previous: $previous
        );
    }
}
