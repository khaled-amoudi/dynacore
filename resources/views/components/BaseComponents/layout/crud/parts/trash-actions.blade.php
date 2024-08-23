<div class="d-flex justify-content-end flex-shrink-0">

    {{--
////////////////////////////////////////////////////////////////////////////////////////////////
Restore
////////////////////////////////////////////////////////////////////////////////////////////////
--}}

    @can('restore-' . $resource_name)
        @isset($actions['route_restore'])
            <form id="restore_form_{{ $id }}" action="{{ route($actions['route_restore'], $id) }}" method="POST"
                onsubmit="performRestore({{ $id }})" class="d-inline-block">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-light-primary btn-sm me-1 text-capitalize" title="{{ __('common.restore') }}"
                    data-bs-original-title="Re-store" aria-label="Re-store">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M17.1 15.8C16.6 15.7 16 16 15.9 16.5C15.7 17.4 14.9 18 14 18H6C4.9 18 4 17.1 4 16V8C4 6.9 4.9 6 6 6H14C15.1 6 16 6.9 16 8V9.4H18V8C18 5.8 16.2 4 14 4H6C3.8 4 2 5.8 2 8V16C2 18.2 3.8 20 6 20H14C15.8 20 17.4 18.8 17.9 17.1C17.9 16.5 17.6 16 17.1 15.8Z"
                                fill="black" />
                            <path opacity="0.3" d="M11.9 9.39999H21.9L17.6 13.7C17.2 14.1 16.6 14.1 16.2 13.7L11.9 9.39999Z"
                                fill="black" />
                        </svg>
                    </span>
                    {{ __('common.restore') }}
                </button>
            </form>
        @endisset
    @endcan


    {{--
////////////////////////////////////////////////////////////////////////////////////////////////
Force Delete
////////////////////////////////////////////////////////////////////////////////////////////////
--}}

    @can('force-delete-' . $resource_name)
        @isset($actions['route_destroy'])
            <a type="button" class="btn btn-icon btn-light-danger btn-sm" title="{{ __('common.delete') }}"
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

                            <p class="fw-bold">{{ __('common.Are You Sure You Want To Delete This Item Forever?') }}</p>
                            <p class="mt-5"><span class="badge badge-light-danger">{{ __('common.NOTE:') }}</span>
                                {{ __('common.You will') }} <span
                                    class="border-bottom border-danger">{{ __('common.not be able') }}</span>
                                {{ __('common.to restore this record after deleting it.') }}</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                            <form id="delete_form_{{ $id }}"
                                action="{{ route($actions['route_force_delete'], $id) }}" method="POST"
                                onsubmit="performForceDelete({{ $id }})" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">
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
