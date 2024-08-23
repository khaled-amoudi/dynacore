<x-BaseComponents.layout.crud.form :formTitle="$formTitle" :saveAndCont="$saveAndCont ?? null">

    @foreach ($formInputs as $input)
        @if (in_array($input['formtype'], ['input', 'switch', 'date-range', 'textarea-editor', 'textarea', 'separator']))
            @component('components.BaseComponents.form.common.' . $input['formtype'], [
                'cols' => $input['cols'] ?? '6',
                'type' => $input['type'] ?? 'text',
                'id' => $input['id'] ?? '',
                'name' => $input['name'] ?? '',
                'label' => $input['label'] ?? $input['name'],
                'placeholder' => $input['placeholder'] ?? $input['name'],
                'value' => $input['value'] ?? '',
                'condition' => $input['condition'] ?? null,
                'rows' => $input['rows'] ?? '3',
                'required' => $input['required'] ?? '',
                'title' => $input['title'] ?? null,
            ])
            @endcomponent
        @elseif (in_array($input['formtype'], ['file', 'image']))
            @component('components.BaseComponents.form.common.' . $input['formtype'], [
                'cols' => $input['cols'] ?? 6,
                'id' => $input['id'] ?? '',
                'path' => $input['path'] ?? 'storage/',
                'name' => $input['name'] ?? '',
                'label' => $input['label'] ?? $input['name'],
                'placeholder' => $input['placeholder'] ?? $input['name'],
                'value' => $input['value'] ?? '',
                'condition' => $input['condition'] ?? null,
                'required' => $input['required'] ?? '',
            ])
            @endcomponent
        @elseif (in_array($input['formtype'], ['tagify', 'select', 'checkbox', 'radio']))
            @component('components.BaseComponents.form.common.' . $input['formtype'], [
                'cols' => $input['cols'] ?? 6,
                'id' => $input['id'] ?? '',
                'path' => $input['path'] ?? 'storage/',
                'name' => $input['name'] ?? '',
                'label' => $input['label'] ?? $input['name'],
                'placeholder' => $input['placeholder'] ?? $input['name'],
                'get' => $input['get'] ?? null,
                'display' => $input['display'] ?? 'inline',
                'options' => $input['options'] ?? [],
                'value' => $input['value'] ?? '',
                'condition' => $input['condition'] ?? null,
                'searchable' => $input['searchable'] ?? true,
                'allow_clear' => $input['allow_clear'] ?? true,
                'required' => $input['required'] ?? '',
            ])
            @endcomponent
        @else
            @component('components.BaseComponents.form.common.' . $input['formtype'], [
                'id' => $input['id'] ?? '',
                'name' => $input['name'] ?? '',
                'model' => $input['model'] ?? $model,
                'condition' => $input['condition'] ?? null,
                'cols' => $input['cols'] ?? 6,
            ])
            @endcomponent
        @endif
    @endforeach

</x-BaseComponents.layout.crud.form>
