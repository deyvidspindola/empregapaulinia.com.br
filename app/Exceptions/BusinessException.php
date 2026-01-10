<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Sentry\Laravel\Facade as Sentry;

/**
 * Exception genérica para erros de negócio da aplicação.
 * 
 * O Sentry já captura automaticamente todas as exceptions não tratadas,
 * então não é necessário fazer log manual aqui.
 */
class BusinessException extends Exception
{
    /**
     * Código HTTP do erro
     */
    protected int $httpCode;

    /**
     * Dados adicionais para contexto
     */
    protected array $context;

    /**
     * Se deve ser reportado ao Sentry
     */
    protected bool $shouldReport;

    public function __construct(
        string $message = 'Erro ao processar a solicitação',
        int $httpCode = 400,
        array $context = [],
        bool $shouldReport = true,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->httpCode = $httpCode;
        $this->context = $context;
        $this->shouldReport = $shouldReport;
    }

    /**
     * Retorna o código HTTP
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Retorna o contexto adicional
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Determina se a exception deve ser reportada ao Sentry
     */
    public function report(): bool
    {
        return $this->shouldReport;
    }

    /**
     * Renderiza a exception para resposta HTTP
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        // Se é uma requisição JSON/API
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
                'context' => $this->context,
            ], $this->httpCode);
        }

        Sentry::captureException($this);

        // Para requisições web, redireciona com erro
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['error' => $this->getMessage()]);
    }
}
