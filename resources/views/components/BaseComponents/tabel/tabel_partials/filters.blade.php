@props(['filters', 'relationModel'])



<div class="col-xl-12">
    <div class="accordion rounded shadow-sm mb-5 mb-xl-8" id="kt_accordion_filter">
        <div class="accordion-item">
            <h4 class="accordion-header" id="kt_accordion_filters_header">
                <button class="accordion-button fw-bold text-gray-700 fs-3 px-9 {{ Cookie::get('dynacore_accordion_status') == 'opened' ? '' : 'collapsed' }}" type="button"
                    data-bs-toggle="collapse" data-bs-target="#kt_accordion_filters_body" aria-expanded="{{ Cookie::get('dynacore_accordion_status') == 'opened' ? true : false }}" {{-- aria-expanded="true" --}}
                    aria-controls="kt_accordion_filters_body">
                    <span class="svg-icon svg-icon-1 me-2"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                fill="black" />
                        </svg></span>
                    {{ __('common.Filters Bar') }}
                </button>
            </h4>
            <div id="kt_accordion_filters_body" class="accordion-collapse collapse {{ Cookie::get('dynacore_accordion_status') == 'opened' ? 'show' : '' }}" {{-- class="accordion-collapse collapse show" --}}
                aria-labelledby="kt_accordion_filters_header" data-bs-parent="#kt_accordion_filter">
                <div class="accordion-body px-9">
                    <div class="row">
                        @isset($filters['text_filters'])
                            @foreach ($filters['text_filters'] as $filter)
                                <div class="col-12 col-md-{{ $filter['cols'] ?? '4' }}">
                                    <input class="__searchable text-search form-control form-control-sm mb-5" type="text"
                                        name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                        value="{{ request()->query($filter['name']) }}"
                                        placeholder="{{ __($filter['label']) }}" />
                                </div>
                            @endforeach
                        @endisset

                        @isset($filters['select_filters'])
                            @foreach ($filters['select_filters'] as $filter)
                                <div class="col-12 col-md-{{ $filter['cols'] ?? '4' }}">
                                    <div class="input-group input-group-sm mb-5">
                                        <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                            class="__searchable_select form-select form-select-sm"
                                            data-placeholder=".:: {{ __($filter['default_option']) ?? __('common.All') }} ::."
                                            data-control="select2" data-allow-clear="true" data-hide-search="true">
                                            <option value=""></option>
                                            @foreach ($filter['options'] as $option)
                                                <option value="{{ $option['option_value'] }}" @selected($option['option_value'] == request($filter['name']))>
                                                    {{ __($option['option_label']) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        @endisset

                        @isset($filters['select_relation_filters'])
                            @foreach ($filters['select_relation_filters'] as $filter)
                                <div class="col-12 col-md-{{ $filter['cols'] ?? '4' }}">
                                    <div class="input-group input-group-sm mb-5">
                                        <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                            class="__searchable_select form-select form-select-sm" data-control="select2"
                                            data-allow-clear="true"
                                            data-placeholder=".:: {{ __($filter['default_option']) ?? __('common.All') }} ::.">
                                            <option value=""></option>
                                            @foreach ($filter['query'] as $model)
                                                <option value="{{ $model[$filter['options']['value_attr']] }}"
                                                    @selected($model[$filter['options']['value_attr']] == request($filter['name']))>
                                                    {{ $model[$filter['options']['label_attr']] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        @endisset


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






{{--
<div class="col-xl-12">
    <div class="card shadow-sm mb-5 mb-xl-8">
        <div class="card-header min-h-50px">
            <h4 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-700 fs-3">Filters Bar</span>
            </h4>
        </div>
        <div class="card-body pt-5 pb-10">
            <div class="row">
                @isset($filters['text_filters'])
                    @foreach ($filters['text_filters'] as $filter)
                        <div class="col-12 col-md-{{ $filter['cols'] ?? '4' }}">
                            <input class="__searchable text-search form-control form-control-sm mb-5" type="text"
                                name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                value="{{ request()->query($filter['name']) }}" placeholder="{{ $filter['label'] }}" />
                        </div>
                    @endforeach
                @endisset

                @isset($filters['select_filters'])
                    @foreach ($filters['select_filters'] as $filter)
                        <div class="col-12 col-md-{{ $filter['cols'] ?? '4' }}">
                            <div class="input-group input-group-sm mb-5">
                                <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                    class="__searchable_select form-select form-select-sm"
                                    data-placeholder=".:: {{ $filter['default_option'] ?? 'All' }} ::."
                                    data-control="select2" data-allow-clear="true" data-hide-search="true">
                                    <option value=""></option>
                                    @foreach ($filter['options'] as $option)
                                        <option value="{{ $option['option_value'] }}" @selected($option['option_value'] == request($filter['name']))>
                                            {{ $option['option_label'] }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    @endforeach
                @endisset

                @isset($filters['select_relation_filters'])
                    @foreach ($filters['select_relation_filters'] as $filter)
                        <div class="col-12 col-md-{{ $filter['cols'] ?? '4' }}">
                            <div class="input-group input-group-sm mb-5">
                                <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                                    class="__searchable_select form-select form-select-sm" data-control="select2"
                                    data-allow-clear="true"
                                    data-placeholder=".:: {{ $filter['default_option'] ?? 'All' }} ::.">
                                    <option value=""></option>
                                    @foreach ($relationModel as $model)
                                        <option value="{{ $model[$filter['options']['value_attr']] }}"
                                            @selected($model[$filter['options']['value_attr']] == request($filter['name']))>
                                            {{ $model[$filter['options']['label_attr']] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                @endisset


            </div>
        </div>
    </div>

</div> --}}
