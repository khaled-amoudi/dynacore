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
    <div class="row mx-5 mx-md-9 d-none" id="form_errors_alert">
        <div
            class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            <div class="d-flex flex-column pe-0 pe-sm-10" id="form_errors_validation_list">
                <span>The alert component can be used to highlight certain parts of your page for higher content
                    visibility.</span>
            </div>
            <button type="button" onclick="alert_closeAlert()"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto">
                <i class="bi bi-x fs-1 text-danger"></i>
            </button>
        </div>
    </div>

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

    <script src="{{ asset('cms/assets/js/common/performActions/perform-store.js') }}"></script>
    <script src="{{ asset('cms/assets/js/common/performActions/perform-modal-store.js') }}"></script>
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
                            $(this).find('select').select2();

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
    <script>
        $(document).ready(function() {
            // Select all elements with the data-get-ajax attribute
            $('select[data-get-ajax]').each(function() {
                var $select = $(this);
                var ajaxRoute = $select.data('get-ajax'); // Get the ajax route from data attribute
                var targetSelectId = $select.data('get-select'); // Get the target select ID
                var $targetElement = $('#' + targetSelectId); // Find the target element
                // Listen for changes on the select element
                $select.on('change', function() {
                    var selectedValue = $(this).val(); // Get the selected value

                    if (!selectedValue) {
                        $targetElement.empty();
                        $targetElement.val('');
                        return; // Stop further execution
                    }


                    // Send the AJAX request
                    $.ajax({
                        url: ajaxRoute, // The route from the data-get-ajax attribute
                        method: 'GET',
                        data: {
                            value: selectedValue
                        }, // Pass the selected value
                        success: function(response) {
                            // Check if the response is an array (for select options)
                            console.log(response);

                            if (typeof response === 'object' && !Array.isArray(
                                    response)) {
                                // Clear the current options in the target select
                                $targetElement.empty();

                                // Add a placeholder option if needed
                                // $targetElement.append(new Option('', ''));

                                // Populate the target select with new options from the response
                                $.each(response, function(key, value) {
                                    $targetElement.append(new Option(value,
                                        key));
                                });

                                // Trigger the change event for the target select to ensure any dependent functionality is activated
                                $targetElement.trigger('change');
                            } else {
                                // If the response is not an array, assume it's a single value for an input field
                                $targetElement.val(response);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            // Optionally, handle the error, e.g., show an alert
                        }
                    });
                });
            });
        });
    </script>
@endpush
