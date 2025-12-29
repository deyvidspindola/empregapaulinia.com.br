<?php

namespace App\Http\Controllers\Auth;

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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->sendEmailNewUser($user);

        if (Auth::user()->is_employer) {
            return redirect()->intended(route('employer.dashboard', absolute: false));
        }

        return redirect()->intended(route('candidate.dashboard', absolute: false));
    }

    private function sendEmailNewUser(User $user): void
    {
        try {

            if($user->is_employer) {
                Mail::to($user->email)->send(new \App\Mail\NewEmployerRegistered($user));
                return;
            } else if($user->is_candidate) {
                Mail::to($user->email)->send(new \App\Mail\NewCandidateRegistered($user));
                return;
            }

        } catch (\Exception $e) {
            logger()->error('Erro ao enviar email de novo usuário registrado: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);            
        }
    }

}
