@props([
    'unique_key',
    'icon_class_show' => 'bi bi-eye-fill text-primary',
])

<a href="#" type="button" class="btn btn-sm p-0 m-0" data-bs-toggle="modal"
    data-bs-target="#exampleModalAction{{ $unique_key }}show" data-bs-original-title="Show" aria-label="Show">
    <i class="{{ $icon_class_show }}"></i>
</a>
<div class="modal fade" id="exampleModalAction{{ $unique_key }}show" tabindex="-1"
    aria-labelledby="exampleModalActionLabel{{ $unique_key }}show" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalActionLabel{{ $unique_key }}show"></h5>
                <button type="button" class="btn-close bg-danger text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
