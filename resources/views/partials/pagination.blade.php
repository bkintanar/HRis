<div style="width:100%">
    <div style="width:50%; float:left;">
        @if ($currentPage > 1)
            <a href="{{ $firstPageUrl }}"> < first </a>
            <a href="{{ $prevPageUrl }}"> < prev </a>
        @endif
        {{ $currentPage }}
        @if ($hasMorePages)
            <a href="{{ $nextPageUrl }}"> next > </a>
            <a href="{{ $lastPageUrl }}"> last > </a>
        @endif
    </div>
    <div style="width:50%; float:right;">
        Displaying {{ ceil($total_displayed) }} of {{ $total }}
    </div>
</div>
