@extends('layouts.master')

@section('title')
    {{ __('common.' . config('app.name')) . ' | ' . __($data['resource_name'] . ' list') }}
@endsection


@section('toolbar')
    <x-BaseComponents.layout.breadcrumb :prev_pages="[
        'dashboard' => 'dashboard',
    ]" :current_page="$data['resource_name'] . ' list'" />
@endsection


@section('content')
    <div id="kt_content" class="content pt-0">
        <div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
            <div class="container-fluid" id="kt_docs_content_container">

                <div class="filters">
                    <div class="ms-auto position-relative">
                        <div class="row">
                            @if (isset($data['table_data']['filters']) && $data['table_data']['filters'] != [])
                                <x-BaseComponents.tabel.tabel_partials.filters :filters="$data['table_data']['filters']" />
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">

                    <div class="card shadow-sm mb-5 mb-xl-8">
                        <div class="card-header pt-5 pb-3">
                            <h3 class="card-title align-items-start flex-column">
                                <span
                                    class="card-label fw-bolder text-gray-700 fs-3 mb-1">{{ __($data['resource_name'] . ' list') }}</span>
                            </h3>

                            <div class="card-toolbar">

                                @if (isset($data['table_data']['actions']['configs']['with_multi_delete']) &&
                                        $data['table_data']['actions']['configs']['with_multi_delete'] == true)
                                    @if (isset($data['table_data']['actions']['configs']['with_soft_delete']) &&
                                            $data['table_data']['actions']['configs']['with_soft_delete'] == true)
                                        <x-BaseComponents.tabel.tabel_partials.multi_delete_btn />
                                    @else
                                        <x-BaseComponents.tabel.tabel_partials.multi_force_delete_btn />
                                    @endif
                                @endif




                                {{-- <a href="{{ url()->previous() }}" class="btn btn-cancel text-gray-600 shadow px-3 mx-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                                        <line x1="19" y1="12" x2="5" y2="12">
                                        </line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                    <span>Cancel</span>
                                </a> --}}

                                @can('create-' . $data['resource_name'])
                                    <a href="{{ route($data['table_data']['actions']['route_create']) }}"
                                        class="btn btn-primary shadow">
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                    rx="1" transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                    fill="black"></rect>
                                            </svg>
                                        </span>{{ __('common.Add New') }}</a>
                                @endcan



                                @php
                                    if (
                                        isset($data['table_data']['actions']['configs']['with_exports']) &&
                                        $data['table_data']['actions']['configs']['with_exports'] == true
                                    ) {
                                        $export_display = '';
                                    } else {
                                        $export_display = 'd-none';
                                    }
                                @endphp
                                <button type="button"
                                    class="{{ $export_display }} btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info px-4 ms-2 exportingBtn"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                    <i class="fas fa-envelope-open-text fs-4"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div id="colvis-btn"></div>
                                        <div class="separator border-2 mt-5 mb-3"></div>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a id="customExportExcelButton" class="menu-link px-3">
                                            <i class="text-success fa-regular fa-file-excel me-2"></i>
                                            {{ __('common.Export as Excel') }}
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a id="customExportPDFButton" class="menu-link px-3">
                                            <i class="text-danger fa-regular fa-file-pdf me-2"></i>
                                            {{ __('common.Export as PDF') }}
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a id="customPrintButton" class="menu-link px-3">
                                            <i class="text-info fa-solid fa-print me-2"></i> {{ __('common.Print') }}
                                        </a>
                                    </div>
                                </div>


                                @if (isset($data['table_data']['actions']['configs']['with_trans_switcher']) &&
                                        $data['table_data']['actions']['configs']['with_trans_switcher'] == true)
                                    <!--begin::Radio group-->
                                    <div class="_language_switcher btn-group rounded-pill ms-3"
                                        style="border: 2px solid #eff2f5" data-kt-buttons="true"
                                        data-kt-buttons-target="[data-kt-button]">
                                        <label
                                            class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success border-0 rounded-pill {{ app()->currentLocale() == 'en' ? 'active' : '' }}"
                                            data-kt-button="true">
                                            <input class="btn-check" type="radio" name="table_language" value="en"
                                                @checked(app()->currentLocale() == 'en') />
                                            EN
                                        </label>
                                        <label
                                            class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success border-0 rounded-pill {{ app()->currentLocale() == 'ar' ? 'active' : '' }}"
                                            data-kt-button="true">
                                            <input class="btn-check" type="radio" name="table_language" value="ar"
                                                @checked(app()->currentLocale() == 'ar') />
                                            AR
                                        </label>
                                    </div>
                                    <!--end::Radio group-->
                                @endif
                            </div>
                        </div>

                        <div class="card-body py-3">

                            <div class="table-responsive">
                                <table id="kt_datatable_example_1" class="table table-row-bordered gy-3 gx-3">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 bg-light">

                                            @if (isset($data['table_data']['actions']['configs']['with_multi_delete']) &&
                                                    $data['table_data']['actions']['configs']['with_multi_delete'] == true)
                                                <th class="w-25px">
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input multiDeleteCheckbox" type="checkbox"
                                                            value="1" data-kt-check="true" {{-- {{ empty($models) ? 'disabled' : '' }} --}}
                                                            data-kt-check-target=".widget-13-check">
                                                    </div>
                                                </th>
                                            @endif

                                            @if (isset($data['table_data']['actions']['configs']['with_multi_delete']) &&
                                                    $data['table_data']['actions']['configs']['with_multi_delete'] == true)
                                                @foreach ($data['columns'] as $th)
                                                    @if (!$loop->first)
                                                        <th class="fw-bolder py-7 text-capitalize">{{ __($th['name']) }}
                                                        </th>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($data['columns'] as $th)
                                                    <th class="fw-bolder py-7 text-capitalize">{{ __($th['name']) }}
                                                    </th>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row py-9">
                                <div
                                    class="foot-left d-none d-md-block col-md-5 text-gray-600 d-flex align-items-center justify-content-center justify-content-md-start">
                                </div>
                                <div
                                    class="foot-right col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('style')
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cms/assets/js/common/css/datatable-styles.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

    <script>
        var resourceName = @json($data['resource_name']);
        var columns = @json($data['columns']);
        var filters = @json($data['table_data']['filters']);
        var route = @json($data['datatable_list_route']);
        // var route = "/dashboard/" + resourceName + "/" + resourceName + "-datatable/list";
        var noDataImage = "{{ asset('cms/assets/media/illustrations/sigma-1/15.png') }}";
    </script>

    <script src="{{ asset('cms/assets/js/common/performActions/perform-datatable.js') }}"></script>
    <script src="{{ asset('cms/assets/js/common/performActions/perform-index.js') }}"></script>
@endpush
