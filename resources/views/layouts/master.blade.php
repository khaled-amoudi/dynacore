<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ $locale_ar ? 'rtl' : 'ltr' }}" direction="{{ $locale_ar ? 'rtl' : 'ltr' }}"
    style="direction: {{ $locale_ar ? 'rtl' : 'ltr' }};">
<!--begin::Head-->

<head>
    <base href="">
    <title>@yield('title', config('app.name'))</title>
    <meta charset="utf-8" />
    <meta name="description" content="{{ config('app.name') }} | Admin Panel" />
    <meta name="keywords" content="{{ config('app.name') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ config('app.name') }}" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="{{ asset('cms/assets/media/custom/logos/dynacore-single.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @if (!$locale_ar)
        <link href="{{ asset('cms/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('cms/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    @else
        <link href="{{ asset('cms/assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('cms/assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap"
            rel="stylesheet">
    @endif
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('cms/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cms/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cms/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <!--end::Page Vendor Stylesheets-->
    {{-- Font Awsome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- End --}}
    @stack('style')

    <style>
        :root {
            --font-family-ar: 'Almarai', sans-serif;
        }

        /* Apply Alexandrea for Arabic */
        body:lang(ar) {
            font-family: var(--font-family-ar) !important;
        }


        .table-row-deleted {
            transition: opacity 0.5s ease-in-out;
            /* Apply transition to opacity property */
        }

        .btn.shadow,
        .btn.exportingBtn {
            transition: all 0.3s ease 0s;
        }

        .btn.shadow:hover,
        .btn.exportingBtn:hover {
            transition: "box-shadow" .3s ease-in-out;
            box-shadow: 0px 9px 16px 0px rgba(19, 53, 95, 40%) !important;
        }

        input:focus,
        textarea:focus,
        select:focus {
            transition: "box-shadow" .3s ease-in-out;
            box-shadow: 0px 9px 16px 0px rgba(182, 182, 182, 0.18) !important;
            /* border-color: #009ef7 !important; */
        }

        /* form-check-input
        form-select
        form-control */
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">

        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">

            <!--begin::Aside-->
            <x-BaseComponents.layout.sidebar />
            <!--end::Aside-->


            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">


                @include('layouts.partials.header')


                <!--begin::Content-->
                <div id="kt_content" class="content">
                    <div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
                        <div class="container-fluid px-0" id="kt_docs_content_container">
                            @yield('toolbar')

                            @yield('content')
                        </div>
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->



    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('cms/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('cms/assets/js/scripts.bundle.js') }}"></script>

    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->

    <script src="{{ asset('cms/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('cms/assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

    <script src="{{ asset('cms/assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset('cms/assets/js/custom/documentation/search.js') }}"></script>
    {{-- <script src="{{ asset('cms/assets/js/custom/documentation/base/indicator.js') }}"></script> --}}

    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('cms/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('cms/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('cms/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('cms/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('cms/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('cms/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"
        integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--end::Page Custom Javascript-->

    <!--end::Javascript-->
    {{-- <x-BaseComponents.alert.alert type="success" />
    <x-BaseComponents.alert.alert type="fail" /> --}}


    <script src="{{ asset('cms/assets/js/common/js/kh_general.js') }}"></script>
    <script src="{{ asset('cms/assets/js/axios.min.js') }}"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    </script>
    <script src="{{ asset('cms/assets/js/common/axios-actions.js') }}"></script>
    <script src="{{ asset('cms/assets/js/common/axios-spa-actions.js') }}"></script>

    @stack('script')



</body>
<!--end::Body-->

</html>
