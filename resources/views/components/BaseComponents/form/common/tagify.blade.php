@props([
    'name',
    'value' => '',
    'label' => $name,
    'placeholder' => 'enter ' . $name,
    'options' => [],
    'cols' => '6',
    'value' => '',
    'condition' => null,
    'required' => false,
    'should_be_in_list' => true,
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
    <label for="#{{ $name }}" class="form-label">{{ __($label) }}</label>
    @if ($required)
        <small class="ms-2 fs-2 text-danger">&#42;</small>
    @endif
    <input name="{{ $name }}" placeholder="{{ __($placeholder) }}" @class([
        'form-control',
        'form-control-solid',
        'tagify',
        'is-invalid' => $errors->has($name),
    ])
        value="{{ $value }}" id="{{ $name }}" {{ $required ? 'required="required"' : '' }}
        {!! $others !!} {{ $attributes }} />

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
    @php
        $whitelist = array_map(
            function ($value, $key) {
                return [
                    'label' => $value,
                    'value' => $key,
                ];
            },
            $options,
            array_keys($options),
        );
    @endphp
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var name = @json($name);
        var whitelist = @json($whitelist);
        var should_be_in_list = @json($should_be_in_list);

        // The DOM elements you wish to replace with Tagify
        var input = document.querySelector("#" + name);

        // Initialize Tagify with conditional templates
        var tagifyOptions = {
            whitelist: whitelist,
            delimiters: null,
            enforceWhitelist: should_be_in_list,
            dropdown: {
                classname: "tagify__inline__suggestions" + name,
                enabled: 0, // <- show suggestions on focus
                closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
            }
        };

        // Conditionally add custom templates if should_be_in_list is true
        if (should_be_in_list) {
            tagifyOptions.templates = {
                tag: function(tagData) {
                    return `<tag title='${tagData.value}' contenteditable='false' spellcheck="false"
                class='tagify__tag ${tagData.class ? tagData.class : ""}' ${this.getAttributes(tagData)}>
                    <x title='remove tag' class='tagify__tag__removeBtn'></x>
                    <div class="d-flex align-items-center">
                        <span class='tagify__tag-text'>${tagData.label}</span>
                    </div>
                </tag>`;
                },
                dropdownItem: function(tagData) {
                    return `<div class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'>
                        <span>${tagData.label}</span>
                    </div>`;
                }
            };
        }

        // Initialize Tagify with the prepared options
        new Tagify(input, tagifyOptions);
    });
</script>
{{-- Docs
    Author: khaled - 31/08/2024
_____________________________________________________________________________________
    Full EXAMPLE:-
    [
        'formtype' => 'tagify',
        'name' => 'tagss',
        'id' => 'tagss',
        'label' => 'tagss',
        'placeholder' => 'enter tagss',
        'value' => $model['tagss'],
        'options' => Category::pluck('name', 'id')->toArray(),
        // // or this way - static
        // 'options' => [
        //     ["label" => "HTML", "value" => "html"],
        //     ["label" => "CSS", "value" => "css"],
        //     ["label" => "JAVASCRIPT", "value" => "js"],
        // ],
        'value' => '',
        'condition' => null,
        'should_be_in_list' => true,
        'cols' => '6',
    ],
_____________________________________________________________________________________
--}}
