{{-- Server-side pagination styled with the site's existing .animated-pagination classes. --}}
@if ($paginator->hasPages())
@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
    $pages = collect([1, $last, $current - 1, $current, $current + 1])
        ->filter(fn ($p) => $p >= 1 && $p <= $last)->unique()->sort()->values();
@endphp
<nav class="animated-pagination" aria-label="{{ ucfirst($label ?? 'items') }} pages">
    <div class="pagination-wrap">
        <span class="pagination-summary">Showing <strong>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</strong> of <strong>{{ $paginator->total() }}</strong> {{ $label ?? 'items' }}</span>
        <div class="pagination-actions">
            @if ($paginator->onFirstPage())
                <span class="pagination-button pagination-prev is-disabled" aria-disabled="true"><i class="bi bi-arrow-left" aria-hidden="true"></i><span>Previous</span></span>
            @else
                <a class="pagination-button pagination-prev" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="bi bi-arrow-left" aria-hidden="true"></i><span>Previous</span></a>
            @endif

            @foreach ($pages as $page)
                @if (!$loop->first && $page - $pages[$loop->index - 1] > 1)
                    <span class="pagination-gap" aria-hidden="true">…</span>
                @endif
                @if ($page === $current)
                    <span class="pagination-button pagination-number is-current" aria-current="page">{{ $page }}</span>
                @else
                    <a class="pagination-button pagination-number" href="{{ $paginator->url($page) }}" aria-label="Page {{ $page }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="pagination-button pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next"><span>Next</span><i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            @else
                <span class="pagination-button pagination-next is-disabled" aria-disabled="true"><span>Next</span><i class="bi bi-arrow-right" aria-hidden="true"></i></span>
            @endif
        </div>
    </div>
</nav>
@endif
