@php
    $user = auth()->user();
    
    if ($user) {
        $route = $user->is_admin 
            ? route('admin.dashboard')
            : ($user->is_employer ? route('employer.dashboard') : route('candidate.dashboard'));

        if ($user->company && $user->company->logo_path) {
            $logo = asset('storage/' . $user->company->logo_path);
        } elseif ($user->is_candidate && $user->candidate && $user->candidate->logo_path) {
            $logo = asset('storage/' . $user->candidate->logo_path);
        } else {
            $logo = $user->is_employer 
                ? asset('images/resource/company-6.png')
                : asset('images/resource/company-6.jpg');
        }
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