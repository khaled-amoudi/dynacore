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
{{-- <script>
    let data = @json($data['form_data']);
    let saveAndCont = @json($saveAndCont);

    $(document).ready(function() {

        $(document).on('click', 'button[type="submit"]', function(event) {
            if (typeof saveAndCont !== 'undefined' && saveAndCont) {
                performStoreAndCont();
            } else {
                performStore();
            }
        });
    });
</script> --}}



{{-- @props([
    'btn_label' => 'modal label',
    'btn_class' => 'btn-dark',
    'modal_size',
    'unique_key' => '',
    'model',
    'title' => '',
])

<a href="#" type="button" class="btn {{ $btn_class }}" data-bs-toggle="modal"
    data-bs-target="#exampleModalAction{{ $unique_key }}" data-bs-original-title="Show" aria-label="Show">
    {{ $btn_label }}
</a>
<div class="modal fade" id="exampleModalAction{{ $unique_key }}" tabindex="-1"
    aria-labelledby="exampleModalActionLabel{{ $unique_key }}" style="display: none;" aria-hidden="true">
    <div class="modal-dialog {{ $modal_size }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalActionLabel{{ $unique_key }}">{{ $title }}</h5>
                <button type="button" class="btn-close bg-danger text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">

                {{ $slot }}

            </div>
        </div>
    </div>
</div> --}}


{{-- Docs
    Author: khaled - 15/11/2022
_____________________________________________________________________________________
    * unique_key => pass unique key when use modal more than one time in the page.
    * model => [نادر الإستخدام] the Model (table) of this item.
    * btn_label => button label label.
    * btn_class => classes for modal button.
    * title => Modal title in header.
    * modal_size => type of modal size {e.g. modal-lg, modal-xl, ..}.

    Full EXAMPLE:-
    <x-BaseComponents.form.common.modal :unique_key="$model->id" btn_label="button" btn_class="btn-info" modal_size="modal-fullscreen" />
_____________________________________________________________________________________
--}}
