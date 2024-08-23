@extends('layouts.master')

@section('title')
    {{ __('common.' . config('app.name')) . ' | ' . __('manage role') }}
@endsection


@section('toolbar')
    <x-BaseComponents.layout.breadcrumb :prev_pages="[
        'dashboard' => 'dashboard',
    ]" :current_page="__('manage role')" />
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-5 mb-xl-8">
                <form onsubmit="performUpdatePermissions({{ $role->id }})"
                    action="{{ route('dashboard.role.update_permissions', $role->id) }}" method="post"
                    redirectto="{{ route('dashboard.role.index') }}" enctype="multipart/form-data" id="update_permissions_form"
                    class="form-horizontal">
                    @csrf

                    <div class="card-header">
                        <h3 class="card-title align-items-start text-gray-700 fw-bold flex-column">
                            <small>{{ __('role') }}: </small> <span>{{ $role->name }}</span>
                        </h3>
                        <div class="card-toolbar">
                            <div class="kh_breadcrumb_move">
                                <a href="{{ url()->previous() }}" class="btn btn-cancel text-gray-600 shadow px-3 mx-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                    <span>{{ __('common.Cancel') }}</span>
                                </a>
                                {{-- <x-BaseComponents.form.common.submit_button /> --}}
                                <button id="saveBtn" type="submit" class="btn btn-primary shadow">
                                    <span class="indicator-label svg-icon svg-icon-2"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z"
                                                fill="black"></path>
                                        </svg>
                                        {{ __('common.save') }}
                                    </span>
                                    <span class="indicator-progress">
                                        {{ __('common.saving') }} <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="row">
                            @foreach ($permissions as $group_name => $group_permissions)
                                <div class="col-md-12">
                                    <div class="mb-5 d-flex align-items-center">
                                        <span class="text-gray-700 fw-normal fs-3 me-5">
                                            <small>{{ __('common.permissions_of') }}: </small>
                                            <span
                                                class="fw-bold">{{ __(str_replace(['-', '_'], ' ', $group_name)) }}</span>
                                        </span>
                                        {{-- <a href="#" class="select-all me-1 cursor-pointer badge badge-light-info"
                                                style="border: 1px solid #08080814">select all</a>
                                            <a href="#" class="unselect-all me-1 cursor-pointer badge badge-light-danger"
                                                style="border: 1px solid #08080814">unselect all</a> --}}
                                        <a href="#"
                                            class="select-all me-4 text-decoration-underline cursor-pointer">{{ __('common.select_all') }}</a>
                                        <a href="#"
                                            class="unselect-all me-4 text-decoration-underline cursor-pointer">{{ __('common.unselect_all') }}</a>
                                    </div>
                                    <div>
                                        {{-- @forelse ($role->permissions as $permission) --}}
                                        @forelse ($group_permissions as $permission)
                                            <label class="col-md-3">
                                                <div class="form-check form-check-custom form-check-sm">
                                                    <input name="{{ $permission->name }}" value="{{ $permission->id }}"
                                                        class="form-check-input permission-checkbox" type="checkbox"
                                                        id="flexCheckDefault{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} />
                                                    <label class="form-check-label"
                                                        for="flexCheckDefault{{ $permission->id }}">
                                                        {{ ucwords(str_replace(['-', '_'], ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            </label>
                                        @empty
                                            <small>Sorry, we did not found any permissions for this group.</small>
                                        @endforelse
                                    </div>
                                    @if (!$loop->last)
                                        <div class="separator border-2 my-7"></div>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>

        </div>

    </div>
@endsection

@push('script')
    <script>
        // select | unselect - all inputs when click on (select | unselect - all) btn
        $('.select-all').on('click', function(e) {
            e.preventDefault();
            $(this).parent().next().find('label:not(.main) input').prop('checked', true);
        });
        $('.unselect-all').on('click', function(e) {
            e.preventDefault();
            $(this).parent().next().find('label:not(.main) input').prop('checked', false);
        });

        /////////////////////////////////////////////////////////////////

        function performUpdatePermissions(id) {
            event.preventDefault();

            const form = document.getElementById('update_permissions_form');
            const url = form.getAttribute('action');
            const redirectUrl = form.getAttribute('redirectto');

            let formData = new FormData();

            let checkboxes = document.querySelectorAll('.permission-checkbox');
            // Loop through each checkbox
            checkboxes.forEach(checkbox => {
                // If the checkbox is checked, append its value (permission ID) to the FormData object
                if (checkbox.checked) {
                    formData.append('permissions[]', checkbox.value);
                }
            });

            x_update_permission(url, formData, redirectUrl);
        }


        function x_update_permission(url, data, redirectUrl = null) {
            // disable save button to prevent multi create
            const saveBtn = $('button[type="submit"]');
            saveBtn.prop("disabled", true);
            saveBtn.attr("data-kt-indicator", "on");

            axios
                .post(url, data, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(function(response) {
                    toastr_showMessage(response.data);

                    if (redirectUrl != null) {
                        var delay = 1750;
                        setTimeout(function() {
                            window.location.href = redirectUrl;
                            // loadContent(redirectUrl);
                        }, delay);
                    }
                })
                .catch(function(error) {
                    if (error.response.data.errors !== undefined) {
                        toastr_showErrors(error.response.data.errors);
                    } else {
                        toastr_showMessage(error.response.data);
                    }
                })
                .then(function() {
                    setTimeout(function() {
                        saveBtn.prop("disabled", false);
                        saveBtn.removeAttr("data-kt-indicator");
                    }, 2000);
                });
        }
    </script>
@endpush
