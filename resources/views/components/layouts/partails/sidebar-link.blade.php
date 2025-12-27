@php
    $segments = explode('.', $route ?? '');
    $activeRoute = implode('.', array_slice($segments, 0, 2)); // só até o segundo ponto
    $isActive = request()->routeIs($activeRoute . '*') ? 'active' : '';
    $href = $route ? route($route) : '#';
@endphp
<li class="{{ $isActive }}">
    <a href="{{ $href }}"> 
        <i class="la {{ $icon }}"></i> 
        {{ $label }}
    </a>
</li>