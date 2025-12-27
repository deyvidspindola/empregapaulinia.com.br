@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'checked' => [],
    'cols' => '',
])

@php
// Garantir que options seja sempre um array
$options = is_array($options) ? $options : [];
$checked = (array) old($name, $checked);
@endphp


<div class="form-group {{ $cols ?? '' }}">
    <label>{{ $label }}</label>
<div class="switchbox-outer margin-top-10">       
    <ul class="switchbox">
        @foreach ($options as $key => $opt)
            <li>
                <label class="switch">
                    <input
                        type="checkbox"
                        name="{{ $name }}[]"
                        id="switch-{{ $key }}"
                        value="{{ $key }}"
                        @checked(in_array($key, $checked))
                    >
                    <span class="slider round"></span>
                    <span class="title">{{ $opt }}</span>
                </label>
            </li>
        @endforeach
    </ul>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
</div>
