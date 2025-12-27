@props([
    'action'     => '#',
    'method'     => 'POST', // POST | PUT
    'buttonText' => 'Salvar Alterações',
])

<form
    class="default-form"
    action="{{ $action }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    @if (strtoupper($method) === 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        {{ $slot }}

        <div class="form-group col-lg-6 col-md-12">
            <x-ui.button
                type="submit"
                :label="$buttonText"
            />
        </div>
    </div>
</form>
