@props([
    'type' => 'link',
    'style' => 'one',
    'label' => 'Salvar',
    'route' => '#',
])

@php
    $buttonClass = 'theme-btn btn-style-' . $style;
@endphp

@if($type === 'link')
    <a href="{{ $route }}" class="{{ $buttonClass }}">
        {{ $label }}
    </a>   
@else
    <button type="{{ $type }}" class="{{ $buttonClass }}">
        {{ $label }}
    </button> 
@endif

