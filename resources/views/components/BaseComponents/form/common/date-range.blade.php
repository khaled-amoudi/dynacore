@props([
    'name',
    'value' => '',
    'label' => $name,
    'placeholder' => 'enter ' . $name,
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
    <label class="form-label" for="{{ $name }}">{{ __($label) }}</label>
    @if ($required)
        <small class="ms-2 fs-2 text-danger">&#42;</small>
    @endif
    <div style="position: relative !important">
        <input name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ __($placeholder) }}"
            id="{{ $name }}" style="position: static !important"
            {{ $attributes->class(['form-control', 'form-control-solid', 'text-dark', 'daterangepicker', 'is-invalid' => $errors->has($name)]) }}
            {{ $required ? 'required="required"' : '' }} {!! $others !!} {{ $attributes }}>
    </div>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var name = @json($name); // Pass the name variable from Blade to JavaScript
        $("#" + name).daterangepicker();
    });
</script>

{{--

USE:
    [
        'formtype' => 'date-range', // date // date-range
        'name' => 'date',
        'id' => 'date',
        'label' => 'date',
        'placeholder' => 'enter date',
        'value' => $model['date'],
        'required' => 'required',
        'condition' => null,
        'cols' => '6',
    ],

--}}
