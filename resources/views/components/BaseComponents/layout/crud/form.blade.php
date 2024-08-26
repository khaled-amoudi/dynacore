<div class="card-header">
    <h3 class="card-title align-items-start text-gray-700 fw-bold flex-column">
        {{ __($formTitle) }}
    </h3>
    <div class="card-toolbar kh_form-card-toolbar">
        <div class="kh_breadcrumb_move">
            <a href="{{ url()->previous() }}" class="btn btn-cancel text-gray-600 shadow px-3 mx-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>{{ __('common.Cancel') }}</span>
            </a>
            {{-- <x-BaseComponents.form.common.submit_button /> --}}
            <button type="submit" class="btn btn-primary shadow">
                <span class="indicator-label svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z"
                            fill="black"></path>
                    </svg>
                    @if (isset($saveAndCont) && $saveAndCont == true)
                        {{ __('common.save_and_cont') }}
                    @else
                        {{ __('common.save') }}
                    @endif

                </span>
                <span class="indicator-progress">
                    {{ __('common.saving') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="row">

        {{ $slot }}

    </div>
</div>
