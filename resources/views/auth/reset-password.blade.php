<x-guest-layout>
    <div class="form-inner">
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
    
            <x-form.input name="email" label="Email" type="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-form.input name="password" label="Senha" type="password" placeholder="Senha" required autocomplete="new-password" />
            <x-form.input name="password_confirmation" label="Confirme a Senha" type="password" placeholder="Confirme a Senha" required autocomplete="new-password" />
            
            <div class="form-group">
                <button class="theme-btn btn-style-one" type="submit" name="log-in">Resetar a Senha</button>
            </div>
        </form>
    </div> 
</x-guest-layout>