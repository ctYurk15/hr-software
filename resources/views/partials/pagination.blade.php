<style>
    ul.paginator {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    ul.paginator li {
        margin: 0 5px;
    }

    ul.paginator li a {
        text-decoration: none;
        color: #007BFF;
        padding: 5px 10px;
        border: 1px solid #007BFF;
        border-radius: 5px;
    }

    ul.paginator li.active span {
        padding: 5px 10px;
        color: white;
        background-color: #007BFF;
        border-radius: 5px;
    }

    ul.paginator li.disabled span {
        color: #ccc;
        cursor: not-allowed;
    }

    ul.paginator li a:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

@if ($paginator->hasPages())
    <ul class="paginator">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>«</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <li class="active"><span>{{ $page }}</span></li>
            @else
                <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">»</a></li>
        @else
            <li class="disabled"><span>»</span></li>
        @endif
    </ul>
@endif

