@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => '',
    'required' => false,
])

<div class="form-group chosen-search">
    <label>{{ $label }}</label>

    <select
        name="{{ $name }}"
        class="chosen-search-select form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
        {{ $required ? 'required' : '' }}
        data-parsley-required="{{ $required ? 'true' : 'false' }}"
        {{ $attributes }}
    >
        @foreach ($options as $opt)
            <option value="{{ $opt['value'] }}" {{ old($name, $selected) == $opt['value'] ? 'selected' : '' }}>
                {{ $opt['label'] }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
