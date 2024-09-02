@props([
    'name' => 'is_active',
    'value' => '',
    'label' => 'is_active',
    'condition' => null,
    'required' => false,
    'others' => '',
])
@php
    $conditionId = $condition['id'] ?? null;
    $conditionValue = $condition['value'] ?? null;
@endphp
<div class="col-12 col-md-6 mb-7 {{ $conditionId ? 'conditional-input' : '' }}"
    @if ($conditionId) data-condition-id="{{ $conditionId }}"
    data-condition-value="{{ $conditionValue }}"
    style="display: none;" @endif>
    <label class="form-label">{{ __($label) }}</label> @if($required)<small class="ms-2 fs-2 text-danger">&#42;</small>@endif
    <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
        <input name="{{ $name }}" id="{{ $name }}" value="on" class="form-check-input h-40px w-60px"
            type="checkbox" @checked($value == 1) {{ $required ? 'required="required"' : '' }} {!! $others !!} {{ $attributes }} />
        <label class="form-check-label" for="{{ $name }}"></label>
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
        'formtype' => 'switch',
        'name' => 'activation',
        'id' => 'activation',
        'label' => 'activation',
        'placeholder' => 'activation',
        'model' => $model,
        'required' => 'required',
        'condition' => null,
        'cols' => '6'
    ],


_____________________________________________________________________________________
--}}
