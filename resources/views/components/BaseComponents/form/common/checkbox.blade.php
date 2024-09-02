@props([
    'name',
    'value' => '',
    'options' => [],
    'label' => $name,
    'display' => 'inline',
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
    <div class="{{ $display == 'inline' ? 'd-flex' : '' }}">
        @foreach ($options as $key => $label)
            <div
                class="{{ $display == 'inline' ? 'ms-8' : '' }} mb-3 form-check form-check-custom form-check-solid form-check-{{ $display }}">
                <input class="form-check-input" name="{{ $name . '[]' }}" type="checkbox" id="{{ $name . '_' . $key }}"
                    value="{{ $key }}" @checked(old($name, $value) == $key) {{ $required ? 'required="required"' : '' }} {!! $others !!} {{ $attributes }}>
                <label class="form-check-label" for="{{ $name . '_' . $key }}">{{ __($label) }}</label>
            </div>
        @endforeach
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
        'formtype' => 'checkbox',
        'name' => 'type',
        'id' => 'type',
        'label' => 'type',
        'value' => '',
        'display' => 'inline',
        'options' => [
            1 => 'label 1',
            2 => 'label 2',
            3 => 'label 3',
        ],
        'required' => 'required',
        'condition' => null,
        'cols' => '6',
    ],

_____________________________________________________________________________________
--}}
