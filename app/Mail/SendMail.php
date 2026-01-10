<?php
namespace App\Mail;

use Exception;
use App\Models\EmailSend;
use Illuminate\Support\Facades\Mail;
use Sentry\Laravel\Facade as Sentry;

class SendMail
{
    public function __construct(
        public string $email,
        public ?string $template = null,
        public array $data = [],
        public ?string $viewName = null,
        public ?\Closure $configureCallback = null
    ) {}

    /**
     * Envia o email
     * 
     * @throws Exception
     */
    public function send(): void
    {
        if (!$this->template && !$this->viewName) {
            throw new Exception('Template ou view de email não foi definido. Use o método template() ou view() antes de enviar.');
        }

        try {
            // Se for usando Mailable (template)
            if ($this->template) {
                Mail::to($this->email)->send(new $this->template(...$this->data));
            } 
            // Se for usando view diretamente
            else if ($this->viewName) {
                Mail::send($this->viewName, $this->data, function ($message) {
                    $message->to($this->email);
                    
                    // Aplica configurações customizadas se existir callback
                    if ($this->configureCallback) {
                        ($this->configureCallback)($message);
                    }
                });
            }
            
            $this->logSendMail(true);
        } catch (Exception $e) {
            Sentry::captureException($e);
            $this->logSendMail(false, $e->getMessage());
            throw $e;
        }
    }

    /**
     * Define o destinatário do email
     */
    public static function to(string $email): self
    {
        return new self($email);
    }

    /**
     * Define o template e os dados do email
     */
    public function template(string $templateClass, array $data = []): self
    {
        $this->template = $templateClass;
        $this->data = $data;
        return $this;
    }

    /**
     * Define a view e os dados do email (estilo clássico)
     */
    public function view(string $viewName, array $data = []): self
    {
        $this->viewName = $viewName;
        $this->data = $data;
        return $this;
    }

    /**
     * Define configurações customizadas para o email (subject, cc, etc)
     */
    public function configure(\Closure $callback): self
    {
        $this->configureCallback = $callback;
        return $this;
    }

    /**
     * Registra log do envio de email
     */
    private function logSendMail($success, $errorMessage = null): void
    {
       $type = 'unknown';
       if ($this->template) {
           $type = class_basename($this->template);
       } else if ($this->viewName) {
           $type = $this->viewName;
       }
       
       EmailSend::create([
           'type' => $type,
           'user_id' => null,
           'meta' => ['email' => $this->email],
           'status' => $success ? 'sent' : 'failed',
           'error_message' => $errorMessage,
           'sent_at' => now(),
       ]);
    }

}