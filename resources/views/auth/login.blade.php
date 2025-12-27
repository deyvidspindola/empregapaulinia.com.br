<x-guest-layout>
    <div class="form-inner">
        @include('auth.inc.form-login')
        <div class="bottom-box">
            <div class="text">
                Não tem conta?
                <a href="{{ route('register') }}">Se cadastre aqui</a>
            </div>
        </div>
    </div> 
</x-guest-layout>