<x-BaseComponents.layout.crud.create :data="$data" :model="$model" :saveAndCont="false">


    @include('dashboard.' . $data['resource_name'] . '._form', [
        'formTitle' => 'Create ' . format_resource($data['resource_name']), 'saveAndCont' => false
    ])

</x-BaseComponents.layout.crud.create>
