<x-BaseComponents.layout.crud.form :formTitle="$formTitle" :saveAndCont="$saveAndCont ?? null">

    <x-BaseComponents.form.common.input cols="12" type="text" id="title_en" name="title_en" label="title_en"
        placeholder="enter title_en" :model="$model" />
    <x-BaseComponents.form.common.input cols="12" type="text" id="title_ar" name="title_ar" label="title_ar"
        placeholder="enter title_ar" :model="$model" />


    <x-BaseComponents.form.common.textarea name="description_en" id="description_en" :model="$model" rows="3"
        label="description_en" placeholder="enter description_en" />
    <x-BaseComponents.form.common.textarea name="description_ar" id="description_ar" :model="$model" rows="3"
        label="description_ar" placeholder="enter description_ar" />

    <x-BaseComponents.form.common.components_to_delete.select_fixed name="status" :model="$model" label="status" :options="[
        '0' => 'pinned',
        '1' => 'published',
        '2' => 'blocked',
    ]" />


    <x-BaseComponents.form.common.switch :model="$model" />

    <x-BaseComponents.form.common.image name="image" id="image" :model="$model" />
</x-BaseComponents.layout.crud.form>
