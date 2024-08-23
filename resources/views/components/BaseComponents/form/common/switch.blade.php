@props([
    'name' => 'is_active',
    'value' => '',
    'label' => 'is_active',
    'condition' => null,
])
@php
    $conditionId = $condition['id'] ?? null;
    $conditionValue = $condition['value'] ?? null;
@endphp
<div class="col-12 col-md-6 mb-7 {{ $conditionId ? 'conditional-input' : '' }}"
    @if ($conditionId) data-condition-id="{{ $conditionId }}"
    data-condition-value="{{ $conditionValue }}"
    style="display: none;" @endif>
    <label class="form-label">{{ __($label) }}</label> @if($attributes->get('required') == true)<small class="ms-2 fs-2 text-danger">&#42;</small>@endif
    <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
        <input name="{{ $name }}" id="{{ $name }}" value="on" class="form-check-input h-40px w-60px"
            type="checkbox" @checked($value == 1) {{ $attributes }} />
        <label class="form-check-label" for="{{ $name }}"></label>
    </div>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>



{{--
USE:
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

--}}

{{-- Docs
    Author: khaled - 16/09/2022
_____________________________________________________________________________________
    * name => input name, should be same as DB attr
    * model => the Model (table) of this item, we use it to show data when editing
    * label =>[OPTIONAL] input label

    Full EXAMPLE:-
    <x-BaseComponents.form.common.switch name="is_active" :model="$model" label="Is Active" />

_____________________________________________________________________________________ --}}
