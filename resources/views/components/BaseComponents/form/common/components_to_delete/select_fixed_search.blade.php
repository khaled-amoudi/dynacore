@props(['name', 'model' => $model, 'options' => [], 'label' => $name, 'searchable' => true, 'cols' => '6', 'condition' => null])

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
    @if ($attributes->get('required') == true)
        <small class="ms-2 fs-2 text-danger">&#42;</small>
    @endif
    <select name="{{ $name }}" id="{{ $name }}" @class([
        'form-select',
        'form-select-solid',
        'is-invalid' => $errors->has($name),
    ])
        @if ($searchable == true) data-control="select2" data-placeholder="{{ __($label) }}" @else aria-label="Default select example" @endif
        {{ $attributes }}>
        <option value=""></option>
        @foreach ($options as $value => $option_label)
            <option value="{{ $value }}" @selected(old($name, $model[$name]) == $value)>{{ __($option_label) }}</option>
        @endforeach
    </select>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>



{{-- Docs
    Author: khaled - 04/04/2023
_____________________________________________________________________________________
    * name => input name, should be same as DB attr
    * model => the Model (table) of this item, we use it to show data when editing
    * label =>[OPTIONAL] input label
    * options => array of key=>value | the key is the value of the option,
                                    and the value is the label of this option

    Full EXAMPLE:-
    <x-BaseComponents.form.common.select_fixed_search name="name" :model="$model" label="category name"
    :options="[
        'fixed' => 'Fixed',
        'mobile' => 'Mobile'
    ]" />

    Less EXAMPLE:-
    <x-BaseComponents.form.common.select_fixed_search name="name" :model="$model"
    :options="[
        'fixed' => 'Fixed',
        'mobile' => 'Mobile'
    ]" />
_____________________________________________________________________________________
--}}
