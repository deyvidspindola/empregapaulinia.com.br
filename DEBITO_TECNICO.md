# 📋 Débito Técnico e Melhorias - EmpregaPaulínia

**Projeto:** EmpregaPaulínia  
**Framework:** Laravel 12.x  
**PHP:** 8.2+  
**Data:** 09 de Janeiro de 2026

---

## 📊 Resumo Executivo

Este documento lista todos os débitos técnicos e melhorias identificados na análise de conformidade com PSRs e boas práticas de desenvolvimento.

### Métricas de Qualidade Atual

| Aspecto | Conformidade |
|---------|-------------|
| PSR-1 (Basic Coding Standard) | ✅ 95% |
| PSR-4 (Autoloading) | ✅ 100% |
| PSR-12 (Extended Coding Style) | ⚠️ 75% |
| PSR-3 (Logger Interface) | ⚠️ 60% |
| Type Safety | ⚠️ 80% |
| Separation of Concerns | ⚠️ 70% |

---

## 🔴 Prioridade Alta (Crítico)

### 1. Padronizar Espaçamento em Try-Catch

**PSR:** PSR-12  
**Tipo:** Débito Técnico  
**Impacto:** Conformidade, Legibilidade

**Arquivos Afetados:**
- `app/Http/Controllers/Employer/VagasController.php` (linhas 92, 111)
- `app/Http/Controllers/Auth/RegisteredUserController.php` (linha 35)

**Problema:**
```php
// ❌ Incorreto
try{
    $this->beginTransaction();
}
```

**Solução:**
```php
// ✅ Correto
try {
    $this->beginTransaction();
}
```

**Ação:** Adicionar espaço entre `try` e `{` em todos os blocos try-catch.

---

### 2. Remover Try-Catch Redundante em Controllers

**Padrão:** SOLID (Single Responsibility Principle)  
**Tipo:** Débito Técnico  
**Impacto:** Manutenibilidade, DRY (Don't Repeat Yourself)

**Arquivo:** `app/Http/Controllers/Web/VagasController.php` (linhas 43-56)

**Problema:**
```php
public function apply(JobPosting $job, Request $request)
{
    try {
        $applicationResult = $this->webVagasService->applyToJob($job, $request);
        
        if ($applicationResult['success']) {
            return redirect()->back()->with('success', '...');
        } else {
            return redirect()->back()->with('error', $applicationResult['message']);
        }
    } catch (\Throwable $e) {
        // O service já trata exceções e retorna array com status
        // Este try-catch é redundante
    }
}
```

**Solução:**
```php
public function apply(JobPosting $job, Request $request): RedirectResponse
{
    $result = $this->webVagasService->applyToJob($job, $request);
    
    if ($result['success']) {
        return redirect()->back()
            ->with('success', 'Candidatura realizada com sucesso!');
    }
    
    return redirect()->back()
        ->with('error', $result['message']);
}
```

**Ação:** Remover try-catch deste método específico pois o service já trata as exceções.

---

### 3. Remover Lógica Complexa de Model Mutators

**Padrão:** SOLID (Single Responsibility Principle)  
**Tipo:** Débito Técnico  
**Impacto:** Testabilidade, Clareza, Manutenibilidade

**Arquivo:** `app/Models/JobPosting.php` (linhas 130-140, 272+)

**Problema:**
```php
protected function deadline(): Attribute
{
    return Attribute::make(
        set: function ($value) {
            // ... lógica complexa ...
            try {
                return \Carbon\Carbon::parse($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null; // Esconde erros silenciosamente
            }
        }
    );
}
```

**Problemas Identificados:**
- Mutators não devem conter lógica de negócio complexa
- Try-catch em mutator esconde erros de dados inválidos
- Retornar `null` silenciosamente dificulta debugging
- Viola SRP (Single Responsibility Principle)

**Solução:**
```php
// No Form Request (VagasRequest.php)
public function rules(): array
{
    return [
        'deadline' => ['nullable', 'date', 'date_format:Y-m-d'],
        // ...
    ];
}

protected function prepareForValidation(): void
{
    if ($this->deadline && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $this->deadline)) {
        $this->merge([
            'deadline' => Carbon::createFromFormat('d/m/Y', $this->deadline)
                              ->format('Y-m-d')
        ]);
    }
}

// No Model (simplificado)
protected function deadline(): Attribute
{
    return Attribute::make(
        get: fn($value) => $value ? Carbon::parse($value)->format('d/m/Y') : null,
        set: fn($value) => $value,
    );
}
```

**Ação:** Mover validação e transformação para Form Request, simplificar mutator.

---

### 4. Separar Transações do Controller para Service

**Padrão:** SOLID (Single Responsibility Principle)  
**Tipo:** Débito Técnico  
**Impacto:** Reusabilidade, Testabilidade, Manutenibilidade

**Arquivos Afetados:**
- `app/Http/Controllers/Employer/VagasController.php`
- `app/Http/Controllers/Employer/ProfileController.php`
- `app/Http/Controllers/Auth/RegisteredUserController.php`
- `app/Http/Controllers/Web/ContactMessageController.php`

**Problema:**
```php
// Controller com lógica de negócio e transações
public function store(VagasRequest $request) 
{
    try {
        $this->beginTransaction();
        $user = auth()->user();
        $this->jobPosting->create([
            ...$request->validated(),
            'user_id' => $user->id,
            'company_id' => $user->company?->id,
            'slug' => \Str::slug($request->validated('title')),
        ]);
        $this->commitTransaction();
        
        return redirect()->route('employer.vagas.index')
            ->with('success', 'Vaga criada com sucesso!');
    } catch (\Throwable $e) {
        $this->rollbackTransaction();
        $this->logException($e);
        return back()->with('error', 'Houve um erro...');
    }
}
```

**Solução:**

**1. Criar Service dedicado:**
```php
// app/Services/JobPosting/JobPostingService.php
namespace App\Services\JobPosting;

use App\Models\JobPosting;
use App\Exceptions\JobPostingException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobPostingService
{
    public function __construct(
        private JobPosting $jobPosting
    ) {}

    public function create(array $data): JobPosting
    {
        try {
            DB::beginTransaction();
            
            $job = $this->jobPosting->create([
                ...$data,
                'user_id' => auth()->id(),
                'company_id' => auth()->user()->company?->id,
                'slug' => \Str::slug($data['title']),
            ]);
            
            DB::commit();
            
            Log::info('Job posting created', [
                'job_id' => $job->id,
                'user_id' => auth()->id(),
            ]);
            
            return $job;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create job posting', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            
            throw JobPostingException::creationFailed();
        }
    }
}
```

**2. Simplificar Controller:**
```php
// app/Http/Controllers/Employer/VagasController.php
public function __construct(
    private JobPostingService $jobPostingService
) {}

public function store(VagasRequest $request): RedirectResponse
{
    $job = $this->jobPostingService->create($request->validated());
    
    return redirect()
        ->route('employer.vagas.index')
        ->with('success', 'Vaga criada com sucesso!');
}
```

**Ação:** Criar services dedicados e mover toda lógica de negócio e transações para lá.

---

### 5. Substituir Captura de \Throwable por Exceções Específicas

**Padrão:** Best Practice, Fail Fast  
**Tipo:** Débito Técnico  
**Impacto:** Debugging, Confiabilidade

**Arquivos Afetados:**
- `app/Http/Controllers/Auth/RegisteredUserController.php` (linha 67)
- `app/Http/Controllers/Employer/VagasController.php` (linhas 67, 100, 118)
- `app/Http/Controllers/Employer/ProfileController.php` (linhas 51, 84)
- `app/Http/Controllers/Web/ContactMessageController.php` (linha 43)

**Problema:**
```php
} catch (\Throwable $e) {
    // Captura TUDO, incluindo erros fatais do PHP
    // ParseError, TypeError, etc. não deveriam ser capturados
}
```

**Problemas:**
- Mascara erros críticos que deveriam ser propagados
- Dificulta debugging
- Pode esconder bugs sérios
- Viola princípio "fail fast"

**Solução:**
```php
use Illuminate\Database\QueryException;
use App\Exceptions\JobPostingException;

try {
    // operação...
} catch (QueryException $e) {
    // Trata erros de banco específicos
    DB::rollBack();
    Log::error('Database error', ['exception' => $e]);
    throw new JobPostingException('Erro ao salvar no banco');
    
} catch (ValidationException $e) {
    // Trata erros de validação
    throw $e;
    
} catch (\Exception $e) {
    // Apenas Exception, não Throwable
    DB::rollBack();
    Log::error('Unexpected error', ['exception' => $e]);
    throw $e;
}
```

**Ação:** Substituir `\Throwable` por exceções específicas ou no máximo `\Exception`.

---

## 🟡 Prioridade Média (Importante)

### 6. Criar Exceções Personalizadas por Domínio

**Padrão:** PSR-0/4, Domain-Driven Design  
**Tipo:** Melhoria  
**Impacto:** UX, Debugging, Manutenibilidade

**Problema Atual:**
```php
return back()->with('error', 'Houve um erro ao criar a vaga. Por favor, tente novamente mais tarde.');
```

Mensagens genéricas não ajudam o usuário nem o suporte.

**Solução:**

**Estrutura de diretórios:**
```
app/Exceptions/
├── Handler.php (já existe)
├── JobPosting/
│   └── JobPostingException.php
├── Company/
│   └── CompanyException.php
├── Candidate/
│   └── CandidateException.php
└── Application/
    └── ApplicationException.php
```

**Exemplo de implementação:**
```php
// app/Exceptions/JobPosting/JobPostingException.php
namespace App\Exceptions\JobPosting;

use Exception;

class JobPostingException extends Exception
{
    public static function duplicateSlug(): self
    {
        return new self('Já existe uma vaga com este título.');
    }
    
    public static function invalidDeadline(): self
    {
        return new self('A data de expiração deve ser futura.');
    }
    
    public static function companyNotFound(): self
    {
        return new self('Complete o cadastro da empresa antes de criar vagas.');
    }
    
    public static function unauthorized(): self
    {
        return new self('Você não tem permissão para gerenciar esta vaga.');
    }
    
    public static function notFound(): self
    {
        return new self('Vaga não encontrada.');
    }
    
    public static function alreadyPublished(): self
    {
        return new self('Esta vaga já está publicada.');
    }
    
    public static function creationFailed(): self
    {
        return new self('Não foi possível criar a vaga. Tente novamente.');
    }
}
```

**Ação:** Criar exceções personalizadas para cada domínio com mensagens específicas.

---

### 7. Implementar Handler Global de Exceções

**Padrão:** Centralização, DRY  
**Tipo:** Melhoria  
**Impacto:** Consistência, Manutenibilidade

**Solução:**
```php
// app/Exceptions/Handler.php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\JobPosting\JobPostingException;
use App\Exceptions\Company\CompanyException;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        // Exceções de Job Posting
        $this->renderable(function (JobPostingException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 422);
            }
            
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        });
        
        // Exceções de Company
        $this->renderable(function (CompanyException $e, $request) {
            return redirect()
                ->route('employer.profile.index')
                ->with('error', $e->getMessage());
        });
    }
}
```

**Ação:** Configurar handlers globais para cada tipo de exceção personalizada.

---

### 8. Melhorar Logging com Contexto (PSR-3)

**PSR:** PSR-3 (Logger Interface)  
**Tipo:** Débito Técnico  
**Impacto:** Observabilidade, Suporte, Debugging

**Arquivo:** `app/Http/Controllers/Controller.php` (linhas 24-27)

**Problema Atual:**
```php
protected function logException(\Throwable $e)
{
    Sentry::captureException($e);
    // Não inclui contexto: usuário, operação, dados relevantes
}
```

**Solução:**
```php
protected function logException(\Throwable $e, array $context = []): void
{
    $defaultContext = [
        'user_id' => auth()->id(),
        'company_id' => auth()->user()?->company?->id,
        'url' => request()->fullUrl(),
        'method' => request()->method(),
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ];
    
    $fullContext = array_merge($defaultContext, $context);
    
    Log::error($e->getMessage(), array_merge($fullContext, [
        'exception' => get_class($e),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ]));
    
    Sentry::captureException($e);
}
```

**Uso:**
```php
} catch (QueryException $e) {
    $this->logException($e, [
        'operation' => 'create_job_posting',
        'job_title' => $data['title'] ?? null,
        'category_id' => $data['category_id'] ?? null,
    ]);
}
```

**Ação:** Melhorar método logException() para incluir contexto rico.

---

### 9. Adicionar Type Hints em Propriedades

**Padrão:** PSR-12, PHP 7.4+ Type Properties  
**Tipo:** Débito Técnico  
**Impacto:** Type Safety, IDE Support

**Arquivos Afetados:**
- `app/Services/HomeService.php` (linha 8)
- `app/Services/Employer/DashboardService.php` (linhas 8-10)

**Problema:**
```php
// app/Services/HomeService.php
private $data = [];

// app/Services/Employer/DashboardService.php
private $company;
private $user;
private $dashboard = [];
```

**Solução:**
```php
// app/Services/HomeService.php
private array $data = [];

// app/Services/Employer/DashboardService.php
private ?Company $company;
private User $user;
private array $dashboard = [];
```

**Ação:** Adicionar type hints em todas as propriedades de classes.

---

### 10. Refatorar SendMail para Seguir Padrões

**Tipo:** Melhoria  
**Impacto:** Clareza, Testabilidade

**Arquivo:** `app/Mail/SendMail.php`

**Problema:**
```php
try {
    // Lógica de envio
} catch (Exception $e) {
    Sentry::captureException($e);
    $this->logSendMail(false, $e->getMessage());
    throw $e; // Re-propaga após capturar
}
```

**Observação:** Try-catch que apenas loga e re-propaga pode ser simplificado.

**Solução:**
```php
// Remover try-catch, deixar exceção propagar naturalmente
// Log será feito pelo handler global
public function send(): void
{
    if (!$this->template && !$this->viewName) {
        throw new \InvalidArgumentException(
            'Template ou view de email não foi definido.'
        );
    }
    
    if ($this->template) {
        Mail::to($this->email)->send(new $this->template(...$this->data));
    } else {
        Mail::send($this->viewName, $this->data, function ($message) {
            $message->to($this->email);
            if ($this->configureCallback) {
                ($this->configureCallback)($message);
            }
        });
    }
    
    $this->logSendMail(true);
}
```

**Ação:** Simplificar método send(), deixar exceções propagarem naturalmente.

---

## 🟢 Prioridade Baixa (Desejável)

### 11. Organizar Imports Alfabeticamente (PSR-12)

**PSR:** PSR-12  
**Tipo:** Débito Técnico  
**Impacto:** Legibilidade

**Exemplo:** `app/Http/Controllers/Auth/RegisteredUserController.php`

**Problema:**
```php
use Exception;
use Mail;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
```

**Solução:**
```php
use Exception;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\User;
```

**PSR-12 Recomenda:**
- Agrupar por namespace raiz
- Separar grupos com linha em branco
- Ordenar alfabeticamente dentro de cada grupo

**Ação:** Usar Laravel Pint para organizar automaticamente.

---

### 12. Padronizar Espaçamento em Arrays

**PSR:** PSR-12  
**Tipo:** Débito Técnico  
**Impacto:** Legibilidade

**Problema:**
```php
compact('categories','jobTypes','formConfig') // ❌ Sem espaço após vírgula
```

**Solução:**
```php
compact('categories', 'jobTypes', 'formConfig') // ✅ Com espaço
```

**Ação:** Usar Laravel Pint para corrigir automaticamente.

---

### 13. Configurar Laravel Pint

**Tipo:** Melhoria  
**Impacto:** Automação, Consistência

**Ação:**

1. **Criar arquivo de configuração** `pint.json`:
```json
{
    "preset": "laravel",
    "rules": {
        "blank_line_before_statement": true,
        "ordered_imports": {
            "sort_algorithm": "alpha"
        },
        "no_unused_imports": true,
        "single_quote": true,
        "concat_space": {
            "spacing": "one"
        }
    }
}
```

2. **Adicionar scripts no composer.json**:
```json
{
    "scripts": {
        "format": "./vendor/bin/pint",
        "format:test": "./vendor/bin/pint --test"
    }
}
```

3. **Executar:**
```bash
composer format
```

---

### 14. Criar Estrutura de Services Organizada

**Tipo:** Melhoria  
**Impacto:** Organização, Escalabilidade

**Estrutura Proposta:**
```
app/Services/
├── JobPosting/
│   ├── JobPostingService.php
│   ├── JobPostingSearchService.php
│   └── JobApplicationService.php
├── Company/
│   ├── CompanyService.php
│   └── CompanyProfileService.php
├── Candidate/
│   ├── CandidateService.php
│   └── CandidateProfileService.php
├── Email/
│   ├── EmailService.php
│   └── EmailTemplateService.php
└── Dashboard/
    ├── EmployerDashboardService.php
    └── CandidateDashboardService.php
```

**Ação:** Reorganizar services existentes e criar novos conforme necessário.

---

## 📝 Checklist de Implementação

### Fase 1 - Correções Críticas (Sprint 1)

- [ ] Corrigir espaçamento em todos os try-catch (`try {` com espaço)
- [ ] Criar estrutura de exceções personalizadas
  - [ ] `JobPostingException.php`
  - [ ] `CompanyException.php`
  - [ ] `CandidateException.php`
  - [ ] `ApplicationException.php`
- [ ] Criar `JobPostingService` com métodos CRUD
- [ ] Refatorar `VagasController` para usar service
- [ ] Simplificar mutators em `JobPosting` model
- [ ] Mover validação de datas para Form Requests
- [ ] Remover try-catch redundante em `VagasController::apply()`

### Fase 2 - Melhorias de Qualidade (Sprint 2)

- [ ] Implementar handlers globais em `Handler.php`
- [ ] Melhorar método `logException()` com contexto
- [ ] Substituir `\Throwable` por exceções específicas em todos os controllers
- [ ] Adicionar type hints em propriedades de services
- [ ] Criar `CompanyService` e refatorar `ProfileController`
- [ ] Criar testes unitários para services
- [ ] Documentar padrões de exceções no README

### Fase 3 - Padronização (Sprint 3)

- [ ] Configurar `pint.json` com regras do projeto
- [ ] Executar `./vendor/bin/pint` em todo o projeto
- [ ] Reorganizar estrutura de services
- [ ] Adicionar pre-commit hooks (opcional)
- [ ] Documentar padrões de código no README
- [ ] Code review completo

---

## ✅ Pontos Positivos Já Implementados

### Arquitetura
- ✅ **Dependency Injection** - Controllers usam injeção de dependências corretamente
- ✅ **Service Layer** - Existe separação entre Controllers e Services
- ✅ **Middleware** - Uso adequado de middlewares customizados
- ✅ **PSR-4 Autoloading** - Estrutura de diretórios segue PSR-4

### Validação e Segurança
- ✅ **Form Requests** - Validações em classes dedicadas
- ✅ **Custom Rules** - Regras personalizadas (CPF, CNPJ)
- ✅ **CSRF Protection** - Proteção habilitada
- ✅ **Mass Assignment Protection** - `$fillable` configurado nos models

### Qualidade de Código
- ✅ **Type Hints** - Métodos públicos com type hints
- ✅ **Return Types** - Tipos de retorno declarados
- ✅ **Eloquent Relationships** - Relacionamentos bem definidos
- ✅ **Database Transactions** - Uso de transações em operações críticas

### Monitoramento e Logs
- ✅ **Sentry Integration** - Monitoramento de erros implementado
- ✅ **Environment Configuration** - Uso de variáveis de ambiente
- ✅ **Laravel Logging** - Sistema de logs configurado

---

## 📊 Estimativa de Esforço

| Fase | Complexidade | Tempo Estimado | Risco |
|------|--------------|----------------|-------|
| Fase 1 (Crítico) | Alta | 2-3 dias | Médio |
| Fase 2 (Importante) | Média | 2-3 dias | Baixo |
| Fase 3 (Desejável) | Baixa | 1 dia | Muito Baixo |
| **Total** | - | **5-7 dias** | - |

---

## 🎯 Benefícios Esperados

### Técnicos
- ✅ Código mais testável e manutenível
- ✅ Melhor rastreabilidade de erros
- ✅ Conformidade com PSRs
- ✅ Redução de bugs em produção

### Negócio
- ✅ Mensagens de erro mais claras para usuários
- ✅ Suporte mais eficiente (logs contextuais)
- ✅ Menor tempo de debugging
- ✅ Facilita onboarding de novos desenvolvedores

---

## 📚 Referências

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [PSR-3: Logger Interface](https://www.php-fig.org/psr/psr-3/)
- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)
- [PSR-12: Extended Coding Style Guide](https://www.php-fig.org/psr/psr-12/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)

---

**Última atualização:** 09/01/2026  
**Responsável:** Equipe de Desenvolvimento
