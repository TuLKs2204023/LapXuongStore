<?php
?>

@if ($paginator->lastPage() > 0)
    <div id="news_paginate" class="dataTables_paginate paging_simple_numbers">
        <p class="">Showing &nbsp;{{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }}
            &nbsp;&rarr;&nbsp;
            {{ ($paginator->currentPage() - 1) * $paginator->perPage() + $paginator->count() }} &nbsp;of&nbsp;
            {{ $paginator->total() }} &nbsp;Products</p>
    </div>
@endif
