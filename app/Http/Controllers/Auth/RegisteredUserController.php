<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Mail;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Mail\SendMail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:candidate,employer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'role.required' => 'Selecione um tipo de conta.',
            'role.in' => 'Tipo de conta inválido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        try{
            $this->beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            event(new Registered($user));

            Auth::login($user);

            $this->sendEmailNewUser($user);

            $this->commitTransaction();

            if (Auth::user()->is_employer) {
                return redirect()->intended(route('employer.dashboard', absolute: false));
            }

            return redirect()->intended(route('candidate.dashboard', absolute: false));
        } catch (\Throwable $e) {
            $this->rollbackTransaction();
            $this->logException($e);
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao realizar seu cadastro. Por favor, tente novamente.']);
        }
    }

    private function sendEmailNewUser(User $user): void
    {
        try {

            if($user->is_employer) {
                SendMail::to($user->email)
                    ->template(\App\Mail\NewEmployerRegistered::class, [$user])
                    ->send();
                return;
            } else if($user->is_candidate) {
                SendMail::to($user->email)
                    ->template(\App\Mail\NewCandidateRegistered::class, [$user])
                    ->send();
                return;
            }

        } catch (\Exception $e) {
            throw new Exception("Erro ao enviar email de boas vindas para o usuário. Erro: " . $e->getMessage());
        }
    }

}
