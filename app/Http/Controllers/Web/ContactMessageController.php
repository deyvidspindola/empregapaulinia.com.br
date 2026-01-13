<?php

namespace App\Http\Controllers\Web;

use App\Mail\SendMail;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ], [
            'g-recaptcha-response.required' => 'Por favor, verifique o reCAPTCHA.',
        ]);

        try {
            $this->beginTransaction();
            $message = ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            SendMail::to('contato@empregapaulinia.com.br')
                ->view('emails.contact-notification', ['messageData' => $message])
                ->configure(function ($m) use ($message) {
                    $m->subject('Nova mensagem de contato: ' . $message->subject);
                })
                ->send();
            $this->commitTransaction();
        } catch (\Throwable $e) {
            $this->rollbackTransaction();
            $this->logException($e);
            return back()->with('error', 'Houve um erro ao enviar sua mensagem. Por favor, tente novamente mais tarde.');
        }

        return back()->with('success', 'Sua mensagem foi enviada com sucesso!');
    }
}
