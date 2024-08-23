@extends('layouts.master')

@section('title')
    {{ __('common.'.config('app.name')) . ' | ' . __('show ' . $data['resource_name']) }}
@endsection

@section('toolbar')
    <x-BaseComponents.layout.breadcrumb :prev_pages="[
        'dashboard' => 'dashboard',
        $data['resource_name'] . ' list' => $data['route_index'],
    ]" :current_page="'show ' . $data['resource_name']" />
@endsection

@section('content')

<div class="mx-5 mx-md-9">

    {{ $slot }}

</div>

@endsection
