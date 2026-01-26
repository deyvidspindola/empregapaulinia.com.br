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

@once
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(document).ready(function(){
            @if($attributes->has('data-masktype') && $attributes->get('data-masktype') == 'money')
                $("#{{ $name }}").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
            @elseif($attributes->has('data-mask'))
                $('#{{ $name }}').mask('{{ $attributes->get('data-mask') }}');
            @endif
        });
    </script>
@endpush