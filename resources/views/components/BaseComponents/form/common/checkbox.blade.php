@props([
    'name',
    'value' => '',
    'options' => [],
    'label' => $name,
    'display' => 'inline',
    'cols' => '12',
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
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
    @if ($attributes->get('required') == true)
        <small class="ms-2 fs-2 text-danger">&#42;</small>
    @endif
    <div class="{{ $display == 'inline' ? 'd-flex' : '' }}">
        @foreach ($options as $key => $label)
            <div
                class="{{ $display == 'inline' ? 'ms-8' : '' }} mb-3 form-check form-check-custom form-check-solid form-check-{{ $display }}">
                <input class="form-check-input" name="{{ $name . '[]' }}" type="checkbox" id="{{ $name . '_' . $key }}"
                    value="{{ $key }}" @checked(old($name, $value) == $key) {{ $attributes }}>
                <label class="form-check-label" for="{{ $name . '_' . $key }}">{{ __($label) }}</label>
            </div>
        @endforeach
    </div>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- Docs
    Author: khaled - 16/09/2022
_____________________________________________________________________________________
    * name => input name, should be same as DB attr
    * model => the Model (table) of this item, we use it to show data when editing
    * label =>[OPTIONAL] input label
    * options => array of values that need to be set as options in the checkboxes or radios [default = the current model]
    * option_value_column => column of DB that need to be the value of this option [default = id]
    * option_label_column => the label to show of this option [ default = name ]
    * type => type on input [ checkbox OR radio ]


    Full EXAMPLE:-
    <x-BaseComponents.form.common.checkbox_radio_dynamic name="status" :model="$category" type="checkbox" label="category status"
    :options="$parents" option_value_column="id" option_label_column="name" display="col" />

    Less EXAMPLE:-
    <x-BaseComponents.form.common.checkbox_radio_dynamic name="status" :model="$category"
    :options="$parents" />
_____________________________________________________________________________________
--}}
