<div style="width:100%">

    <div style="width:50%;">
        Displaying {{ ceil($total_displayed) }} of {{ $total }}
    </div>

    <div style="width:50%;">

        <ul class="pagination">
            <li class="paginate_button @if($currentPage == 1) disabled @endif">
                <a href="{{ $prevPageUrl . $sortPage . $directionPage }}"> prev </a>
            </li>
            @for($i = 1; $i <= $totalPages; $i++)
                <li class="paginate_button @if($currentPage == $i) active @endif">
                    <a href="{{ $pathPage . $i . $sortPage . $directionPage }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="paginate_button @if($currentPage == $totalPages) disabled @endif">
                <a href="{{ $nextPageUrl . $sortPage . $directionPage }}"> next </a>
            </li>
        </ul>

    </div>
</div>