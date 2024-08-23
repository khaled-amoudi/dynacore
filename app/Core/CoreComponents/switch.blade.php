@props([
    'name' => 'is_active',
    'model' => $model,
    'label' => $name,
])

<div class="col-12 col-md-6 mb-7">
    <label class="form-label">{{ $label }}</label>
    <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
        <input name="{{ $name }}" id="{{ $name }}" value="on" class="form-check-input h-40px w-60px" type="checkbox"
            @checked($model[$name] == 1) {{ $attributes }} />
        <label class="form-check-label" for="{{ $name }}"></label>
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

    Full EXAMPLE:-
    <x-BaseComponents.form.common.switch name="is_active" :model="$model" label="Is Active" />

_____________________________________________________________________________________ --}}
