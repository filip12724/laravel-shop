@if ($paginator->hasPages())
<div style="display:flex; flex-direction:column; align-items:center; gap:10px; margin-top:16px;">

    {{-- "Showing X to Y of Z" info --}}
    <p style="margin:0; font-size:0.85rem; color:#6c757d;">
        Showing <strong>{{ $paginator->firstItem() }}</strong>
        to <strong>{{ $paginator->lastItem() }}</strong>
        of <strong>{{ $paginator->total() }}</strong> results
    </p>

    {{-- Pagination buttons --}}
    <nav>
        <ul style="display:flex; flex-wrap:wrap; gap:4px; list-style:none; margin:0; padding:0;">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="display:inline-block; padding:5px 12px; font-size:0.875rem; border:1px solid #dee2e6; border-radius:4px; color:#adb5bd; background:#fff; cursor:default; user-select:none;">&lsaquo; Prev</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       style="display:inline-block; padding:5px 12px; font-size:0.875rem; border:1px solid #C3110C; border-radius:4px; color:#C3110C; background:#fff; text-decoration:none;"
                       onmouseover="this.style.background='#C3110C';this.style.color='#fff'"
                       onmouseout="this.style.background='#fff';this.style.color='#C3110C'">&lsaquo; Prev</a>
                </li>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span style="display:inline-block; padding:5px 10px; font-size:0.875rem; border:1px solid #dee2e6; border-radius:4px; color:#6c757d; background:#fff;">{{ $element }}</span>
                    </li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display:inline-block; padding:5px 10px; font-size:0.875rem; border:1px solid #C3110C; border-radius:4px; color:#fff; background:#C3110C; font-weight:600;">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   style="display:inline-block; padding:5px 10px; font-size:0.875rem; border:1px solid #dee2e6; border-radius:4px; color:#495057; background:#fff; text-decoration:none;"
                                   onmouseover="this.style.background='#f8f0ef';this.style.borderColor='#C3110C';this.style.color='#C3110C'"
                                   onmouseout="this.style.background='#fff';this.style.borderColor='#dee2e6';this.style.color='#495057'">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       style="display:inline-block; padding:5px 12px; font-size:0.875rem; border:1px solid #C3110C; border-radius:4px; color:#C3110C; background:#fff; text-decoration:none;"
                       onmouseover="this.style.background='#C3110C';this.style.color='#fff'"
                       onmouseout="this.style.background='#fff';this.style.color='#C3110C'">Next &rsaquo;</a>
                </li>
            @else
                <li>
                    <span style="display:inline-block; padding:5px 12px; font-size:0.875rem; border:1px solid #dee2e6; border-radius:4px; color:#adb5bd; background:#fff; cursor:default; user-select:none;">Next &rsaquo;</span>
                </li>
            @endif

        </ul>
    </nav>
</div>
@endif
