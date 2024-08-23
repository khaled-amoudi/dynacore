@isset($export_pdf)
    <a href="{{ route($export_pdf['route_name']) }}" target="_blank" type="button"
        class="btn btn-sm alert-danger border-0 shadow-sm px-2 ms-1 mb-2 mb-md-0">
        <span>
            <i class="bx bxs-file-pdf me-1 font-20"></i>
        </span>
        Export PDF
    </a>
@endisset

@isset($export_excel)
    <a href="{{ route($export_excel['route_name']) }}" type="button"
        class="btn btn-sm alert-success border-0 shadow-sm px-2 ms-1 mb-2 mb-md-0">
        <span>
            <i class="bx bxs-file me-1 font-20"></i>
        </span>
        Export Excel
    </a>
@endisset
@isset($import_excel)
    <a href="#" type="button" class="btn btn-sm alert-warning border-0 shadow-sm px-2 ms-1 mb-2 mb-md-0" data-bs-toggle="modal"
        data-bs-target="#exampleModal{{ $tabel_data['table_title'] }}">
        <span>
            <i class="bx bxs-file me-1 font-20"></i>
        </span>
        Import Excel
    </a>
    <div class="modal fade" id="exampleModal{{ $tabel_data['table_title'] }}" tabindex="-1"
        aria-labelledby="exampleModalLabel{{ $tabel_data['table_title'] }}" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{ $tabel_data['table_title'] }}">Modal
                    title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div> --}}
                <div class="modal-body d-flex flex-column justify-content-center py-5">
                    @isset($export_excel_demo)
                        <a href="{{ route($export_excel_demo['route_name']) }}" class="btn btn-primary btn-block mb-2">
                            <i class="lni lni-download mx-3"></i>Download Empty Excel File</a>
                    @endisset
                            <hr>
                    <form action="{{ route($import_excel['route_name']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column">
                            <x-BaseComponents.form.common.file_upload_button name="import_file" label="Attach Excel File" />
                            <button type="submit" class="btn btn-dark mt-2">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endisset
