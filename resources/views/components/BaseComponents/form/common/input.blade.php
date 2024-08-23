@props([
    'type' => 'text', // email, hidden, number, password, file, date, month, week, time, datetime-local, color, url
    'name',
    'value' => '',
    'label' => $name,
    'placeholder' => 'enter ' . $name,
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
    <label class="form-label" for="{{ $name }}">{{ __($label) }}</label>
    @if ($attributes->get('required') == true)
        <small class="ms-2 fs-2 text-danger">&#42;</small>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}"
        id="{{ $name }}" placeholder="{{ __($placeholder) }}"
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} {{ $attributes }}>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{--
USE:
    [
        'formtype' => 'input',
        'name' => 'name_en',
        'id' => 'name_en',
        'label' => 'name_en',
        'placeholder' => 'enter name_en',
        'type' => 'text',
        'value' => $model['name_en'],
        'required' => 'required',
        'condition' => ['id' => 'is_active', 'value' => 'true'],
        'cols' => '6'
    ],
--}}
