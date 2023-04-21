@if ($paginator->appends(request()->query())->lastPage() > 1)
<div class="row w-100 m-0">
    <div class="col-lg-12 d-flex justify-content-end">
        <div class="dataTables_paginate paging_simple_numbers" id="datatable-buttons_paginate">
            <ul class="pagination custom-pagination">
                @if ($paginator->lastPage() <= 5)
                    <li class="paginate_button page-item previous {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" id="datatable-buttons_previous">
                        <a href="{{ ($paginator->currentPage() == 1) ? '#' : $paginator->url($paginator->currentPage()-1) }}" aria-controls="datatable-buttons" data-dt-idx="0" tabindex="0"
                        class="page-link">{!! trans('pagination.previous') !!}</a>
                    </li>
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <li class="paginate_button page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                            <a href="{{ $paginator->url($i) }}" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0"
                            class="page-link">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="paginate_button page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}" id="datatable-buttons_next">
                        <a href="{{ ($paginator->currentPage() == $paginator->lastPage()) ? '#' : $paginator->url($paginator->currentPage()+1)  }}" aria-controls="datatable-buttons" data-dt-idx="4" tabindex="0"
                           class="page-link">{!! trans('pagination.next') !!}</a>
                    </li>

                @else
                    {{-- Previous Page Link --}}
                    @php
                        $slide = 1;
                        if ($paginator->onFirstPage() || !$paginator->hasMorePages()) {
                            $slide = $slide + 1;
                        }
                    @endphp

                    @if($paginator->currentPage() >= 2)
                        <li class="paginate_button page-item">
                            <a href="{{ $paginator->url(1) }}" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0" class="page-link">{!! trans('pagination.previous') !!}</a>
                        </li>
                        @if($paginator->currentPage() > 2)
                            <li class="paginate_button page-item disabled">
                                <a href="#" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0" class="page-link">
                                    ...
                                </a>
                            </li>
                        @endif

                    @endif

                    @foreach(range(1, $paginator->lastPage()) as $i)
                        @if($i >= $paginator->currentPage() - $slide && $i <= $paginator->currentPage() + $slide)
                            @if ($i == $paginator->currentPage())
                                <li class="page-item active cc {{ $slide }}">
                                <li class="paginate_button page-item active">
                                    <a href="#" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0"
                                    class="page-link">{{ $i }}</a>
                                </li>
                            @else
                                <li class="paginate_button page-item">
                                    <a href="{{ $paginator->url($i) }}" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0"
                                    class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        @if($paginator->currentPage() <= ($paginator->lastPage() - 3))
                            <li class="paginate_button page-item disabled">
                                <a href="#" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0" class="page-link">
                                    ...
                                </a>
                            </li>
                        @endif

                        @if ($paginator->currentPage() != ($paginator->lastPage() - 1))
                            <li class="paginate_button page-item">
                                <a href="{{ $paginator->url($paginator->lastPage()) }}" aria-controls="datatable-buttons" data-dt-idx="1" tabindex="0"
                                class="page-link">{{ $paginator->lastPage() }}</a>
                            </li>
                        @endif
                        <li class="paginate_button page-item" id="datatable-buttons_next">
                            <a href="{{ $paginator->url($paginator->currentPage() + 1)  }}" aria-controls="datatable-buttons" data-dt-idx="4" tabindex="0"
                               class="page-link">{!! trans('pagination.next') !!}</a>
                        </li>
                    @endif

                @endif
            </ul>
        </div>
    </div>
</div>
@endif
