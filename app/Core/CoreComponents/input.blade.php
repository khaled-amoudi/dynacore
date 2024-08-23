@props([
    'type' => 'text', // email, hidden, number, password, file, date, month, week, time, datetime-local, color, url
    'name',
    'model' => $model,
    'label' => class_basename((object)$model) . ' ' . str_replace("_"," ",$name),
    'placeholder' => Str::ucfirst('enter '. class_basename((object)$model) . ' ' . $name),
    'cols' => '6',
])

<div class="mb-7 col-12 col-sm-{{ $cols }}">
    <label class="form-label" for="{{ $name }}">{{ ucwords($label) }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $model[$name]) }}" id="{{ $name }}" placeholder="{{ $placeholder }}" {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ]) }}>
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{--Docs
    Author: khaled - 15/09/2022
_____________________________________________________________________________________
    * type => input type eg: text, email, password, ...
    * name => input name, should be same as DB attr
    * model => the Model (table) of this item, we use it to show data when editing
    * label =>[OPTIONAL] input label
    * placeholder =>[OPTIONAL] input placehoder

    Full EXAMPLE:-
    <x-BaseComponents.form.common.input type="text" name="name" :model="$category" label="category name" placeholder="Enter category name" class="...." />

    Less EXAMPLE:-
    <x-BaseComponents.form.common.input type="text" name="name" :model="$category" />

    More Less EXAMPLE:-
    <x-BaseComponents.form.common.input name="name" :model="$category" />
_____________________________________________________________________________________
--}}
