@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Selecione...',
    'required' => false,
    'cols' => '',
])

<div class="form-group {{ $cols ?? '' }} ">
    <label for="{{ $name }}">{{ $label }} @if($required)*@endif</label>

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="chosen-select form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
        {{ $required ? 'required' : '' }}
        data-parsley-required="{{ $required ? 'true' : 'false' }}"
        {{ $attributes }}
    >
        <option value="">{{ $placeholder }}</option>

        @foreach ($options as $key => $opt)
            <option 
                value="{{ $key }}"
                {{ old($name, $selected) == $key ? 'selected' : '' }}
            >
                {{ $opt }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
