@props([
    'name',
    // 'value' => '',
    'label' => $name,
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


    <div class="card card-dashed">
        <div class="border-bottom p-4">
            <label for="kt_repeater_{{ $name }}">{{ $label }}</label>
            <div class="card-toolbar">
                {{-- <button type="button" class="btn btn-sm btn-light">
                    Action
                </button> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="kh_repeater" id="kt_repeater_{{ $name }}">
                <div class="form-group">
                    <div data-repeater-list="{{ $name }}">
                        <div class="mb-10" data-repeater-item>
                            <div class="form-group row">
                                {{-- components --}}
                                @foreach ($fields as $field)
                                    @component(
                                        'components.BaseComponents.form.common.' . $field['formtype'],
                                        array_merge($field, ['name' => $name . '_' . $field['name']]))
                                    @endcomponent
                                @endforeach
                                {{-- components --}}

                                <div class="col-sm-2">
                                    <a href="javascript:;" data-repeater-delete
                                        class="btn btn-sm btn-danger w-100 mt-4 mt-sm-9">
                                        <i class="la la-trash-o"></i>{{ __('common.delete') }}
                                    </a>
                                </div>
                            </div>
                            <div class="separator mt-5"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-5">
                    <a href="javascript:;" data-repeater-create class="btn btn-sm w-100 btn-info">
                        <i class="la la-plus"></i>{{ __('common.add') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{--
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror --}}
</div>

{{-- Docs
    Author: khaled - 31/08/2024
_____________________________________________________________________________________
    Full EXAMPLE:-
    [
        'formtype' => 'repeater',
        'name' => 'items',
        // 'value' => '',
        'label' => 'العناصر',
        'condition' => null,
        'cols' => '12',
        'fields' => [
            [
                'formtype' => 'input',
                'name' => 'name_en',
                'id' => 'name_en',
                'label' => 'name_en',
                'placeholder' => 'enter name_en',
                'type' => 'text',
                'value' => $model['name_en'],
                'required' => true,
                'condition' => null,
                'cols' => '4',
            ],
        ]
    ]


    ##############################################################
Controller Store: (Relation)

    // Validation:
        'product_details.*.detail_category_id' => 'nullable|integer|exists:categories,id',
        'product_details.*.detail_name_en' => 'nullable|string|max:255',
        'items.*.items_name_en' => 'required',

    // Store:
        foreach ($request['product_details'] as $detail) {
            $product->details()->create([
                'category_id' => $detail['detail_category_id'],
                'name_en' => $detail['detail_name_en'],
                // other fields...
            ]);
        }
_______________________________________________________________
Controller Store: (Json):

    $categoryDetails = [];
    $nameDetail = [];
    foreach ($request['product_details'] as $detail) {
        $categoryDetails[] = $detail['detail_category_id'];
        $nameDetails[] = $detail['detail_name_en'];
    }
    Product::create([
        'category_details' => json_encode($categoryDetails),
        'names_details' => json_encode($nameDetails),
    ]);
_____________________________________________________________________________________
--}}
