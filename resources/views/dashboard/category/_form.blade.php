<x-BaseComponents.layout.crud.form :formTitle="$formTitle" :saveAndCont="$saveAndCont ?? null">

    <x-BaseComponents.form.common.input cols="12" type="text" id="name" name="name" :model="$model" />

    <x-BaseComponents.form.common.textarea name="description" id="description" :model="$model" rows="3"
        label="description" placeholder="enter description" />

    {{-- <x-BaseComponents.form.common.switch name="is_active" :model="$model" label="Is Active" /> --}}
    <x-BaseComponents.form.common.switch :model="$model" />

    <x-BaseComponents.form.common.image name="image" id="image" :model="$model" />


    {{-- <div class="mb-7 col-12 col-sm-12">
        <div id="tagsContainer" class="mb-7 col-12 col-sm-4">
            <label class="form-label">Tags:</label>
            <div class="tagInput my-2 d-flex">
                <input type="text" name="tags[]" class="form-control">
                <button type="button" class="btn btn-danger mx-2 removeTag">Delete</button>
            </div>
            <a class="my-3 btn btn-primary" id="addTag">Add Tag</a>
        </div>
    </div> --}}


</x-BaseComponents.layout.crud.form>


{{-- @push('script')
    <script>
        $(document).ready(function() {
            $('#addTag').click(function() {
                var tagInput = $(
                    '<div class="tagInput my-2 d-flex"><input type="text" name="tags[]" class="form-control" required><button type="button" class="btn btn-danger mx-2 removeTag">Delete</button></div>'
                );
                $('#tagsContainer').append(tagInput);
            });

            $('#tagsContainer').on('click', '.removeTag', function() {
                $(this).parent('.tagInput').remove();
            });
        });
    </script>
@endpush --}}
