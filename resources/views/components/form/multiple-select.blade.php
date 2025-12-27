@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => [],
    'placeholder' => 'Selecione...',
    'required' => false,
])

@php
$selected = is_array(old($name, $selected)) ? old($name, $selected) : [];
@endphp

<div class="form-group">
    <label>{{ $label }} @if($required)*@endif</label>

    <select
        name="{{ $name }}[]"
        class="chosen-select form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
        multiple
        data-placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        data-parsley-mincheck="{{ $required ? 1 : 0 }}"
        {{ $attributes }}
    >
        @foreach ($options as $opt)
            <option 
                value="{{ $opt['value'] }}"
                {{ in_array($opt['value'], $selected) ? 'selected' : '' }}
            >
                {{ $opt['label'] }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
