@php

    $route = auth()->user() && auth()->user()->is_employer
        ? route('employer.dashboard')
        : route('candidate.dashboard');

    $route = auth()->user() && auth()->user()->is_admin
        ? route('admin.dashboard')
        : $route;

    if(auth()->user() && auth()->user()->company){
        $logo = auth()->user() && auth()->user()->company && auth()->user()->company->logo_path
            ? asset('storage/' . auth()->user()->company->logo_path)
            : asset('images/resource/company-6.png');
    } else {
        $logo = auth()->user() && auth()->user()->is_candidate && auth()->user()->candidate->logo_path
            ? asset('storage/' . auth()->user()->candidate->logo_path)
            : asset('images/resource/company-6.jpg');
    }


@endphp
<div class="outer-box">
    @if(!auth()->user())
    <div class="btn-box">
        <a href="{{ route('login.popup') }}" class="theme-btn btn-style-three call-modal">Login</a>
    </div>
    @else
    <!-- Dashboard Option -->
    <div class="dropdown dashboard-option">
        <a class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
            <img src="{{ $logo }}" alt="avatar" class="thumb">
            <span class="name">Minha Conta</span>
        </a>
        <ul class="dropdown-menu">
            <li class="active">
                <a href="{{ $route }}">
                    <i class="la la-home"></i> Dashboard
                </a>
            </li>
            <li>
                @if(auth()->user()->company)
                <a href="{{ route('employer.profile.index') }}">
                    <i class="la la-user-tie"></i>Dados da Empresa
                </a>
                @elseif(auth()->user()->is_candidate)
                <a href="{{ route('candidate.profile.index') }}">
                    <i class="la la-user"></i>Meus Dados
                </a>
                @endif
            </li>
            <li><x-ui.logout icon="la-sign-out" /></li>
        </ul>
    </div>
    @endif
</div>