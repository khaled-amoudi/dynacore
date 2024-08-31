@props([
    'name', // Name of the repeater field
    'label', // Label for the repeater
    'value' => [],
    'fields' => [], // Array of fields to be used in the table
    'rules' => [],
    'rules_ajax' => '',
    'cols' => '12',
    'condition' => null,
])

@php
    $conditionId = $condition['id'] ?? null;
    $conditionValue = $condition['value'] ?? null;
@endphp

<div class="mb-7 col-12 col-sm-{{ $cols }} {{ $conditionId ? 'conditional-input' : '' }}"
    @if ($conditionId) data-condition-id="{{ $conditionId }}"
        data-condition-value="{{ $conditionValue }}"
        style="display: none;" @endif>

    <div class="card card-dashed">
        <div class="border-bottom px-9 py-4 d-flex justify-content-between align-items-center">
            <label for="kt_repeater_{{ $name }}">{{ $label }}</label>
        </div>

        <div class="card-body">

            <div class="form-group row">
                {{-- components --}}
                @foreach ($fields as $field)
                    @component(
                        'components.BaseComponents.form.common.' . $field['formtype'],
                        array_merge($field, ['name' => $name . '_' . $field['name']]))
                    @endcomponent
                @endforeach
                {{-- components --}}
            </div>

            <div class="form-group mt-3">
                <button type="button" id="add-{{ $name }}-row" class="btn btn-sm w-100 btn-info">
                    <i class="la la-plus"></i>{{ __('common.add') }}
                </button>
            </div>


            <div class="table-responsive mt-10">
                <table class="table table-rounded table-striped table-row-bordered border gy-4 gs-4 dynamic-table"
                    id="table-{{ $name }}">
                    <thead class="bg-dark text-white">
                        <tr>
                            @foreach ($fields as $field)
                                <th>{{ __($field['label']) }}</th>
                            @endforeach
                            <th>{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($value as $index => $item)
                            <tr>
                                @foreach ($fields as $field)
                                    @php
                                        $fieldName = $name . '[' . $index . '][' . $field['name'] . ']';
                                        $fieldValue = $item[$field['name']] ?? ''; // Get the value for the current field
                                    @endphp
                                    <td>
                                        @switch($field['formtype'])
                                            @case('input')
                                            @case('textarea')
                                                {{ $fieldValue }}
                                                <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
                                            @break

                                            @case('select')
                                                {{ $field['options'][$fieldValue] ?? '' }}
                                                <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
                                            @break

                                            @case('image')
                                            @case('file')

                                            @case('switch')
                                                <span
                                                    class="badge {{ $fieldValue ? 'badge-light-success' : 'badge-light-danger' }} d-inline-block w-100">
                                                    {!! $fieldValue ? '<i class="fa-solid fa-check text-success"></i>' : '<i class="fa-solid fa-x text-danger"></i>' !!}
                                                </span>
                                                <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
                                            @break

                                            @case('checkbox')
                                                @php
                                                    $checkboxValues = explode(',', $fieldValue);
                                                @endphp
                                                <span
                                                    class="badge badge-success d-inline-block w-100">{{ implode(', ', $checkboxValues) }}</span>
                                                <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
                                            @break

                                            @case('tagify')
                                                @php
                                                    $tagLabels = $fieldValue;
                                                @endphp
                                                <span
                                                    class="badge badge-secondary d-inline-block w-100">{{ $tagLabels }}</span>
                                                <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
                                            @break

                                            @default
                                                {{ $fieldValue }}
                                                <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
                                            @break
                                        @endswitch
                                    </td>
                                @endforeach
                                <td><span class="badge badge-danger delete-row" style="cursor: pointer;"
                                        title="{{ __('common.delete') }}">{{ __('common.delete') }}</span></td>
                            </tr>
                            @empty
                                <tr class="default-row">
                                    @foreach ($fields as $field)
                                        <td><span class="badge badge-secondary d-inline-block w-100"></span></td>
                                    @endforeach
                                    <td><span class="badge badge-secondary d-inline-block w-100"></span></td>
                                </tr>
                            @endforelse
                            <!-- Dynamic rows will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">{{ __('common.Delete This Record') }}</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="fs-2" aria-hidden="true">&times;</span>
                    </div>
                </div>
                <div class="modal-body">
                    {{ __('common.Are You Sure You Want To Delete This Item Forever?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('common.Cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('common.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let name = @json($name);
        document.getElementById('add-' + name + '-row').addEventListener('click', function() {
            let fields = @json($fields);
            let rowData = {};
            let rules = @json($rules);
            let rules_ajax = @json($rules_ajax);

            let row = '<tr>';
            let hasValue = false; // Flag to check if any value is entered

            fields.forEach(field => {

                let inputElement = document.getElementById(name + '_' + field.name);
                let value = '';

                if (inputElement) {
                    switch (field.formtype) { // Corrected to field.formtype
                        case 'input':
                        case 'textarea':
                            value = inputElement.value;
                            row += `<td>
                                ${value}
                                <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${value}">
                            </td>`;
                            break;
                        case 'select':
                            let selectedOption = inputElement.options[inputElement.selectedIndex];
                            let optionText = selectedOption.text;
                            let optionValue = selectedOption.value;

                            value = optionValue; // Display the text in the table

                            row += `<td>
                                        ${optionText}
                                        <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${optionValue}">
                                    </td>`;

                            // Clear the selection by resetting the index
                            for (let i = 0; i < inputElement.options.length; i++) {
                                inputElement.options[i].removeAttribute('selected');
                            }
                            // inputElement.selectedIndex = 0;

                            if (optionValue) {
                                hasValue = true;
                            }
                            break;
                        case 'radio':
                            let checkedRadio = document.querySelector(
                                `input[name="${name}_${field.name}"]:checked`);
                            if (checkedRadio) {
                                value = checkedRadio.value;
                            }
                            row += `<td>
                                ${value}
                                <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${value}">
                            </td>`;
                            break;
                        case 'switch':
                            const switchValue = inputElement.checked ? 1 : 0;
                            value = switchValue;

                            row += `<td>
                                <span class="badge ${switchValue ? 'badge-light-success' : 'badge-light-danger'} d-inline-block w-100">${switchValue ? '<i class="fa-solid fa-check text-success"></i>' : '<i class="fa-solid fa-x text-danger"></i>'}</span>
                                <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${switchValue}">
                            </td>`;

                            // Clear the switch element (if necessary)
                            inputElement.checked = false;
                            break;
                        case 'checkbox':
                            const checkedCheckboxes = document.querySelectorAll(
                                'input[name="' + name + '_' + field.name + '[]"]:checked'
                            );

                            if (checkedCheckboxes.length > 0) {
                                checkedCheckboxes.forEach((checkbox) => {
                                    formData.append(name + '_' + field.name + "[]", checkbox.value);
                                });
                                value = checkedCheckboxes.join(', ');

                                // Display "Yes" in the table badge
                                row += `<td>
                                        <span class="badge badge-success d-inline-block w-100">Yes</span>
                                        <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${checkedCheckboxes.map(checkbox => checkbox.value).join(', ')}">
                                    </td>`;
                            } else {
                                value = '';
                                // Display "No" in the table badge
                                row += `<td>
                                        <span class="badge badge-danger d-inline-block w-100">No</span>
                                        <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="">
                                    </td>`;
                            }

                            // Clear checked checkboxes
                            checkedCheckboxes.forEach((checkbox) => {
                                checkbox.checked = false;
                            });
                            break;
                        case 'file':
                        case 'image':
                            if (inputElement.files.length > 0) {
                                value = inputElement.files[0].name;
                                hasValue = true; // Set hasValue if a file is selected

                                // Display "Yes" in the table badge
                                row += `<td>
                                    <span class="badge badge-light-success d-inline-block w-100"><i class="fa-solid fa-check text-success"></i></span>
                                    <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${value}">
                                </td>`;
                            } else {
                                // Display "No" in the table badge
                                row += `<td>
                                <span class="badge badge-light-danger d-inline-block w-100"><i class="fa-solid fa-x text-danger"></i></span>
                                <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="">
                            </td>`;
                            }
                            break;
                        case 'tagify':
                            let tagsElement = inputElement.previousElementSibling;
                            let codesArray = [];

                            tagsElement.querySelectorAll("tag").forEach((tagElement) => {
                                codesArray.push(tagElement.getAttribute("value"));
                            });

                            // Extract labels from tag elements
                            let tagElements = Array.from(tagsElement.querySelectorAll("tag"));
                            let tagLabels = tagElements.map(tagElement => {
                                return tagElement.getAttribute("label");
                            });

                            value = tagLabels.join(', ');

                            row += `<td>
                                <span class="badge badge-secondary d-inline-block w-100">${value}</span>
                                <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${codesArray.join(', ')}">
                            </td>`;

                            // Clear the tagify input
                            inputElement.value = '';
                            break;
                        default:
                            value = inputElement.value;
                            row += `<td>
                                ${value}
                                <input type="hidden" name="${name}[{{ $loop->index }}][` + field.name + `]" value="${value}">
                            </td>`;
                            break;
                    }

                    rowData[field.name] = value;

                    // Clear the input value
                    if (['input', 'textarea', 'tagify'].includes(field
                            .formtype)) { // Corrected to field.formtype
                        inputElement.value = '';
                    } else if (field.formtype === 'select') { // Corrected to field.formtype
                        inputElement.selectedIndex = 0;
                    } else if (field.formtype === 'checkbox' || field.formtype ===
                        'radio') { // Corrected to field.formtype
                        inputElement.value = 'off';
                    } else if (field.formtype === 'file' || field.formtype ===
                        'image') { // Corrected to field.formtype
                        inputElement.value = ''; // Clear the file input
                    }

                    if (value) {
                        hasValue = true;
                    }
                }
            });

            console.log(rowData);


            // when the user click on add button, it will sed a request to validate the repeater data
            $.ajax({
                url: rules_ajax,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    rowData,
                    rules
                },
                success: function(response) {
                    if (response.success) {
                        row +=
                            `<td><span class="badge badge-danger delete-row" style="cursor: pointer;" title="{{ __('common.delete') }}">{{ __('common.delete') }}</span></td>`;
                        row += '</tr>';

                        document.querySelector('#table-' + name + ' tbody').insertAdjacentHTML(
                            'beforeend', row);

                        // Show the default row if all other rows are deleted
                        toggleDefaultRowVisibility();
                    } else {
                        // Show validation errors
                        let errors = response.errors;
                        // console.log(errors);

                        toastr_showErrors(errors);

                        // for (let field in errors) {
                        //     toastr_showErrors(errors[field]);
                        // }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        });


        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                // Store the row to be deleted in a variable
                const rowToDelete = e.target.closest('tr');

                // Show the delete confirmation modal
                $('#deleteConfirmationModal').modal('show');

                // Add a click event listener to the confirm delete button
                document.getElementById('confirmDeleteBtn').onclick = function() {
                    // Remove the row from the table
                    rowToDelete.remove();

                    // Hide the modal after deletion
                    $('#deleteConfirmationModal').modal('hide');

                    // Show the default row if all other rows are deleted
                    toggleDefaultRowVisibility();
                };
            }
            toggleDefaultRowVisibility();
        });



        // document.addEventListener('click', function(e) {
        //     if (e.target.classList.contains('delete-row')) {
        //         e.target.closest('tr').remove();
        //     }
        //     // Show the default row if all other rows are deleted
        //     toggleDefaultRowVisibility();
        // });


        function toggleDefaultRowVisibility() {
            let tableBody = document.querySelector('#table-' + name + ' tbody');
            let rows = tableBody.querySelectorAll('tr');
            let defaultRow = tableBody.querySelector('.default-row');

            if (rows.length > 1) {
                defaultRow.style.display = 'none';
            } else {
                defaultRow.style.display = '';
            }
        }

        toggleDefaultRowVisibility();
    </script>


    {{--
USE:
[
    'formtype' => 'repeater_table',
    'name' => 'items',
    'value' => $model['items'],
    'label' => 'العناصر',
    'condition' => null,
    'rules' => [
        'name_en' => ['required'],
        'is_active' => ['required']
    ],
    'rules_ajax' => route('dashboard.ajax.verifyRules'),
    'cols' => '12',
    'fields' => [
        [
            'formtype' => 'input',
            'name' => 'name_en',
            'id' => 'name_en',
            'label' => 'name_en',
            'placeholder' => 'enter name_en',
            'type' => 'text',
            'value' => '',
            'required' => true,
            'condition' => null,
            'cols' => '4',
        ],
        [
            'formtype' => 'input',
            'name' => 'name_ar',
            'id' => 'name_ar',
            'label' => 'name_ar',
            'placeholder' => 'enter name_ar',
            'type' => 'text',
            'value' => '',
            'required' => 'required',
            'condition' => null,
            'cols' => '4',
        ],
        [
            'formtype' => 'select',
            'name' => 'status',
            'id' => 'status',
            'label' => 'status',
            'value' => '',
            'options' => [
                '0' => 'pinned',
                '1' => 'published',
                '2' => 'blocked',
            ],
            'searchable' => true,
            'allow_clear' => true,
            'cols' => '4',
            'condition' => null,
        ],
        [
            'formtype' => 'textarea',
            'name' => 'description_en',
            'id' => 'description_en',
            'label' => 'description_en',
            'placeholder' => 'enter description_en',
            'value' => '',
            'required' => 'required',
            'condition' => null,
            'rows' => '3',
            'cols' => '6'
        ],
        [
            'formtype' => 'textarea',
            'name' => 'description_ar',
            'id' => 'description_ar',
            'label' => 'description_ar',
            'placeholder' => 'enter description_ar',
            'value' => '',
            'required' => 'required',
            'condition' => null,
            'rows' => '3',
            'cols' => '6'
        ],
        [
            'formtype' => 'switch',
            'name' => 'is_active',
            'id' => 'is_active',
            'label' => 'is_active',
            'placeholder' => 'is_active',
            'value' => '',
            'required' => 'required',
            'condition' => null,
            'cols' => '6'
        ],
        [
            'formtype' => 'image',
            'name' => 'image',
            'path' => 'storage/',
            'label' => 'image upload',
            'value' => '',
            'required' => 'required',
            'condition' => ['id' => 'items_is_active', 'value' => 'true'],
            'cols' => '6',
        ],
    ]
]

#####################################
handle it in controller as this:
/// STORE
    if (!empty($request['items'])) {
        foreach ($request['items'] as $item) {
            $model->items()->create([
                'category_id' => $model->id,
                'image' => null, // $this->uploadFile($request, $old_image = null, $filename = 'image', $disk = 'public', $path = '/'),
                'name' => [
                    'en' => $item['name_en'],
                    'ar' => $item['name_ar']
                ],
                'description' => [
                    'en' => $item['description_en'],
                    'ar' => $item['description_ar']
                ],
                'is_active' => 1, // $item['is_active'] == 'on' ? 1 : 0,
                'status' => $item['status'],
            ]);
        }
    }
/// UPDATE
    $model->items()->delete();
    if (!empty($request['items'])) {
        foreach ($request['items'] as $item) {
            Item::create([
                'category_id' => $model->id,
                'image' => null, // $this->uploadFile($request, $old_image = null, $filename = 'image', $disk = 'public', $path = '/'),
                'name' => [
                    'en' => $item['name_en'],
                    'ar' => $item['name_ar']
                ],
                'description' => [
                    'en' => $item['description_en'],
                    'ar' => $item['description_ar']
                ],
                'is_active' => $item['is_active'],
                'status' => $item['status'],
            ]);
        }
    }
--}}
