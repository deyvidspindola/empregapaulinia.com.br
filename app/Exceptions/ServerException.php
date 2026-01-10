<?php

namespace App\Exceptions;

/**
 * Exception para erros internos do servidor
 */
class ServerException extends BusinessException
{
    public function __construct(
        string $message = 'Erro interno do servidor',
        array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            message: $message,
            httpCode: 500,
            context: $context,
            shouldReport: true, // Erros de servidor DEVEM ir pro Sentry
            previous: $previous
        );
    }
}
