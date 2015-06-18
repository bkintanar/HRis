<div class="row">
    <div class="col-sm-6">
        <div>Displaying {{ ceil($total_displayed) }} of {{ $total }}</div>
    </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate">
            <ul class="pagination">
                <li class="paginate_button @if($currentPage == 1) disabled @endif">
                    <a href="{{ $prevPageUrl . $sortPage . $directionPage }}"> Previous </a>
                </li>
                @for($i = $start_page; $i <= $end_page; $i++)
                    <li class="paginate_button @if($currentPage == $i) active @endif">
                        <a href="{{ $pathPage . $i . $sortPage . $directionPage }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="paginate_button @if($currentPage == $totalPages) disabled @endif">
                    <a href="{{ $nextPageUrl . $sortPage . $directionPage }}"> Next </a>
                </li>
            </ul>
        </div>
    </div>
</div>