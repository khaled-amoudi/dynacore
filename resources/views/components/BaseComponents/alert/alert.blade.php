@props([
    'type' => 'other',
])
@if (session()->has($type))
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toastr-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if($type == 'success')
        toastr.success("{{ Session::get('success') }}", 'Success!', {
            timeOut: 12000
        });
        @elseif ($type == 'fail')
        toastr.error("{{ Session::get('fail') }}", 'Fail!', {
            timeOut: 12000
        });
        @else
        toastr.info("{{ Session::get('other') }}", {
            timeOut: 12000
        });
        @endif
    </script>
@endif
    {{-- <div @class(['alert border-0 alert-dismissible fade show py-2',
        'bg-success' => $type == 'success',
        'bg-danger' => $type == 'fail',
        'bg-dark' => $type == 'other',])
        style="position: absolute; bottom: 10px; right: 20px; z-index: 99;">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-white"><i
            @class(['', 'bi bi-check-circle-fill' => $type == 'success',
            'bi bi-x-circle-fill' => $type == 'fail'])></i>
            </div>
            <div class="ms-3">
                <div class="text-white">{{ session($type) }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> --}}

{{-- @if (Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toastr-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.success("{{ Session::get('success') }}", 'Success!', {
            timeOut: 12000
        });
    </script>
@endif --}}
