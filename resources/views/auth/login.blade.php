@extends('auth.auth')

@push('css')
@endpush

@section('content')
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('login') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">Sign In to {{ config('app.name', 'Laravel') }}</h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-400 fw-bold fs-4">New Here?
                <a href="{{ route('register') }}" class="link-primary fw-bolder">Create an Account</a>
            </div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Email') }}</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input class="form-control form-control-lg form-control-solid" id="email" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Password') }}</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input id="password" class="form-control form-control-lg form-control-solid" type="password" name="password"
                required autocomplete="current-password" />
            <!--end::Input-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mt-2">
                <!--begin::Label-->
                <label class="form-label fw-bolder text-dark fs-6 mb-0"></label>
                <!--end::Label-->
                <!--begin::Link-->
                @if (Route::has('password.request'))
                    <a class="link-primary fs-6 fw-bolder" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <!--end::Link-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Input group-->
        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Submit button-->
            <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">{{ __('Log in') }}</span>
                {{-- <span class="indicator-progress">Please wait...
             <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> --}}
            </button>
            <!--end::Submit button-->
            <!--begin::Google link-->
            {{-- <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                <img alt="Logo" src="{{ asset('cms/assets/media/svg/brand-logos/google-icon.svg') }}"
                    class="h-20px me-3" />Continue with Google</a> --}}
            <!--end::Google link-->
            <!--begin::Google link-->
            {{-- <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                <img alt="Logo" src="{{ asset('cms/assets/media/svg/brand-logos/facebook-4.svg') }}"
                    class="h-20px me-3" />Continue with Facebook</a> --}}
            <!--end::Google link-->
            <!--begin::Google link-->
            {{-- <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100">
                <img alt="Logo" src="{{ asset('cms/assets/media/svg/brand-logos/apple-black.svg') }}"
                    class="h-20px me-3" />Continue with Apple</a> --}}
            <!--end::Google link-->
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
@endsection

@push('js')
    <script src="{{ asset('cms/assets/js/custom/authentication/sign-in/general.js') }}"></script>
@endpush
