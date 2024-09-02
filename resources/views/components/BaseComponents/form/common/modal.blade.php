{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $resource }}">
    {{ __('create ' . $resource) }}
</button> --}}
@props([
    'resource',
    'action',
    'formData',
    'formInputs',
    'name',
    'ajax_for_new_options'
])
<div class="modal fade" id="{{ $resource }}" tabindex="-1" aria-labelledby="{{ $resource }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $resource }}Label">{{ __('create ' . $resource) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row mx-5 mx-md-9 d-none" id="modal_form_errors_alert">
                <div
                    class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                    <div class="d-flex flex-column pe-0 pe-sm-10" id="modal_form_errors_validation_list">
                        <span>The alert component can be used to highlight certain parts of your page for higher content
                            visibility.</span>
                    </div>
                    <button type="button" onclick="modal_alert_closeAlert()"
                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto">
                        <i class="bi bi-x fs-1 text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">

                <div class="form" id="modal_create_form_{{ $resource }}" action="{{ $action }}"
                    formData={{ json_encode($formData) }}>

                    <x-BaseComponents.layout.crud.formBuilder :formInputs="$formInputs" />

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary"
                    id="submit_modal_create_form_{{ $resource }}">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let modal_resource = @json($resource);
        let ajax_for_new_options = @json($ajax_for_new_options);
        let name = @json($name);
        document.getElementById('submit_modal_create_form_' + modal_resource).addEventListener('click', function(
            event) {
            performModalStore(modal_resource, ajax_for_new_options, name);
        });
    });
</script>
{{-- Docs
    Author: khaled - 31/08/2024
_____________________________________________________________________________________
    Full EXAMPLE:-
    // you can use it inside a "select" component
    'add' => [
        'action' => route('dashboard.category.store'),
        'resource' => 'category',
        'ajax_for_new_options' => route('dashboard.ajax.get_category_select'),
        'formInputs' => app(CategoryController::class)->createFormBuilder(new Category()),
        'formData' => app(CategoryController::class)->formData(new Category()),
    ],
_____________________________________________________________________________________
--}}

