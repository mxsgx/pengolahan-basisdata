@if ($paginator->hasPages())
    <div class="card">
        <div class="card-body">
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="page-item page-prev disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                            <div class="page-item-subtitle">Previous</div>
                            <div class="page-item-title">Page</div>
                        </a>
                    </li>
                @else
                    <li class="page-item page-prev">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1"
                           aria-disabled="true">
                            <div class="page-item-subtitle">Previous</div>
                            <div class="page-item-title">Page</div>
                        </a>
                    </li>
                @endif

                @if($paginator->hasMorePages())
                    <li class="page-item page-next">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                            <div class="page-item-subtitle">Next</div>
                            <div class="page-item-title">Page</div>
                        </a>
                    </li>
                @else
                    <li class="page-item page-next disabled">
                        <a class="page-link" href="#">
                            <div class="page-item-subtitle">Next</div>
                            <div class="page-item-title">Page</div>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
