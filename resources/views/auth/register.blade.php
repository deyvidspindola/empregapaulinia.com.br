<x-guest-layout>
    <div class="form-inner">
        @include('auth.inc.form-register')
        <div class="bottom-box">
            <div class="text">
                Já tem uma conta?
                <a href="{{ route('login') }}">Faça login aqui</a>
            </div>
        </div>
    </div> 
</x-guest-layout>
