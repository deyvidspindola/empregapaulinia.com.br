@props([
  'title'    => null,
  'items'    => collect(),
  'rowView'  => null,
  'headers'  => [],
])
<div class="ls-widget">
    <div class="tabs-box">
        <div class="widget-title">
            <h4>{{ $title }}</h4>
            <div class="chosen-outer">
                {{ $toolbar ?? '' }}
            </div>
        </div>        
        <div class="widget-content">
            @if(($items instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && count($items) === 0) || (is_iterable($items) && count($items) === 0))
                <div class="notification notice"><p>Nenhum registro encontrado.</p></div>
            @else
            <div class="table-outer">
                <table class="default-table manage-job-table">
                    <thead>
                        <tr>
                            @foreach ($headers ?? [] as $header)
                            <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            @if($rowView)
                                @include($rowView, ['item' => $item])
                            @else
                            <tr>
                                <td>Defina o atributo rowView no componente.</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                @if($items instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="text-muted" style="margin-top:-25px;">
                    Mostrando
                    <strong>{{ $items->firstItem() }}</strong>–<strong>{{ $items->lastItem() }}</strong>
                    de <strong>{{ $items->total() }}</strong>
                </div>
                <div>{{ $items->links('vendor.pagination.custom') }}</div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>