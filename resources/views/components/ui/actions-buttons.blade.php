@props([
  'actions' => []
])
<div class="option-box">
    <ul class="option-list">
        @foreach ($actions as $action)
        
            @if ($action['type'] == 'show')
            <li><a href="{{ $action['route'] }}"><span class="la la-eye"></span></a></li>
            @endif

            @if ($action['type'] == 'edit')
            <li><a href="{{ $action['route'] }}"><span class="la la-pencil"></span></a></li>
            @endif

            @if ($action['type'] == 'delete')
            <li>
                <x-ui.delete-button :action="$action['route']" />
            </li>
            @endif

        @endforeach
    </ul>
</div>