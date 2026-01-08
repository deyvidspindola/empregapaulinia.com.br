<x-admin-layout>

    <form method="POST" action="{{ route('password.store') }}">
        <x-ui.card title="Alterar Minha Senha">         
            <div class="row">
                <x-form.input value="" cols="col-md-6" name="password" label="Senha" type="text" placeholder="Senha" required autocomplete="new-password" />
                <x-form.input value="" cols="col-md-6" name="password_confirmation" label="Confirme a Senha" type="text" placeholder="Confirme a Senha" required autocomplete="new-password" />                
            </div>
            <br>
        </x-ui.card>
        <div class="form-group">
            <button class="theme-btn btn-style-one" type="submit" name="log-in">Resetar a Senha</button>
        </div>
    </form>
</x-admin-layout>