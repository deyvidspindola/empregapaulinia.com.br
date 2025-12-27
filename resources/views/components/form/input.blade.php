@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'type' => 'text',
    'required' => false,
    'cols' => '',
])

<div class="form-group {{ $cols ?? '' }}" id="{{ $name }}-group">
    @if($label)
        <label for="{{ $name }}">{{ $label }} @if($required)*@endif</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
        {{ $required ? 'required' : '' }}
        data-parsley-required="{{ $required ? 'true' : 'false' }}"
        {{ $attributes }}
    >

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
