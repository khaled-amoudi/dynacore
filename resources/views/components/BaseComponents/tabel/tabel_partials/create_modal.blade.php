@props([
    'btn_label' => 'modal label',
    'btn_class' => 'btn-dark',
    'modal_size' => 'modal-xl',
    'unique_key' => '',
    'model',
    'title' => '',
])



<a href="#" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalAction{{ $unique_key }}"
    data-bs-original-title="{{ $unique_key }}" aria-label="{{ $unique_key }}" class="btn btn-sm btn-primary shadow px-3 ms-1 {{ $btn_class }}">
    <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-plus">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
    </span>
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


<x-BaseComponents.tabel.tabel_partials.create_modal unique_key="CreateTag" btn_label="Add New" btn_class="btn-primary" title="Create Tag" modal_size="modal-xl">
    <form action="{{ route('dashboard.tag.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('dashboard.tag._form_tag')

        <x-BaseComponents.form.common.submit_button />

    </form>

</x-BaseComponents.tabel.tabel_partials.create_modal>

_____________________________________________________________________________________
--}}
