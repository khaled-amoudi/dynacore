<x-BaseComponents.layout.crud.form :formTitle="$formTitle" :saveAndCont="$saveAndCont ?? null">

    <x-BaseComponents.form.common.input cols="12" type="text" id="name" name="name" label="name" placeholder="enter name" :model="$model" />

</x-BaseComponents.layout.crud.form>
