@if ($status == 0)
    <span class="badge badge-light-danger fs-7 fw-bold">{{ __('pinned') }}</span>
@elseif ($status == 1)
    <span class="badge badge-light-warning fs-7 fw-bold">{{ __('in progress') }}</span>
@elseif ($status == 2)
    <span class="badge badge-light-success fs-7 fw-bold">{{ __('done') }}</span>
@else
    <span class="badge badge-light-info fs-7 fw-bold">{{ __('unknown') }}</span>
@endif
