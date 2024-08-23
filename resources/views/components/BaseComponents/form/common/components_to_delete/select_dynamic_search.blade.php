@props([
    'name',
    'model' => $model,
    'options' => $model,
    'default_option' => false, // 'default_option' => 'default',
    'option_value_column' => 'id',
    'option_label_column' => 'name',
    'label' => $name,
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
    <select name="{{ $name }}" id="{{ $name }}" data-control="select2" @class(['form-select' , 'form-select-solid' , 'is-invalid' => $errors->has($name)])
        data-placeholder=".:: {{ __($default_option ?? $label) }} ::." {{ $attributes }} >
        @if ($default_option)
            <option value="">.::{{ __($default_option) }}::.</option>
        @endisset

        @foreach ($options as $option)
            <option value="{{ $option[$option_value_column] }}">
                {{ __($option[$option_label_column]) }}</option>
        @endforeach
</select>


{{-- check if $name as string ends with []
        , then make a loop on the $model[$name] to show the data in badges under the select --}}
@if (str_ends_with($name, '[]'))
    <div class="d-flex flex-wrap gap-1 mt-1">
        @foreach ($model[rtrim($name, '[]')] as $value)
            <span class="badge py-1 px-2 alert-primary"
                style="font-size: 12px; font-weight: 500;">{{ $value }}</span>
        @endforeach
    </div>
@endif

@error($name)
    <small class="text-danger">{{ $message }}</small>
@enderror

</div>



{{-- Docs
    Author: khaled - 15/09/2022
_____________________________________________________________________________________
    * name => input name, should be same as DB attr
    * model => the Model (table) of this item, we use it to show data when editing
    * label =>[OPTIONAL] input label
    * options => array of values that need to be set as options in the select
    * default_option =>[OPTIONAL] the first option in the select [does not have a value]
    * option_value_column => column of DB that need to be the value of this option [default = id]
    * option_label_column => the label to show of this option [ default = name ]


    Full EXAMPLE:-
        <x-BaseComponents.form.common.select_dynamic_search name="parent_id" :model="$category" label="Parent ID"
        :options="$parents" default_option="Primary Category" option_value_column="id" option_label_column="name" />

    Less EXAMPLE:-
        <x-BaseComponents.form.common.select_dynamic_search name="parent_id" :model="$category"
        :options="$parents" option_value_column="id" option_label_column="name" />
_____________________________________________________________________________________
--}}
