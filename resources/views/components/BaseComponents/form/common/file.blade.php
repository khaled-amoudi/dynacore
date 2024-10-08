@props([
    'name',
    'value' => '',
    'path' => 'storage/',
    'label' => $name,
    'placeholder' => 'enter '. $name,
    'cols' => '6',
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
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label> @if($required)<small class="ms-2 fs-2 text-danger">&#42;</small>@endif
    <input name="{{ $name }}" type="file" id="{{ $name }}" {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ]) }} {{ $required ? 'required="required"' : '' }} {!! $others !!} {{ $attributes }}>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
    @isset($value)
        <div><img src="{{ asset($path . $value) }}" class="mt-2 rounded" width="50px" height="50px"
                alt="uploaded image"></div>
    @endisset
</div>

{{-- Docs
    Author: khaled - 31/08/2024
_____________________________________________________________________________________
    Full EXAMPLE:-
    [
        'formtype' => 'file',
        'name' => 'file',
        'path' => 'storage/',
        'label' => 'Uplaod File',
        'value' => $model['file'],
        'required' => 'required',
        'condition' => null,
        'cols' => '6',
    ],
_____________________________________________________________________________________
--}}
