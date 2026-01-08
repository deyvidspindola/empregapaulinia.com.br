@php
    $actions = [
        [
            'type' => 'edit',
            'route' => route('admin.menus.edit', ['menu' => $item['id']]),
        ],
    ];
@endphp
<tr>
    <td>{{ $item->label }}</a></td>
    <td>{{ $item->role }}</td>
    <td>
        <label class="switch">
            <input
                type="checkbox"
                name="active"
                data-id="{{ $item->id }}"
                id="switch-{{ $item->id }}"
                value="1"
                class="change-status-menu"
                @checked($item->active)
            >
            <span class="slider round"></span>
        </label>
    </td>
    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>
    <td>
        <x-ui.actions-buttons :actions="$actions" />
    </td>    
</tr>

@push('scripts')
<script>

    $(function(){
        $('.change-status-menu').on('change', function(){
            var menuId = $(this).data('id');
            var isActive = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '/admin/menus/' + menuId,
                type: 'PUT',
                data: {
                    active: isActive,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Menu status updated successfully.');
                },
                error: function(xhr) {
                    console.error('Error updating menu status.');
                }
            });
        });
    });

</script>
@endpush