@props([
    'name',
    'value' => '',
    'label' => $name,
    'placeholder' => 'enter ' . $name,
    'min_value' => '1',
    'max_value' => '10',
    'step_value' => '1',
    'prefix_value' => '$',
    'condition' => null,
    'cols' => '12',
    'required' => false,
    'others' => '',
])
@php
    // Parse the condition if provided
    $conditionId = $condition['id'] ?? null;
    $conditionValue = $condition['value'] ?? null;
@endphp
<div class="mb-7 col-12 col-sm-{{ $cols }} {{ $conditionId ? 'conditional-input' : '' }}"
    @if ($conditionId) data-condition-id="{{ $conditionId }}"
        data-condition-value="{{ $conditionValue }}"
        style="display: none;" @endif>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @if ($required)
            <small class="ms-2 fs-2 text-danger">&#42;</small>
        @endif
    <div class="input-group w-md-300px" data-kt-dialer="true" data-kt-dialer-min="{{ $min_value }}"
        data-kt-dialer-max="{{ $max_value }}" data-kt-dialer-step="{{ $step_value }}"
        data-kt-dialer-prefix="{{ $prefix_value }}">

        <!--begin::Decrease control-->
        <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="decrease">
            <i class="bi bi-dash fs-1"></i>
        </button>
        <!--end::Decrease control-->

        <!--begin::Input control-->
        <input type="text" name="{{ $name }}" id="{{ $name }}" class="form-control" readonly
            placeholder="{{ __($placeholder) }}" value="{{ $value ?? $min_value }}" {{ $required ? 'required="required"' : '' }} {!! $others !!} {{ $attributes }}
            data-kt-dialer-control="input" />
        <!--end::Input control-->

        <!--begin::Increase control-->
        <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="increase">
            <i class="bi bi-plus fs-1"></i>
        </button>
        <!--end::Increase control-->
    </div>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
{{-- Docs
    Author: khaled - 31/08/2024
_____________________________________________________________________________________
    Full EXAMPLE:-
    [
        'formtype' => 'increase_decrease',
        'name' => 'increase_decrease',
        'value' => '',
        'label' => 'increase_decrease label',
        'placeholder' => 'Amount',
        'min_value' => '1',
        'max_value' => '10',
        'step_value' => '1',
        'prefix_value' => '$',
        'condition' => null,
        'cols' => '6',
    ]

_____________________________________________________________________________________
--}}
