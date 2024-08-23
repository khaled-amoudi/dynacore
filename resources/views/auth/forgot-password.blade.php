@extends('auth.auth')

@push('css')
@endpush

@section('content')
     <!--begin::Form-->
     <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">Forgot Password ?</h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-400 fw-bold fs-4">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-gray-900 fs-6">{{ __('Email') }}</label>
            <input id="email" class="form-control form-control-solid" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </div>
        <!--end::Input group-->
        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" class="btn btn-lg btn-primary fw-bolder me-4">
                <span class="indicator-label">{{ __('Email Password Reset Link') }}</span>
                <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
@endsection

@push('js')
<script src="{{ asset('cms/assets/js/custom/authentication/password-reset/password-reset.js') }}"></script>
@endpush
