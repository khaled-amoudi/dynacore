<x-BaseComponents.layout.crud.create :data="$data" :model="$model" :saveAndCont="true">


    @include('dashboard.' . $data['resource_name'] . '._form', [
        'formTitle' => 'create ' . $data['resource_name'], 'saveAndCont' => true
    ])

</x-BaseComponents.layout.crud.create>
