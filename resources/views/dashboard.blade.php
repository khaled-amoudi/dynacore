@extends('layouts.master')

@section('title', 'Dashboard')


@section('toolbar')
    <x-BaseComponents.layout.breadcrumb current_page="dashboard" />
@endsection


@section('content')
    <div class="row g-5 g-xl-8 mx-5 mx-md-9">
        <div class="col-xl-4">
            <!--begin: Statistics Widget 6-->
            <div class="card shadow-on-hover bg-light-success card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bolder text-success fs-5 mb-3 d-block">
                        {{ __('Project Progress') }}
                    </a>
                    <div class="py-1">
                        <span class="text-dark fs-1 fw-bolder me-2">50%</span>
                        <span class="fw-bold text-muted fs-7">{{ __('Average') }}</span>
                    </div>
                    <div class="progress h-7px bg-success bg-opacity-50 mt-7">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-4">
            <!--begin: Statistics Widget 6-->
            <div class="card shadow-on-hover bg-light-warning card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bolder text-warning fs-5 mb-3 d-block">{{ __('Company Finance') }}</a>
                    <div class="py-1">
                        <span class="text-dark fs-1 fw-bolder me-2">15%</span>
                        <span class="fw-bold text-muted fs-7">{{ __('48k Goal') }}</span>
                    </div>
                    <div class="progress h-7px bg-warning bg-opacity-50 mt-7">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 15%" aria-valuenow="50"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-4">
            <!--begin: Statistics Widget 6-->
            <div class="card shadow-on-hover bg-light-primary card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bolder text-primary fs-5 mb-3 d-block">{{ __('Marketing Analysis') }}</a>
                    <div class="py-1">
                        <span class="text-dark fs-1 fw-bolder me-2">76%</span>
                        <span class="fw-bold text-muted fs-7">{{ __('400k Impressions') }}</span>
                    </div>
                    <div class="progress h-7px bg-primary bg-opacity-50 mt-7">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 76%" aria-valuenow="50"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
    </div>
@endsection



@push('style')
    <style>
        .shadow-on-hover {
            transition: all 0.3s ease 0s;
        }

        .shadow-on-hover:hover {
            transition: "box-shadow" .3s ease-in-out;
            box-shadow: 0px 9px 16px 0px rgba(19, 53, 95, 0.192) !important;
        }
    </style>
@endpush
