@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Por favor, corrija os erros abaixo:</strong>
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
