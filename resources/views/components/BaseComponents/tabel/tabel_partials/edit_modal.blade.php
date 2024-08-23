@props([
    'model',
    'unique_key',
    'icon_class' => 'bi bi-pencil-fill',
    'title' => '',
    'modal_size' => 'modal-xl',
])

<a href="#" type="button" class="btn btn-sm text-warning p-0 m-0" data-bs-toggle="modal"
    data-bs-target="#exampleModalAction{{ $unique_key }}edit" data-bs-original-title="Edit" aria-label="Edit">
    <i class="{{ $icon_class }}"></i>
</a>
<div class="modal fade" id="exampleModalAction{{ $unique_key }}edit" tabindex="-1"
    aria-labelledby="exampleModalActionLabel{{ $unique_key }}edit" style="display: none;" aria-hidden="true">
    <div class="modal-dialog {{ $modal_size }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalActionLabel{{ $unique_key }}edit">{{ $title }}</h5>
                <button type="button" class="btn-close bg-danger text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="row p-3">

                    {{ $slot }}

                </div>
            </div>
        </div>
    </div>
</div>






{{--Docs
    Author: khaled - 15/11/2022
_____________________________________________________________________________________
<x-BaseComponents.tabel.tabel_partials.edit_modal unique_key="{{ $data['id'] }}" title="Edit Tag">
    <form action="{{ route('dashboard.tag.update', $data['id']) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.tag._form_tag')

        <x-BaseComponents.form.common.submit_button />
    </form>

</x-BaseComponents.tabel.tabel_partials.edit_modal>
_____________________________________________________________________________________
--}}

