@props([
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
</div>


{{--Docs
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
