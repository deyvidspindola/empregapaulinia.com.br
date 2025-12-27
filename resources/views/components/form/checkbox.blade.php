@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'checked' => [],
    'square' => false,
    'inline' => false,
    'twoColumn' => false,
])

@php
$checked = (array) old($name, $checked);
@endphp

<div class="checkbox-outer margin-top-10">
    <label>{{ $label }}</label>

    <ul class="checkboxes {{ $square ? 'square' : '' }} {{ $inline ? 'inline' : '' }} {{ $twoColumn ? 'two-column' : '' }}">
        @foreach ($options as $opt)
            <li>
                <input
                    type="checkbox"
                    name="{{ $name }}[]"
                    id="check-{{ $opt['value'] }}"
                    value="{{ $opt['value'] }}"
                    @checked(in_array($opt['value'], $checked))
                    data-parsley-mincheck="1"
                    {{ $attributes }}
                >
                <label for="check-{{ $opt['value'] }}">{{ $opt['label'] }}</label>
            </li>
        @endforeach
    </ul>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
