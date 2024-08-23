@props([
    'name',
    'value' => '',
    'path' => 'storage/',
    'label' => $name,
    'placeholder' => 'enter '. $name,
    'cols' => '6',
    'condition' => null,

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
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label> @if($attributes->get('required') == true)<small class="ms-2 fs-2 text-danger">&#42;</small>@endif
    <input name="{{ $name }}" multiple type="file" id="{{ $name }}" accept=".png, .jpg, .jpeg" {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ]) }} {{ $attributes }}>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
    {{-- @isset($model[$name])
        <div><img src="{{ $model[$name] }}" class="mt-2 rounded" width="50px" height="50px"
                alt="uploaded image"></div>
    @endisset --}}
</div>



{{--Docs
    Author: khaled - 15/09/2022
_____________________________________________________________________________________
    * name => input name, should be same as DB attr.
    * model => the Model (table) of this item, we use it to show data when editing.
    * path => the folder path to store the uploaded images.
    * label =>[OPTIONAL] input label.
    * placeholder =>[OPTIONAL] input placehoder.

    Full EXAMPLE:-
    <x-BaseComponents.form.common.image name="image" :model="$category" path="storage/" label="category name" placeholder="Enter category name" />

    Less EXAMPLE:-
    <x-BaseComponents.form.common.image name="image" :model="$category" />
_____________________________________________________________________________________
--}}
