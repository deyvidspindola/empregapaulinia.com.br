<h3>Login Emprega Paulínia</h3>
<!--Login Form-->
<x-auth-session-status class="mb-4" :status="session('status')" />
<form method="POST" action="{{ route('login') }}">
    @csrf

    <x-form.input name="email" label="Email" type="email" placeholder="Email" required />
    <x-form.input name="password" label="Senha" type="password" placeholder="Senha" required />

    <div class="form-group">
        <div class="field-outer">
            <div class="input-group checkboxes square">
                <input type="checkbox" name="remember" value="" id="remember">
                <label for="remember" class="remember">
                    <span class="custom-checkbox"></span>
                    Lembrar me
                </label>
            </div>
            <a href="#" class="pwd">Esqueceu a senha?</a>
        </div>
    </div>

    <div class="form-group">
        <button class="theme-btn btn-style-one" type="submit" name="log-in">Entrar</button>
    </div>
</form>