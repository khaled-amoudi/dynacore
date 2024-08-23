@props([
    'prev_pages' => null,
    'current_page' => '',
])

<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __('common.' . config('app.name')) }}
            </h1>

            <span class="h-20px border-gray-300 border-start mx-4"></span>

            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen001.svg-->
                <span class="svg-icon svg-icon-5 me-1"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z"
                            fill="black" />
                    </svg></span>
                <!--end::Svg Icon-->
                @isset($prev_pages)
                    @foreach ($prev_pages as $label => $route_name)
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route($route_name) }}" class="text-muted text-hover-primary">{{ __($label) }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                    @endforeach
                @endisset

                <li class="breadcrumb-item text-dark">{{ __($current_page) }}</li>
            </ul>
        </div>
        <div class="me-12 d-none d-md-block card-toolbar-actions">
        </div>
    </div>
</div>
