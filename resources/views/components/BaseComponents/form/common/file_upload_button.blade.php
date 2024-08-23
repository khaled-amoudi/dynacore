@props([
    'name',
    'label' => 'Uplaod File',
    'condition' => null,
])

@php
    // Parse the condition if provided
    $conditionId = $condition['id'] ?? null;
    $conditionValue = $condition['value'] ?? null;
@endphp

<button class="btn btn-outline-primary position-relative btn-block mb-7 mt-2 p-0 {{ $conditionId ? 'conditional-input' : '' }}"
    @if ($conditionId) data-condition-id="{{ $conditionId }}"
        data-condition-value="{{ $conditionValue }}"
        style="display: none;" @endif>
    <span class="position-absolute" style="left: 40%; top: 3px;">
        <i class="lni lni-upload mx-3"></i>{{ __($label) }}</span>
    <input type="file" name="{{ $name }}" style="opacity: 0" class="p-0 border d-block w-100" {{ $attributes }}>
</button>
