@php
    $actions = [
        [
            'type' => 'edit',
            'route' => route('admin.empresas', ['empresa' => 1]),
        ],
        [
            'type' => 'delete',
            'route' => route('admin.empresas', ['empresa' => 1]),
        ],
    ];
@endphp

<tr>
    <td>{{ $item['name'] }}</td>
    <td>{{ $item['email'] }}</td>
    <td>{{ $item['telefone'] }}</td>
</tr>