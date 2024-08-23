@extends('layouts.master')

@section('title')
    {{ __('common.' . config('app.name')) . ' | ' . __('create ' . $data['resource_name']) }}
@endsection

@section('toolbar')
    <x-BaseComponents.layout.breadcrumb :prev_pages="[
        'dashboard' => 'dashboard',
        $data['resource_name'] . ' list' => $data['route_index'],
    ]" :current_page="'create ' . $data['resource_name']" />
@endsection



@section('content')
    <div class="row mx-5 mx-md-9">
        <div class="card shadow-sm mb-5 mb-xl-8">
            <form id="create_form" action="{{ route('dashboard.' . $data['resource_name'] . '.store') }}"
                redirectto="{{ route('dashboard.' . $data['resource_name'] . '.index') }}" method="post"
                enctype="multipart/form-data">
                @csrf

                {{ $slot }}

            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let data = @json($data['form_data']);
        let saveAndCont = @json($saveAndCont);
    </script>
    <script>
        $(document).ready(function() {

            $(document).on('click', 'button[type="submit"]', function(event) {
                if (typeof saveAndCont !== 'undefined' && saveAndCont) {
                    performStoreAndCont();
                } else {
                    performStore();
                }
            });


            $(window).scroll(function() {
                const button = $('.kh_breadcrumb_move');
                const formToolbar = $('.card-toolbar');
                const breadcrumbToolbar = $('.card-toolbar-actions');

                if ($(window).scrollTop() > 100) {
                    breadcrumbToolbar.append(button);
                } else {
                    formToolbar.append(button);
                }
            });
        });
    </script>

    <script src="{{ asset('cms/assets/js/common/performActions/perform-store.js') }}"></script>
    <script src="{{ asset('cms/assets/js/common/js/form.js') }}"></script>
@endpush
