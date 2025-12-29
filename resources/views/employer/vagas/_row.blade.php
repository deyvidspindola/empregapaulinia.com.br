@php
    $actions = [
        [
            'type' => 'edit',
            'route' => route('employer.vagas.edit', ['vaga' => $item['id']]),
        ],
        [
            'type' => 'delete',
            'route' => route('employer.vagas.destroy', ['vaga' => $item['id']]),
        ],
    ];
@endphp

<tr>
    <td>{{ $item->title }}</td>
    <td>{{ $item->statusLabel }}</td>
    <td>{{ $item->postedOnLabel }}</td>
    <td>{{ $item->updatedOnLabel }}</td>
    <td>{{ $item->deadlineLabel }}</td>
    <td>
        <x-ui.actions-buttons :actions="$actions" />
    </td>
</tr>