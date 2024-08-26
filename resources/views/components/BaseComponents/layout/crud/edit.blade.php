@extends('layouts.master')


@section('title')
    {{ __('common.' . config('app.name')) . ' | ' . __('edit ' . $data['resource_name']) }}
@endsection


@section('toolbar')
    <x-BaseComponents.layout.breadcrumb :prev_pages="[
        'dashboard' => 'dashboard',
        $data['resource_name'] . ' list' => $data['route_index'],
    ]" :current_page="'edit ' . $data['resource_name']" />
@endsection



@section('content')
    <div class="row mx-5 mx-md-9">
        <div class="card shadow-sm mb-5 mb-xl-8">
            <form id="update_form" action="{{ route('dashboard.' . $data['resource_name'] . '.update', $model['id']) }}"
                method="post" redirectto="{{ route('dashboard.' . $data['resource_name'] . '.index') }}"
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
        let model_id = @json($model['id']);
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', 'button[type="submit"]', function(event) {
                performUpdate(model_id)
            });


            $(window).scroll(function() {
                const button = $('.kh_breadcrumb_move');
                const formToolbar = $('.kh_form-card-toolbar');
                const breadcrumbToolbar = $('.card-toolbar-actions');

                if ($(window).scrollTop() > 100) {
                    breadcrumbToolbar.append(button);
                } else {
                    formToolbar.append(button);
                }
            });
        });
    </script>

    <script src="{{ asset('cms/assets/js/common/performActions/perform-update.js') }}"></script>
    <script src="{{ asset('cms/assets/js/common/js/form.js') }}"></script>
    <script src="{{ asset('cms/assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.kh_repeater').each(function() {
                var repeater_id = $(this).attr('id');
                $('#' + repeater_id).repeater({
                    initEmpty: false,
                    // defaultValues: {
                    //     'text-input': 'foo'
                    // },
                    show: function() {
                        $(this).show(function() {
                            // Re-init select2
                            $(this).find('select').next('.select2-container').remove();
                            $(this).find('select').select2({
                                dropdownAutoWidth: true
                            });

                            $(this).find('input.daterangepicker').daterangepicker();

                            // new Tagify(this.querySelector('.tagify'));
                        });
                    },
                    hide: function(deleteElement) {
                        $(this).hide(deleteElement);
                    },
                    // isFirstItemUndeletable: true
                });
            });
        });
    </script>
@endpush
