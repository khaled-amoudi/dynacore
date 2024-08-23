<div class="d-flex justify-content-end flex-shrink-0">
    {{--
////////////////////////////////////////////////////////////////////////////////////////////////
Show
////////////////////////////////////////////////////////////////////////////////////////////////
--}}
    @can('show-' . $resource_name)
        @isset($actions['route_show'])
            <a href="{{ route($actions['route_show'], $id) }}" class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1"
                title="{{ __('common.show') }}">
                <span class="svg-icon svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                        viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                                d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                </span>
            </a>
        @endisset
    @endcan


    {{--
////////////////////////////////////////////////////////////////////////////////////////////////
Edit
////////////////////////////////////////////////////////////////////////////////////////////////
--}}
    @can('edit-' . $resource_name)
        @isset($actions['route_edit'])
            <a href="{{ route($actions['route_edit'], $id) }}"
                class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1" title="{{ __('common.update') }}">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                            d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z"
                            fill="black"></path>
                        <path
                            d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z"
                            fill="black"></path>
                        <path
                            d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z"
                            fill="black"></path>
                    </svg>

                </span>
            </a>
        @endisset
    @endcan
    {{--
////////////////////////////////////////////////////////////////////////////////////////////////
Delete
////////////////////////////////////////////////////////////////////////////////////////////////
--}}
    @can('destroy-' . $resource_name)

        @isset($actions['route_destroy'])
            <a type="button" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="{{ __('common.delete') }}"
                data-bs-toggle="modal" data-bs-target="#kt_modal_{{ $id }}">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                            fill="black"></path>
                        <path opacity="0.5"
                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                            fill="black"></path>
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                            fill="black">
                        </path>
                    </svg>
                </span>
            </a>
            <div class="modal fade" tabindex="-1" id="kt_modal_{{ $id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{ __('common.Delete This Record') }}</h3>

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                aria-label="Close">
                                <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs012.svg-->
                                <span class="svg-icon svg-icon-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3"
                                            d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                            fill="black"></path>
                                        <path
                                            d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                            fill="black"></path>
                                    </svg></span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>

                        <div class="modal-body">
                            @if (isset($actions['configs']['with_soft_delete']) && $actions['configs']['with_soft_delete'] == true)
                                <p class="fw-bold">{{ __('common.Move This Item To Trash ?') }}</p>
                                <p class="mt-5"><span class="badge badge-light-danger">{{ __('common.NOTE:') }}</span>
                                    {{ __('common.You will') }} <span
                                        class="border-bottom border-success">{{ __('common.be able') }}</span>
                                    {{ __('common.to restore this record after deleting it.') }}</p>
                            @else
                                <p class="fw-bold">{{ __('common.Are You Sure You Want To Delete This Item Forever?') }}</p>
                                <p class="mt-5"><span class="badge badge-light-danger">{{ __('common.NOTE:') }}</span>
                                    {{ __('common.You will') }} <span
                                        class="border-bottom border-danger">{{ __('common.not be able') }}</span>
                                    {{ __('common.to restore this record after deleting it.') }}</p>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                            <form id="delete_form_{{ $id }}" action="{{ route($actions['route_destroy'], $id) }}"
                                method="POST" onsubmit="performDelete({{ $id }})" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger text-capitalize">
                                    <i class="fas fa-trash"></i> {{ __('common.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    @endcan
</div>
