@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('pagination.pagination_navigation') }}">
        <div class="pagination-container">
            
            @if ($paginator->onFirstPage())
                <span class="pagination-item disabled">‹</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item">‹</a>
            @endif

            
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $showPages = 5; // Mostrar máximo 5 páginas
                
                // Calcular rango de páginas a mostrar
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $start + $showPages - 1);
                
                // Ajustar el inicio si estamos cerca del final
                if ($end - $start + 1 < $showPages) {
                    $start = max(1, $end - $showPages + 1);
                }
            @endphp
            
            
            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}" class="pagination-item pagination-first">1</a>
                @if ($start > 2)
                    <span class="pagination-item disabled pagination-dots">...</span>
                @endif
            @endif
            
            
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <span class="pagination-item active pagination-number" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->url($page) }}" class="pagination-item pagination-number">{{ $page }}</a>
                @endif
            @endfor
            
            
            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <span class="pagination-item disabled pagination-dots">...</span>
                @endif
                <a href="{{ $paginator->url($lastPage) }}" class="pagination-item pagination-last">{{ $lastPage }}</a>
            @endif

            
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item">›</a>
            @else
                <span class="pagination-item disabled">›</span>
            @endif
        </div>
    </nav>
@endif
