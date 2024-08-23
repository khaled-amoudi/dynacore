<x-BaseComponents.layout.crud.form :formTitle="$formTitle" :saveAndCont="$saveAndCont ?? null">

    <x-BaseComponents.form.common.input cols="12" type="text" id="name" name="name" label="User Name" placeholder="Enter User Name" :model="$model" />
    <x-BaseComponents.form.common.input cols="12" type="email" id="email" name="email" label="User Email" placeholder="Enter User Email" :model="$model" />


    <x-BaseComponents.form.common.input cols="12" type="password" id="password" name="password" label="User Password" placeholder="Enter User Password" :model="$model" />


    {{-- <x-BaseComponents.form.common.image name="profile_photo_url" id="profile_photo_url" :model="$model" /> --}}
</x-BaseComponents.layout.crud.form>
