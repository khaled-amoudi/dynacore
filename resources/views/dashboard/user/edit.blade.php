<x-BaseComponents.layout.crud.edit :data="$data" :model="$model">

    @include('dashboard.' . $data['resource_name'] . '._form', [
        'formTitle' => 'Edit ' . format_resource($data['resource_name']),
    ])

</x-BaseComponents.layout.crud.edit>
