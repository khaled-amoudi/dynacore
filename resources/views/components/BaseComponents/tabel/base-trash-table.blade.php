@props([
    'tabel_data' => [],
    'ths' => [],
    'model',
    'models',
    'fillable_images' => [],
    'fillables' => [],
    'fillable_badges' => [],
    'fillable_switch' => [],
    'fillable_badge_values' => [],
    'fillable_badges_array',
    'actions' => [],
    'export_excel',
    'export_excel_demo',
    'export_pdf',
    'import_excel',
    'text_filters',
    'select_fixed_filters',
])
<div id="kt_content" class="content pt-0">
    <div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
        <div class="container-fluid" id="kt_docs_content_container">

            <div class="filters">
                <div class="ms-auto position-relative">
                    <form action="{{ URL::current() }}" method="get">
                        <div class="row">
                            {{-- <x-BaseComponents.tabel.tabel_partials.filters
                            :text_filters="[ ['name' => 'description', 'label' => 'filter by description', 'cols' => 4] ]" /> --}}
                            @include('components.BaseComponents.tabel.tabel_partials.filters')
                        </div>
                        {{-- Hidden Submit Button --}}
                        <button class="btn btn-sm btn-dark d-none" type="submit">Filter</button>
                    </form>
                </div>
            </div>


            <div class="col-xl-12">
                <!--begin::Tables Widget 9-->
                <div class="card shadow-sm mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header pt-5 pb-3">
                        <h3 class="card-title align-items-start flex-column">
                            <span
                                class="card-label fw-bold text-gray-700 fs-3 mb-1">{{ ucwords($tabel_data['table_title']) }}</span>
                            {{-- <span class="text-muted mt-1 fw-bold fs-7">total: 1 Categories</span> --}}
                        </h3>
                        {{-- @include('components.BaseComponents.tabel.tabel_partials.export_import') --}}
                        <div class="card-toolbar">

                            @if (!isset($actions['route_force_delete']))
                                {{-- @can('create ' . $tabel_data['permission_key']) --}}
                                {{-- <a href="{{ route($tabel_data['table_button_route']) }}" type="button"
                                            class="btn btn-sm btn-primary shadow px-3 ms-1">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </span>
                                            Add New
                                        </a> --}}

                                @if (isset($tabel_data['create_modal']) && $tabel_data['create_modal'] == true)
                                    @include($tabel_data['table_button_create'])
                                @else
                                    {{-- http://base_livewire.test/dashboard/category/create --}}
                                    <a href="{{ route($tabel_data['table_button_create']) }}" navigate=""
                                        class="btn btn-sm btn-primary">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                                    height="2" rx="1" transform="rotate(-90 11.364 20.364)"
                                                    fill="black"></rect>
                                                <rect x="4.36396" y="11.364" width="16" height="2"
                                                    rx="1" fill="black"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Add New</a>
                                @endif

                                {{-- @endcan --}}
                            @else
                                <a href="{{ url()->previous() }}" class="btn btn-cancel shadow-sm px-2 ms-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-arrow-left">
                                        <line x1="19" y1="12" x2="5" y2="12">
                                        </line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                    <span>Cancel</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-striped table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 bg-light">
                                        @isset($ths)
                                            @foreach ($ths as $th)
                                                @if ($th == '#')
                                                    <th class="ps-4">{{ $th }}</th>
                                                @elseif ($th == 'Actions')
                                                    <th class="text-end rounded-end">{{ $th }}</th>
                                                @else
                                                    <th scope="col">{{ $th }}</th>
                                                @endif
                                            @endforeach
                                        @endisset
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    @forelse ($models as $data)
                                        <tr class="del_{{ $data['id'] }} {{ $loop->odd ? 'bg-accent' : '' }}">
                                            {{-- <td>{{ $loop->index+1 }}</td> --}}
                                            {{-- @if (isset($actions['with_delete_group']))
                                                        <td>
                                                            <div class="form-check m-0">
                                                                <input class="form-check-input chechfordelete" name="deletegroup[]"
                                                                    type="checkbox" value="{{ $data['id'] }}">
                                                            </div>
                                                        </td>
                                                    @endif --}}
                                            <td class="ps-4 align-middle">{{ $data['id'] }}</td>

                                            {{-- IMAGES --}}
                                            @isset($fillable_images)
                                                @foreach ($fillable_images as $image)
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-45px">
                                                                <img src="{{ $data['image'] }}"
                                                                    class="product-img-2 border-0" alt="image">
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            @endisset

                                            {{-- NORMAL DATA WITHOUT ADDITIONALS --}}
                                            @isset($fillables)
                                                @foreach ($fillables as $fillable)
                                                    <td class="td-max-words align-middle">{{ $data[$fillable] }}</td>
                                                    {{-- overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 150px; --}}
                                                @endforeach
                                            @endisset


                                            {{-- Switcher --}}
                                            @isset($fillable_switch)
                                                @foreach ($fillable_switch as $switch)
                                                    <td class="align-middle">
                                                        <div
                                                            class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                                            <input name="{{ $switch }}"
                                                                onclick="editableSwitch({{ $data['id'] }})"
                                                                class="editable-switch form-check-input h-40px w-60px"
                                                                type="checkbox" id="{{ $switch . '_' . $data['id'] }}"
                                                                @checked($data[$switch] == 1) />
                                                            <label class="form-check-label"
                                                                for="{{ $switch }}"></label>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            @endisset

                                            {{-- BADGES or TAGS --}}
                                            @isset($fillable_badges)
                                                @foreach ($fillable_badges as $badge_attr => $badge_data)
                                                    <td class="align-middle">
                                                        @foreach ($badge_data as $key => $value)
                                                            @if ($data[$badge_attr] == $key)
                                                                <span
                                                                    class="badge py-1 px-2 rounded-pill {{ $value[1] }}"
                                                                    style="font-size: 12px; font-weight: 500;">
                                                                    {{ $value[0] }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                @endforeach
                                            @endisset

                                            @isset($fillable_badges_array)
                                                @foreach ($fillable_badges_array as $fillable_array)
                                                    <td class="align-middle">
                                                        @foreach ($data[$fillable_array] as $badge)
                                                            <span class="badge py-1 px-2 alert-primary"
                                                                style="font-size: 12px; font-weight: 500;">{{ $badge }}</span>
                                                        @endforeach
                                                    </td>
                                                @endforeach
                                            @endisset
                                            <td>
                                                <div class="d-flex justify-content-end flex-shrink-0">

                                                    @if (isset($actions['route_show']) && (!isset($actions['show_modal']) || $actions['show_modal'] != true))
                                                        {{-- @if (isset($actions['route_show'])) --}}
                                                        {{-- @can('show ' . $tabel_data['permission_key']) --}}
                                                        <a href="{{ route($actions['route_show'], $data['id']) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="" data-bs-original-title="Views"
                                                            aria-label="Views"><i
                                                                class="{{ $actions['icon_class_show'] }}"></i></a>
                                                        {{-- @endcan --}}
                                                    @elseif (isset($actions['show_modal']) && $actions['show_modal'] == true)
                                                        {{-- @can('show ' . $tabel_data['permission_key']) --}}
                                                        @include('dashboard.tag.show', [
                                                            'data_id' => $data['id'],
                                                        ])
                                                        {{-- @endcan --}}
                                                    @endif

                                                    @if (isset($actions['route_edit']))
                                                        {{-- @can('edit ' . $tabel_data['permission_key']) --}}
                                                        @if (isset($actions['edit_modal']) && $actions['edit_modal'] == true)
                                                            @include('dashboard.tag.edit', $data)
                                                        @else
                                                            <a href="{{ route($actions['route_edit'], $data['id']) }}"
                                                                navigate=""
                                                                class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1"
                                                                title="update">
                                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none">
                                                                        <path opacity="0.3" fill-rule="evenodd"
                                                                            clip-rule="evenodd"
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
                                                                <!--end::Svg Icon-->
                                                            </a>
                                                        @endif
                                                        {{-- @endcan --}}
                                                    @endif

                                                    @if (isset($actions['route_destroy']))
                                                        {{-- @can('delete ' . $tabel_data['permission_key']) --}}
                                                        @include('components.BaseComponents.tabel.tabel_partials.delete_btn')
                                                        {{-- @endcan --}}
                                                    @endif


                                                    @if (isset($actions['route_restore']))
                                                        <form
                                                            action="{{ route($actions['route_restore'], $data['id']) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-icon btn-bg-light btn-sm"
                                                                data-bs-original-title="Re-store"
                                                                aria-label="Re-store">
                                                                <i class="fa-solid fa-trash-can-arrow-up text-muted"></i></button>
                                                        </form>
                                                    @endif
                                                    @if (isset($actions['route_force_delete']))
                                                        {{-- @can('delete ' . $tabel_data['permission_key']) --}}
                                                        @include('components.BaseComponents.tabel.tabel_partials.force_delete_btn')
                                                        {{-- @endcan --}}
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- <td>
                                                <div class="d-flex justify-content-end flex-shrink-0">
                                                    <a href="{{ route($tabel_data['table_button_edit'], $data['id']) }}"
                                                        navigate=""
                                                        class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1"
                                                        title="update">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3" fill-rule="evenodd"
                                                                    clip-rule="evenodd"
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
                                                        <!--end::Svg Icon-->
                                                    </a>
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
                                                                    <p><span
                                                                            class="badge badge-light-danger">NOTE:</span>
                                                                        You
                                                                        will not be able to restore this record
                                                                        after deleting
                                                                        it.</p>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <form
                                                                        action="{{ route($tabel_data['table_button_delete'], $data['id']) }}"
                                                                        method="POST" class="d-inline-block">
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
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($ths) }}">
                                                @if (isset($actions['route_force_delete']))
                                                    <div class="text-gray-700 fw-bold pt-3 text-center">
                                                        <img class="w-25 h-25"
                                                            src="{{ asset('cms/assets/images/trash-2.svg') }}"
                                                            alt="">
                                                        <div class="my-3 fw-normal">It seems like we could not
                                                            find any data to
                                                            show
                                                            here</div>
                                                    </div>
                                                @else
                                                    <div class="text-gray-700 fw-bold pt-3 text-center">
                                                        <img class="w-25 h-25"
                                                            src="{{ asset('cms/assets/media/no-data-1.svg') }}"
                                                            alt="">
                                                        <div class="my-3 fw-normal">It seems like we could not
                                                            find any data to
                                                            show
                                                            here</div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>

                                    @endforelse
                                    <!-- _ENDBLOCK_ -->
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                            <div class="d-flex justify-content-end my-5">
                                <!-- _BLOCK_ --> <!-- _ENDBLOCK_ -->


                                {{-- {{ $models['paginator']->links() }} --}}
                                {{ $model->withQueryString()->links() }}
                                {{-- page {{ $models->currentPage() }} of {{ $models->count() }} --}}
                            </div>
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->
                </div>
                <!--end::Tables Widget 9-->
            </div>
        </div>
    </div>
</div>

{{-- Docs
    Author: khaled - 16/09/2022
_____________________________________________________________________________________
    'tabel_data' => [],
    'ths' => [],
    'models' => [],
    'fillable_images' => [],
    'fillables' => [],
    'fillable_badges' => [],
    'fillable_badge_values' => [],
    'actions' => [],

    * tabel_data => array contain some of fixed data in the tabel ex: crete button text, tabel title, ..
    * ths => array contain the list of <th> `s of the tabel
    * models => array came from the controller which is the data from DB to be show it in the tabel
    * fillable_images => columns from DB that are images
    * fillables => columns from DB that are normal models [text]
    * fillable_badges => columns from DB that are badges .e.g.[is_active, status, ..]
    * fillable_badge_values => cases of badges to customize .e.g.[active=>green. in active=>red, ..]


    Full EXAMPLE:-

        <x-BaseComponents.tabel.base-tabel
        :tabel_data="[
            'table_title' => 'Categories',
            'table_button_text' => 'Create Category',
            'table_button_route' => 'dashboard.categories.create']"

        :ths="['#', 'Image', 'Name', 'Parent ID', 'Description', 'Status', 'Actions']"

        :models="$models"
        :fillable_images="['image']"
        :fillables="['name', 'parent_id', 'description']"
        :fillable_badges="['status']"
        :fillable_badge_values="['active', 'archive', '', '']"
        :actions="[
            'route_show' => 'dashboard.categories.show',
            'icon_class_show' => 'bi bi-eye-fill text-primary',

            'route_edit' => 'dashboard.categories.edit',
            'icon_class_edit' => 'bi bi-pencil-fill text-warning',

            'route_destroy' => 'dashboard.categories.destroy',
            'icon_class_destroy' => 'bi bi-trash-fill text-danger',
        ]"
        :export_excel="['route_name'=>'dashboard.categories.exportExcel']"
        :export_pdf="['route_name'=>'#']"
        :import_excel="['route_name'=>'#']"

        :textFilter="['route' => 'dashboard.categories.index', 'name' => 'search', 'label' => 'filter by name, description']"
    />
_____________________________________________________________________________________ --}}
