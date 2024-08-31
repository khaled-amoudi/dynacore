@props([
    'name',
    'value' => '',
    'options' => [],
    'label' => $name,
    'get' => null,
    'add' => null,
    'searchable' => true,
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
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
    @if ($required)
        <small class="ms-2 fs-2 text-danger">&#42;</small>
    @endif
    <div class="d-flex justify-content-between">
        <select name="{{ $name }}" id="{{ $name }}" @class([
            'form-select',
            'form-select-solid',
            'is-invalid' => $errors->has($name),
        ])
            @if (is_array($get)) data-get-ajax="{{ $get['ajax'] }}" data-get-select="{{ $get['target'] }}" @endif
            @if ($searchable == true) data-control="select2" data-placeholder="{{ __($label) }}" @else aria-label="Default select example" @endif
            @if ($allow_clear == true) data-allow-clear="true" @endif
            {{ $required ? 'required="required"' : '' }} {!! $others !!} {{ $attributes }}>
            <option value=""></option>
            @foreach ($options as $key => $label)
                <option value="{{ $key }}" @selected(old($name, $value) == $key)>{{ __($label) }}</option>
            @endforeach
        </select>
        @if (is_array($add))
            <span data-bs-toggle="modal" data-bs-target="#{{ $add['resource'] }}"
                class="bg-primary text-white rounded p-2 ms-2 align-self-center cursor-pointer">
                <span class="svg-icon svg-icon-2x svg-icon-light" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ __('create ' . $add['resource']) }}"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
                            transform="rotate(-90 11 18)" fill="white" />
                        <rect x="6" y="11" width="12" height="2" rx="1" fill="white" />
                    </svg></span>
            </span>
            <x-BaseComponents.form.common.modal :resource="$add['resource']" :name="$name" :action="$add['action']" :formData="$add['formData']"
                :formInputs="$add['formInputs']" :ajax_for_new_options="$add['ajax_for_new_options']" />
        @endif
    </div>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
{{--
USE:
    [
        'formtype' => 'select',
        'name' => 'category_test',
        'id' => 'category_test',
        'label' => 'category_test',
        'value' => $model['category_test'],
        'options' => Category::pluck('name', 'id')->toArray(),
        // 'options' => [
        //     '1' => 'category 1',
        //     '2' => 'category 2',
        // ],
        // 'get' => [
        //     'ajax' => route('dashboard.ajax.getOptions'),
        //     'target' => 'target id'
        // ],
        // 'add' => [
        //     'action' => route('dashboard.category.store'),
        //     'resource' => 'category',
        //     'ajax_for_new_options' => route('dashboard.ajax.get_category_select'),
        //     'formInputs' => app(CategoryController::class)->createFormBuilder(new Category()),
        //     'formData' => app(CategoryController::class)->formData(new Category()),
        // ],
        'searchable' => true,
        'allow_clear' => true,
        'cols' => '6',
        'condition' => null
    ]
--}}
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
