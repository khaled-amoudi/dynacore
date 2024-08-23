@props([
    'tabel_data' => [],
    'ths' => [],
    'datas',
    'fillable_images' => [],
    'fillables' => [],
    'fillable_badges' => [],
    'fillable_badge_values' => [],
    'fillable_badges_array',
    'actions' => [],
    'export_excel',
    'export_excel_demo',
    'export_pdf',
    'import_excel',
    'text_filters',
    'select_fixed_filters',
])

<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{ ucwords($tabel_data['table_title']) }}</h5>
            <div>
                @include('components.BaseComponents.tabel.tabel_partials.export_import')
                {{-- Create-New-Model Button --}}
                @if (!isset($actions['route_force_delete']))
                    <a href="{{ route($tabel_data['table_button_route']) }}" type="button"
                        class="btn btn-sm btn-primary shadow px-3 ms-1">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-plus">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </span>
                        Add New
                    </a>
                @else
                    <a href="{{ url()->previous() }}" class="btn btn-cancel shadow-sm px-2 ms-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-arrow-left">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        <span>Cancel</span>
                    </a>
                @endif
            </div>
        </div>
        <hr style="color: rgb(173, 173, 173)">
        <div class="filters my-4">
            <div class="ms-auto position-relative">
                <form action="{{ URL::current() }}" method="get">
                    <div class="row">
                        @include('components.BaseComponents.tabel.tabel_partials.filters')
                    </div>
                    {{-- Hidden Submit Button --}}
                    <button class="btn btn-sm btn-dark d-none" type="submit">Filter</button>
                </form>
            </div>
        </div>
        <div class="table-responsive mt-3">
            {{-- <form action="{{ route('dashboard.products.deleteGroup') }}" method="post">
                @csrf --}}
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        {{-- @if (isset($actions['with_delete_group']))
                                <th>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" name="deletegroup[]" type="checkbox"
                                            id="deletegroup">
                                    </div>
                                </th>
                                <button type="submit" class="btn btn-dark">delete group</button>
                            @endif --}}
                        @isset($ths)
                            @foreach ($ths as $th)
                                <th>{{ $th }}</th>
                            @endforeach
                        @endisset
                    </tr>
                </thead>

                <tbody>
                    @forelse ($datas as $data)
                        <tr class="bg-accent-on-hover {{ $loop->odd ? 'bg-accent' : '' }}">
                            {{-- <td>{{ $loop->index+1 }}</td> --}}
                            {{-- @if (isset($actions['with_delete_group']))
                                    <td>
                                        <div class="form-check m-0">
                                            <input class="form-check-input chechfordelete" name="deletegroup[]"
                                                type="checkbox" value="{{ $data['id'] }}">
                                        </div>
                                    </td>
                                @endif --}}
                            <td>{{ $data['id'] }}</td>
                            {{-- IMAGES --}}
                            @isset($fillable_images)
                                @foreach ($fillable_images as $image)
                                    <td><img src="{{ asset('storage/' . $data['image']) }}" class="product-img-2 border-0"
                                            alt="image"></td>
                                @endforeach
                            @endisset

                            {{-- NORMAL DATA WITHOUT ADDITIONALS --}}
                            @isset($fillables)
                                @foreach ($fillables as $fillable)
                                    <td class="td-max-words">{{ $data[$fillable] }}</td>
                                    {{-- overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 150px; --}}
                                @endforeach
                            @endisset


                            {{-- BADGES or TAGS --}}
                            @isset($fillable_badges)
                                @foreach ($fillable_badges as $badge_attr => $badge_data)
                                    <td>
                                        @foreach ($badge_data as $key => $value)
                                            @if ($data[$badge_attr] == $key)
                                                <span class="badge py-1 px-2 rounded-pill {{ $value[1] }}" style="font-size: 12px; font-weight: 500;">
                                                    {{ $value[0] }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach
                            @endisset

                            @isset($fillable_badges_array)
                                @foreach ($fillable_badges_array as $fillable_array)
                                <td>
                                    @foreach ($data[$fillable_array] as $badge)
                                        <span class="badge py-1 px-2 alert-primary" style="font-size: 12px; font-weight: 500;">{{ $badge }}</span>
                                    @endforeach
                                </td>
                                @endforeach
                            @endisset
                            {{-- @isset($fillable_badges_dynamic)
                                <td>
                                    @foreach ($fillable_badges_dynamic as $badge)
                                        @foreach ($badge as $key => $value)
                                            <span class="badge rounded-pill">
                                                {{ $badge['text'] }}
                                            </span>
                                        @endforeach
                                    @endforeach
                                </td>
                            @endisset --}}

                            {{-- ACTIONS --}}
                            <td>
                                <div class="table-actions d-flex align-items-center gap-3 fs-6">

                                    @if (isset($actions['route_show']))
                                        <a href="{{ route($actions['route_show'], $data['id']) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                            data-bs-original-title="Views" aria-label="Views"><i
                                                class="{{ $actions['icon_class_show'] }}"></i></a>
                                    @endif

                                    @if (isset($actions['route_edit']))
                                        <a href="{{ route($actions['route_edit'], $data['id']) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                            data-bs-original-title="Views" aria-label="Views"><i
                                                class="{{ $actions['icon_class_edit'] }}"></i></a>
                                    @endif

                                    @if (isset($actions['route_destroy']))
                                        @include('components.BaseComponents.tabel.tabel_partials.delete_btn')
                                    @endif


                                    @if (isset($actions['route_restore']))
                                        <form action="{{ route($actions['route_restore'], $data['id']) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-bs-original-title="Re-store" aria-label="Re-store">
                                                <i
                                                    class="me-2 {{ $actions['icon_class_restore'] }}"></i>Restore</button>
                                        </form>
                                    @endif
                                    @if (isset($actions['route_force_delete']))
                                        @include('components.BaseComponents.tabel.tabel_partials.force_delete_btn')
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($ths) }}">
                                @if (isset($actions['route_force_delete']))
                                    <div class="text-secondary fw-bold pt-3 text-center">
                                        <img class="w-25 h-25" style="opacity: .6"
                                            src="{{ asset('admin/assets/images/trash-2.svg') }}" alt="">
                                        <div class="my-3 fw-normal">It seems like we could not find any data to
                                            show
                                            here</div>
                                        {{-- <p class="text-secondary pt-3 text-center">Trash Is Empty 🤨</p> --}}
                                    </div>
                                @else
                                    <div class="text-secondary fw-bold pt-3 text-center">
                                        <img class="w-25 h-25" src="{{ asset('admin/assets/images/no-data-1.svg') }}"
                                            alt="">
                                        <div class="my-3 fw-normal">It seems like we could not find any data to
                                            show
                                            here</div>
                                        {{-- <div class="mt-4">OOPS, There Is No {{ $tabel_data['table_title'] }} Yet 😴</div> --}}
                                    </div>
                                @endif
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
            {{-- </form> --}}
        </div>
    </div>
</div>
<div class="d-flex justify-content-end">
    {{-- {{ $datas['paginator']->links() }} --}}
    {{-- {{ $datas->withQueryString()->links() }} --}}
    {{-- page {{ $datas->currentPage() }} of {{ $datas->count() }} --}}
</div>

{{-- Docs
    Author: khaled - 16/09/2022
_____________________________________________________________________________________
    'tabel_data' => [],
    'ths' => [],
    'datas' => [],
    'fillable_images' => [],
    'fillables' => [],
    'fillable_badges' => [],
    'fillable_badge_values' => [],
    'actions' => [],

    * tabel_data => array contain some of fixed data in the tabel ex: crete button text, tabel title, ..
    * ths => array contain the list of <th> `s of the tabel
    * datas => array came from the controller which is the data from DB to be show it in the tabel
    * fillable_images => columns from DB that are images
    * fillables => columns from DB that are normal datas [text]
    * fillable_badges => columns from DB that are badges .e.g.[is_active, status, ..]
    * fillable_badge_values => cases of badges to customize .e.g.[active=>green. in active=>red, ..]


    Full EXAMPLE:-

        <x-BaseComponents.tabel.base-tabel
        :tabel_data="[
            'table_title' => 'Categories',
            'table_button_text' => 'Create Category',
            'table_button_route' => 'dashboard.categories.create']"

        :ths="['#', 'Image', 'Name', 'Parent ID', 'Description', 'Status', 'Actions']"

        :datas="$models"
        :fillable_images="['image']"
        :fillables="['name', 'parent_id', 'description']"
        :fillable_badges="['status']"
        :fillable_badge_values="['active', 'archive', '', '']"
        :actions="[
            'route_show' => 'dashboard.categories.show',
            'icon_class_show' => 'bi bi-eye-fill text-primary',

            'route_edit' => 'dashboard.categories.edit',
            'icon_class_edit' => 'bi bi-pencil-fill text-warning',

            'route_destroy' => 'dashboard.categories.destroy',
            'icon_class_destroy' => 'bi bi-trash-fill text-danger',
        ]"
        :export_excel="['route_name'=>'dashboard.categories.exportExcel']"
        :export_pdf="['route_name'=>'#']"
        :import_excel="['route_name'=>'#']"

        :textFilter="['route' => 'dashboard.categories.index', 'name' => 'search', 'label' => 'filter by name, description']"
    />
_____________________________________________________________________________________ --}}
