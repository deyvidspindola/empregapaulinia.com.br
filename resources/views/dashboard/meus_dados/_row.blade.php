@php
    $actions = [
        [
            'type' => 'edit',
            'route' => route('admin.candidatos', ['candidato' => $item['id']]),
        ],
        [
            'type' => 'delete',
            'route' => route('admin.candidatos', ['candidato' => $item['id']]),
        ],
    ];
@endphp

<tr>
    <td>{{ $item['name'] }}</td>
    <td>{{ $item['email'] }}</td>
    <td>{{ $item['telefone'] }}</td>
    <td>
        <x-ui.actions-buttons :actions="$actions" />
    </td>
</tr>