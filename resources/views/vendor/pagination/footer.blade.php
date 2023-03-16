<?php
$link_limit = 9; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 0)
    <div id="news_paginate" class="dataTables_paginate paging_simple_numbers">
        <ul class="pagination justify-content-center">
            <li id="news_first"
                class="paginate_button page-item first button-control {{ $paginator->currentPage() == 1 ? 'disabled' : '' }}">
                <div class="myTooltip myTooltip-top myTooltip-info">
                    <span class="tooltiptext">First</span>
                </div>
                <a class="page-link" tabindex="0" href="{{ $paginator->url(1) }}" aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li id="news_previous"
                class="paginate_button page-item previous button-control {{ $paginator->currentPage() == 1 ? 'disabled' : '' }}">
                <div class="myTooltip myTooltip-top myTooltip-info">
                    <span class="tooltiptext">Previous</span>
                </div>
                @if ($paginator->currentPage() == 1)
                    <a class="page-link" tabindex="0" href="{{ $paginator->url($paginator->currentPage()) }}"><span
                            aria-hidden="true">&lsaquo;</span></a>
                @else
                    <a class="page-link" tabindex="0" href="{{ $paginator->url($paginator->currentPage() - 1) }}"
                        aria-label="Previous">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                @endif
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <?php
                $half_total_links = floor($link_limit / 2);
                $from = $paginator->currentPage() - $half_total_links;
                $to = $paginator->currentPage() + $half_total_links;
                if ($paginator->currentPage() < $half_total_links) {
                    $to += $half_total_links - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                    <li class="paginate_button page-item {{ $paginator->currentPage() == $i ? ' active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor
            <li id="news_next"
                class="paginate_button page-item next button-control {{ $paginator->currentPage() == $paginator->lastPage() ? 'disabled' : '' }}">
                <div class="myTooltip myTooltip-top myTooltip-info">
                    <span class="tooltiptext">Next</span>
                </div>
                @if ($paginator->currentPage() == $paginator->lastPage())
                    <a class="page-link" tabindex="0" href="{{ $paginator->url($paginator->currentPage()) }}"><span
                            aria-hidden="true">&rsaquo;</span></a>
                @else
                    <a class="page-link" tabindex="0" href="{{ $paginator->url($paginator->currentPage() + 1) }}"
                        aria-label="Next">
                        {{-- Next --}}
                        <span aria-hidden="true">&rsaquo;</span>
                    </a>
                @endif
            </li>
            <li
                class="page-item last button-control {{ $paginator->currentPage() == $paginator->lastPage() ? 'disabled' : '' }}">
                <div class="myTooltip myTooltip-top myTooltip-info">
                    <span class="tooltiptext">Last</span>
                </div>
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}"><span
                        aria-hidden="true">&raquo;</span></a>
            </li>
        </ul>
    </div>
@endif
