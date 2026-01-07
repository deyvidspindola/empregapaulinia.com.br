<x-guest-layout>
    <div class="form-inner">
        <h3>Esqueceu sua senha? Sem problema. Basta nos informar seu endereço de email e enviaremos um link para redefinir sua senha.</h3>
        <!--Login Form-->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

    
            <x-form.input 
                name="email" 
                label="Email" 
                type="email" 
                :value="old('email')"
                placeholder="Email" 
                required
                autofocus
            />
            
            <div class="form-group">
                <button class="theme-btn btn-style-one" type="submit" name="log-in">Enviar link para redefinir a senha</button>
            </div>
        </form>
        <div class="bottom-box">
            <div class="text">
                Não tem conta?
                <a href="{{ route('register') }}">Se cadastre aqui</a>
            </div>
        </div>
    </div> 
</x-guest-layout>