@props([
    'name',
    'id' => 'editor',
    'value' => '',
    'label' => $name,
    'placeholder' => 'enter ' . $name,
    'rows' => '2',
    'cols' => '12',
    'condition' => null,
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
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
    @if ($required)
        <small class="ms-2 fs-2 text-danger">&#42;</small>
    @endif
    {{-- <div id="{{ $name }}"></div> --}}
    <textarea class="form-control mb-4" id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
        placeholder="{{ __($placeholder) }}" {{ $required ? 'required="required"' : '' }} {!! $others !!} {{ $attributes }}>{{ old($name, $value ?? '') }}</textarea>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
{{-- Docs
    Author: khaled - 31/08/2024
_____________________________________________________________________________________
    Full EXAMPLE:-
    [
        'formtype' => 'textarea',
        'name' => 'descripe',
        'id' => 'descripe',
        'label' => 'descripe',
        'placeholder' => 'enter descripe',
        'value' => $model['descripe'],
        'required' => 'required',
        'condition' => null, //['id' => 'is_active', 'value' => 'true'],
        'rows' => '3',
        'cols' => '12'
    ],
_____________________________________________________________________________________
--}}
