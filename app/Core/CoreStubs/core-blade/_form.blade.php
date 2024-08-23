<x-BaseComponents.layout.crud.form :formTitle="$formTitle" :saveAndCont="$saveAndCont ?? null">

    {{-- <x-BaseComponents.form.common.input cols="12" type="text" id="title_en" name="title_en" label="Category Title (EN)" placeholder="Enter Category Title (EN)" :model="$model" />
    <x-BaseComponents.form.common.input cols="12" type="text" id="title_ar" name="title_ar" label="Category Title (AR)" placeholder="Enter Category Title (AR)" :model="$model" /> --}}


    {{-- <x-BaseComponents.form.common.textarea name="description_en" id="description_en" :model="$model" rows="3"
        label="Category Description (EN)" placeholder="Enter Category Description (EN)" />
    <x-BaseComponents.form.common.textarea name="description_ar" id="description_ar" :model="$model" rows="3"
        label="Category Description (AR)" placeholder="Enter Category Description (AR)" /> --}}

    {{-- <x-BaseComponents.form.common.select_fixed name="status" :model="$model" label="post status" :options="[
        '0' => 'pinned',
        '1' => 'published',
        '2' => 'blocked',
    ]" /> --}}



    {{-- <x-BaseComponents.form.common.switch :model="$model" /> --}}

    {{-- <x-BaseComponents.form.common.image name="image" id="image" :model="$model" /> --}}
</x-BaseComponents.layout.crud.form>
