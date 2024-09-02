@props(['name', 'value' => '', 'path' => 'storage/', 'label' => $name, 'cols' => '6', 'condition' => null,     'required' => false,
    'others' => '',])
@php
    // Parse the condition if provided
    $conditionId = $condition['id'] ?? null;
    $conditionValue = $condition['value'] ?? null;
@endphp
<div class="mb-7 col-12 col-sm-{{ $cols }} {{ $conditionId ? 'conditional-input' : '' }}"
    @if ($conditionId) data-condition-id="{{ $conditionId }}"
        data-condition-value="{{ $conditionValue }}"
        style="display: none;" @endif>
    <!--begin::Image input-->
    <div>
        <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
        @if ($required)
            <small class="ms-2 fs-2 text-danger">&#42;</small>
        @endif
    </div>
    <div class="image-input image-input-circle" data-kt-image-input="true"
        style="background-image: url({{ asset('cms/assets/media/custom/default_no-image-available-1.png') }})">
        <!--begin::Image preview wrapper-->
        <div class="image-input-wrapper w-125px h-125px"
            style="background-image: url({{ $value != '' ? $value : asset('cms/assets/media/custom/default_no-image-available-1.png') }})">
        </div>

        <!--begin::Edit button-->
        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
            data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
            title="{{ __('common.Change avatar') }}">
            <i class="bi bi-pencil-fill fs-7"></i>

            <!--begin::Inputs-->
            <input type="file" id="{{ $name }}" name="{{ $name }}" accept=".png, .jpg, .jpeg"
                {{ $attributes }} {{ $required ? 'required="required"' : '' }} {!! $others !!}
                {{ $attributes->class([
                    'is-invalid' => $errors->has($name),
                ]) }}
                {{ $attributes->has('required') == true ? 'required' : '' }} >
            {{-- <input type="hidden" name="avatar_remove" /> --}}
            <!--end::Inputs-->
        </label>
        @error($name)
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <!--end::Edit button-->

        <!--begin::Cancel button-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
            title="{{ __('common.Cancel avatar') }}">
            <i class="bi bi-x fs-2"></i>
        </span>
        <!--end::Cancel button-->

        <!--begin::Remove button-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
            data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
            title="{{ __('common.Remove avatar') }}">
            <i class="bi bi-x fs-2"></i>
        </span>
        <!--end::Remove button-->
    </div>
    <!--end::Image input-->
</div>
{{-- Docs
    Author: khaled - 31/08/2024
_____________________________________________________________________________________
    Full EXAMPLE:-
    [
        'formtype' => 'image',
        'name' => 'image',
        'path' => 'storage/',
        'label' => 'image upload',
        'value' => '',
        'required' => 'required',
        'condition' => null,
        'cols' => '6',
    ],

_____________________________________________________________________________________
--}}
