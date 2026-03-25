@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        style="display: flex; align-items: center; justify-content: space-between; padding: 2rem 0;">
        <!-- Mobile View -->
        <div style="display: none; flex: 1; justify-content: space-between;" class="pagination-mobile-only">
            @if ($paginator->onFirstPage())
                <span
                    style="position: relative; display: inline-flex; align-items: center; padding: 0.625rem 1rem; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; opacity: 0.5; cursor: default; border-radius: 0.5rem;">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    style="position: relative; display: inline-flex; align-items: center; padding: 0.625rem 1rem; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; text-decoration: none; border-radius: 0.5rem;">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    style="position: relative; display: inline-flex; align-items: center; padding: 0.625rem 1rem; margin-left: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; text-decoration: none; border-radius: 0.5rem;">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    style="position: relative; display: inline-flex; align-items: center; padding: 0.625rem 1rem; margin-left: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; opacity: 0.5; cursor: default; border-radius: 0.5rem;">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <!-- Desktop View -->
        <div style="display: flex; flex: 1; align-items: center; justify-content: space-between;"
            class="pagination-desktop-only">
            <div style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.6);">
                <p style="margin: 0;">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span style="font-weight: 600; color: white;">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span style="font-weight: 600; color: white;">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span style="font-weight: 600; color: white;">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span style="display: inline-flex; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}"
                            style="position: relative; display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1rem; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; min-width: 40px; opacity: 0.5; cursor: default; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}"
                            style="position: relative; display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1rem; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; text-decoration: none; min-width: 40px; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true"
                                style="position: relative; display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1rem; margin-left: -1px; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; min-width: 40px;">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                        style="position: relative; display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1rem; margin-left: -1px; border: 1px solid #D4AF37; background-color: #D4AF37; color: #000; font-size: 0.875rem; font-weight: 700; min-width: 40px; z-index: 3;">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                        style="position: relative; display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1rem; margin-left: -1px; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; text-decoration: none; min-width: 40px;">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}"
                            style="position: relative; display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1rem; margin-left: -1px; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; text-decoration: none; min-width: 40px; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}"
                            style="position: relative; display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1rem; margin-left: -1px; border: 1px solid rgba(255, 255, 255, 0.1); background-color: rgba(20, 20, 25, 0.8); color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; font-weight: 500; min-width: 40px; opacity: 0.5; cursor: default; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>

    <style>
        @media (max-width: 640px) {
            .pagination-mobile-only {
                display: flex !important;
            }

            .pagination-desktop-only {
                display: none !important;
            }
        }
    </style>
@endif