@if ($status == 0)
    <span class="badge badge-light-danger fs-7 fw-bold">{{ __('pinned') }}</span>
@elseif ($status == 1)
    <span class="badge badge-light-warning fs-7 fw-bold">{{ __('published') }}</span>
@elseif ($status == 2)
    <span class="badge badge-light-success fs-7 fw-bold">{{ __('blocked') }}</span>
@endif
