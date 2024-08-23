@props([
    'model' => $model,
    'title' => '',
    'buttons',
    'lists',
])

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>{{ $title }}</h4>
        <div>
            @foreach ($buttons as $btn)
                <a href="{{ route($btn['route']) }}" class="btn {{ $btn['class'] }}">{{ $btn['label'] }}</a>
            @endforeach
        </div>
    </div>
    <div class="card-body p-0">
        <div class="row p-0 m-0">
            @foreach ($lists as $list)
            <div class="col-12 col-md-6 border p-2 d-flex align-items-center">
                <div class="row w-100 ">
                    <div class="col-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ $list['label'] }}</span>
                        <span>:</span>
                    </div>
                    <div class="col-9 d-flex justify-content-between align-items-center p-0">
                        @if (isset($list['type']))
                            @switch($list['type'])
                                @case('image')
                                    <span><img src="{{ $model[$list['attribute']] }}" class="product-img-2 border-0" alt="image"></span>
                                    @break
                                @case('link')
                                    <span><a href="{{ route($list['route'], $model['category_id']) }}" class="">{{ $model[$list['attribute']] }}</a></span>
                                    @break
                                @default
                                <span>{{ $model[$list['attribute']] }}</span>
                            @endswitch
                        @else
                            <span>{{ $model[$list['attribute']] }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{-- <ul class="list-group list-group-flush">
            @foreach ($lists as $list)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-3 d-flex justify-content-between">
                        <span class="fw-bold">{{ $list['label'] }}</span>
                        <span>:</span>
                    </div>
                    <div class="col-9">
                        @if (isset($list['type']) && $list['type'] == 'image')
                            <img src="{{ $model[$list['attribute']] }}" class="product-img-2 border-0" alt="image">
                        @else
                            {{ $model[$list['attribute']] }}
                        @endif
                    </div>
                </div>
            </li>
            @endforeach
        </ul> --}}
    </div>
</div>


{{-- <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>{{ $title }}</h4>
        <div>
            @foreach ($buttons as $btn)
                <a href="{{ route($btn['route']) }}" class="btn {{ $btn['class'] }}">{{ $btn['label'] }}</a>
            @endforeach
        </div>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            @foreach ($lists as $list)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-3 d-flex justify-content-between">
                        <span class="fw-bold">{{ $list['label'] }}</span>
                        <span>:</span>
                    </div>
                    <div class="col-9">
                        @if (isset($list['type']) && $list['type'] == 'image')
                            <img src="{{ $model[$list['attribute']] }}" class="product-img-2 border-0" alt="image">
                        @else
                            {{ $model[$list['attribute']] }}
                        @endif
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div> --}}



{{-- Example of use --}}
{{-- <x-BaseComponents.widgets.list_data :model="$model" title="Card Title" :buttons="[
    [
        'route' => 'dashboard.categories.index',
        'label' => 'Categories',
        'class' => 'bg-dark text-white'
    ],
    [
        'route' => 'dashboard.categories.index',
        'label' => 'Send Request',
        'class' => 'bg-warning text-dark'
    ]
]"

:lists="[
    [
        'label' => 'Name',
        'attribute' => 'name'
    ],
    [
        'label' => 'Description',
        'attribute' => 'description'
    ],
]"
/> --}}
