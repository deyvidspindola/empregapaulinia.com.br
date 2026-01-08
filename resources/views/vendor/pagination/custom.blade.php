<nav class="ls-pagination margin-paginate">
    <ul>
        @if (!$paginator->onFirstPage())
            <li class="prev">
                <a href="{{ $paginator->previousPageUrl() }}">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <a href="#" class="current-page">{{ $page }}</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="next">
                <a href="{{ $paginator->nextPageUrl() }}">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </li>
        @endif
    </ul>
</nav>