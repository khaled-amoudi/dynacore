@props([
    'errors' => $errors,
])
@if (count($errors) > 0)
    <div @class(['alert border-0 alert-dismissible fade show py-2 bg-danger']) style="position: absolute; bottom: 10px; right: 20px; z-index: 99;">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-white"><i @class(['bi bi-x-circle-fill'])></i>
            </div>
            <div class="ms-3">
                <div class="text-white">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
