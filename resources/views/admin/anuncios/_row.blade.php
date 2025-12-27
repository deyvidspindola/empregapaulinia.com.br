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
    <td><code>{{ $item['key'] }}</code></td>
    <td>{{ $item['name'] }}</td>
    <td><span class="badge badge-success">{{ $item['status'] }}</span></td>
    <td>{{ $item['network'] }}</td>
    <td>{{ $item['creators'] }}</td>
    <td>
        <x-ui.actions-buttons :actions="$actions" />
    </td>
</tr>