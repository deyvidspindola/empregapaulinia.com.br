<h3>Crie uma conta no Emprega Paulínia</h3>

<!--Login Form-->
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <input type="hidden" name="role" id="user-role" value="candidate" required>
        <div class="btn-box row">
            <div class="col-lg-6 col-md-12">
                <a href="javascript:void(0);" data-role="candidate" class="register-btn theme-btn btn-style-seven"><i class="la la-user"></i> Candidato </a>
            </div>
            <div class="col-lg-6 col-md-12">
                <a href="javascript:void(0);" data-role="employer" class="register-btn theme-btn btn-style-four"><i class="la la-briefcase"></i> Empregador </a>
            </div>
        </div>
    </div>
    <div class="row">
        <x-form.input name="name" label="Nome" type="text" placeholder="Nome" required />
        <x-form.input name="email" label="Email" type="email" placeholder="Email" required />
        <x-form.input name="password" cols="col-md-6" label="Senha" type="password" placeholder="Senha" required />
        <x-form.input name="password_confirmation" cols="col-md-6" label="Confirme a Senha" type="password" placeholder="Confirme a Senha" required />
    </div>
    <div class="form-group">
        <button class="theme-btn btn-style-one " type="submit" name="Register">Cadastrar</button>
    </div>
</form>