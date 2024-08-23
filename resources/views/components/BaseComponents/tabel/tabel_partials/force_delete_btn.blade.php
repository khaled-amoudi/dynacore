<a type="button"
class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"
title="delete" data-bs-toggle="modal"
data-bs-target="#kt_modal_{{ $data['id'] }}">
<!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
<span class="svg-icon svg-icon-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="24"
        height="24" viewBox="0 0 24 24" fill="none">
        <path
            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
            fill="black"></path>
        <path opacity="0.5"
            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
            fill="black"></path>
        <path opacity="0.5"
            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
            fill="black">
        </path>
    </svg>
</span>
<!--end::Svg Icon-->
</a>
<div class="modal fade" tabindex="-1"
id="kt_modal_{{ $data['id'] }}">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Delete This Record
            </h3>

            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                data-bs-dismiss="modal" aria-label="Close">
                <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs012.svg-->
                <span class="svg-icon svg-icon-muted"><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
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
            Are You Sure You Want To Delete This Item Forever?

            {{-- <p><span
                    class="badge badge-light-danger">NOTE:</span>
                You
                will not be able to restore this record
                after deleting
                it.</p> --}}
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-light"
                data-bs-dismiss="modal">Close</button>
            <form
                id="delete_form_{{ $data['id'] }}"
                action="{{ route($actions['route_force_delete'], $data['id']) }}"
                method="POST" onsubmit="performDelete({{ $data['id'] }})" class="d-inline-block">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
</div>
