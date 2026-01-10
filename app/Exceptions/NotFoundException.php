<?php

namespace App\Exceptions;

/**
 * Exception para recursos não encontrados
 */
class NotFoundException extends BusinessException
{
    public function __construct(
        string $message = 'Recurso não encontrado',
        array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            message: $message,
            httpCode: 404,
            context: $context,
            shouldReport: false, // 404 geralmente não precisa ir pro Sentry
            previous: $previous
        );
    }
}
