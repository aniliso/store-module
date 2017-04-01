@if ($paginator->hasPages())
    <ul class="c-content-pagination c-square c-theme pull-right">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <li class="disabled hide"><span>&laquo;</span></li>
        @else
            <li class="c-prev"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

    <!-- Pagination Elements -->
        @foreach ($elements as $element)
        <!-- "Three Dots" Separator -->
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

        <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="c-active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

    <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <li class="c-next"><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled hide"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
