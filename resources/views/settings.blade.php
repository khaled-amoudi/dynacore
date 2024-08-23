@extends('layouts.master')

@section('title')
    {{ __('common.' . config('app.name')) . ' | ' . __('settings') }}
@endsection

@section('toolbar')
    <x-BaseComponents.layout.breadcrumb :prev_pages="[
        'dashboard' => 'dashboard',
    ]" current_page="settings" />
@endsection



@section('content')
    <div class="row g-5 g-xl-8 mx-5 mx-md-9">
        <div class="card">
            <!--begin::Header-->
            <div class="card-header card-header-stretch overflow-auto">
                <!--begin::Tabs-->
                <ul class="nav nav-stretch nav-line-tabs fw-semibold fs-6 border-transparent flex-nowrap" role="tablist"
                    id="kt_layout_builder_tabs">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#settings_form_main" role="tab"
                            aria-selected="true">
                            {{ __('common.Main') }}</a>
                    </li>
                </ul>
                <!--end::Tabs-->
            </div>
            <!--end::Header-->

            <!--begin::Form-->
            <form class="form" onsubmit="performSettings()" action="{{ route('dashboard.settings.update') }}"
                redirectto="{{ route('dashboard.settings.index') }}" method="POST" id="settings_form"
                enctype="multipart/form-data">
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                    <div class="tab-content pt-3">
                        <!--begin::Tab pane-->
                        <div class="tab-pane active show" id="settings_form_main" role="tabpanel">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <!--begin::Heading-->
                                <div class="mb-6">
                                    <h4 class="fw-bold text-dark">{{ __('common.Theme Mode') }}</h4>
                                    <div class="fw-semibold text-muted fs-7 d-block lh-1">
                                        {{ __('common.Enjoy Dark & Light modes.') }}
                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Options-->
                                <div class="row mw-lg-600px" data-kt-buttons="true"
                                    data-kt-buttons-target=".form-check-image,.form-check-input" data-kt-initialized="1">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Option-->
                                        <label class="form-check-image form-check-success">
                                            <!--begin::Image-->
                                            <div class="form-check-wrapper border-gray-200 border-2">
                                                <img src="{{ asset('cms/assets/media/preview/demo1/light-ltr.png') }}"
                                                    class="form-check-rounded rounded mw-75" alt="">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Check-->
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-sm form-check-success mt-3">
                                                <input class="form-check-input" type="radio" value="light"
                                                    name="theme_mode" id="kt_layout_builder_theme_mode_light">

                                                <!--begin::Label-->
                                                <div class="form-check-label text-gray-700">
                                                    {{ __('common.Light') }} </div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Check-->
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Option-->
                                        <label class="form-check-image form-check-success active">
                                            <!--begin::Image-->
                                            <div class="form-check-wrapper border-gray-200 border-2">
                                                <img src="{{ asset('cms/assets/media/preview/demo1/dark-ltr.png') }}"
                                                    class="form-check-rounded rounded mw-75" alt="">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Check-->
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-sm form-check-success mt-3">
                                                <input class="form-check-input" type="radio" value="dark"
                                                    name="theme_mode" id="kt_layout_builder_theme_mode_dark">

                                                <!--begin::Label-->
                                                <div class="form-check-label text-gray-700">
                                                    {{ __('common.Dark') }} </div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Check-->
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Col-->

                                </div>
                                <!--end::Options-->
                            </div>
                            <!--end::Form group-->

                            <div class="separator separator-dashed my-6"></div>

                            <!--begin::Form group-->
                            <div class="form-group d-flex flex-stack">
                                <!--begin::Heading-->
                                <div class="d-flex flex-column">
                                    <h4 class="fw-bold text-dark">{{ __('common.Language') }}</h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                        {{ __('common.Change Dashboard Language.') }}
                                    </div>
                                </div>
                                <!--end::Heading-->
                                <!--begin::Options-->
                                <div class="d-flex flex-stack gap-3 mw-lg-600px" data-kt-buttons="true"
                                    data-kt-buttons-target=".form-check-image,.form-check-input" data-kt-initialized="1">
                                    <!--begin::Option-->
                                    <label
                                        class="_active_lang form-check-image form-check-success w-100 parent-active parent-hover {{ App::currentLocale() == 'en' ? 'active' : '' }}">
                                        <input type="radio" class="btn-check" name="dashboard_language" value="en"
                                            {{ App::currentLocale() == 'en' ? 'checked' : '' }}
                                            id="dashboard_language_en" />
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-outline-default p-3 d-flex align-items-center"
                                            for="dashboard_language_en">
                                            <span class="svg-icon svg-icon-4x me-4">
                                                <img class="w-15px h-15px rounded-1 ms-2"
                                                    src="{{ asset('cms/assets/media/flags/united-states.svg') }}"
                                                    alt="english">
                                            </span>
                                            <span class="d-block fw-bold text-start">
                                                <span class="text-dark fw-bold d-block fs-4">English</span>
                                            </span>
                                        </label>
                                        <!--end::Option-->
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label
                                        class="_active_lang form-check-image form-check-success w-100 parent-active parent-hover {{ App::currentLocale() == 'ar' ? 'active' : '' }}">
                                        <input type="radio" class="btn-check" name="dashboard_language" value="ar"
                                            {{ App::currentLocale() == 'ar' ? 'checked' : '' }}
                                            id="dashboard_language_ar" />
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-outline-default p-3 d-flex align-items-center"
                                            for="dashboard_language_ar">
                                            <span class="svg-icon svg-icon-4x me-4">
                                                <img class="w-15px h-15px rounded-1 ms-2"
                                                    src="{{ asset('cms/assets/media/flags/saudi-arabia.svg') }}"
                                                    alt="العربية">
                                            </span>
                                            <!--end::Svg Icon-->
                                            <span class="d-block fw-bold text-start">
                                                <span class="text-dark fw-bold d-block fs-4">العربية</span>
                                            </span>
                                        </label>
                                        <!--end::Option-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Options-->
                            </div>

                            <div class="separator separator-dashed my-6"></div>

                            <!--begin::Form group-->
                            <div class="form-group d-flex flex-stack">
                                <!--begin::Heading-->
                                <div class="d-flex flex-column ">
                                    <h4 class="fw-bold text-dark">{{ __('common.Filters Accordion') }}</h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                        {{ __('common.Filters accordion in the top of base tables') }}
                                    </div>
                                </div>
                                <!--end::Heading-->
                                <!--begin::Options-->
                                <div class="d-flex gap-7">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-success form-check-solid form-check-sm">
                                        <input class="form-check-input" name="accordion_status" type="radio"
                                            {{ Cookie::get('dynacore_accordion_status') == 'opened' ? 'checked' : '' }}
                                            value="opened" id="accordion_status_opened">

                                        <!--begin::Label-->
                                        <label class="form-check-label text-gray-700 fw-bold text-nowrap"
                                            for="accordion_status_opened">
                                            {{ __('common.Opened') }} </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Check-->
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-success form-check-solid form-check-sm">
                                        <input class="form-check-input" name="accordion_status" type="radio"
                                            {{ Cookie::get('dynacore_accordion_status') != 'opened' || !Cookie::get('dynacore_accordion_status') ? 'checked' : '' }}
                                            value="closed" id="accordion_status_closed">

                                        <!--begin::Label-->
                                        <label class="form-check-label text-gray-700 fw-bold text-nowrap"
                                            for="accordion_status_closed">
                                            {{ __('common.Closed') }} </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Check-->
                                </div>
                                <!--end::Options-->
                            </div>
                        </div>
                        <!--end::Tab pane-->
                    </div>
                </div>
                <!--end::Body-->

                <!--begin::Footer-->
                <div class="card-footer d-flex py-8">
                    <input type="hidden" id="kt_layout_builder_tab" name="layout-builder[tab]"
                        value="settings_form_main">
                    <input type="hidden" id="kt_layout_builder_action" name="layout-builder[action]">

                    <button type="submit" id="kt_layout_builder_preview" class="btn btn-primary me-2">
                        <span class="indicator-label">
                            {{ __('common.Preview') }}
                        </span>
                        <span class="indicator-progress">
                            {{ __('common.Please wait...') }} <span
                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>

                    <button type="button" id="kt_layout_builder_reset" class="btn btn-light me-2">
                        <span class="indicator-label">
                            {{ __('common.Reset') }}
                        </span>
                        <span class="indicator-progress">
                            {{ __('common.Please wait...') }} <span
                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
@endsection



@push('script')
    <script>
        function performSettings() {
            event.preventDefault();

            const form = document.getElementById("settings_form");
            const url = form.getAttribute("action");
            const redirectUrl = form.getAttribute("redirectto");



            let formData = new FormData();

            var opened = document.getElementById('accordion_status_opened').checked;
            var closed = document.getElementById('accordion_status_closed').checked;
            formData.append('accordion_status', opened == true ? 'opened' : 'closed');

            var dashboard_language = document.querySelector('._active_lang.active').querySelector('input').value;
            formData.append('dashboard_language', dashboard_language);
            // formData.append(item, document.getElementById(item).value);



            const saveBtn = $('button[type="submit"]');
            saveBtn.prop("disabled", true);

            axios
                .post(url, formData)
                .then(function(response) {
                    toastr_showMessage(response.data);

                    if (redirectUrl != null) {
                        var delay = 1750;
                        setTimeout(function() {
                            window.location.href = redirectUrl;
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
                    }, 2000);
                });
        }
    </script>
@endpush
