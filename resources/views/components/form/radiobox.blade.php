@props([
    'label'    => '',
    'name'     => '',
    'options'  => [],
    'checked'  => '',
    'required' => false,
    'inline'   => false,
    'cols'     => '',
])
<div class="form-group {{ $cols ?? '' }}">
    @if($label)
        <label>{{ $label }} @if($required)*@endif</label>
    @endif
    <div class="radio-outer" style="margin-top: 15px;">
        <div class="{{ $inline ? 'd-flex gap-3 flex-wrap' : '' }}">
            @foreach ($options as $key => $opt)
                <div class="radio-box {{ $inline ? 'form-check-inline' : '' }}" {{ $attributes }}>
                    <input
                        type="radio"
                        name="{{ $name }}"
                        id="radio-{{ $name }}-{{ $key }}"
                        value="{{ $key }}"
                        {{ old($name, $checked) == $key ? 'checked' : '' }}
                        data-parsley-required="{{ $required ? 'true' : 'false' }}"
                    >
                    <label for="radio-{{ $name }}-{{ $key }}">
                        {{ $opt }}
                    </label>
                </div>
            @endforeach
        </div>

        @error($name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
