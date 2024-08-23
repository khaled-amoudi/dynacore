<div class="form-check form-switch form-check-custom form-check-success form-check-solid">
    <input name="is_active" onclick="editableSwitch({{ $id }})"
        class="editable-switch form-check-input h-40px w-60px" type="checkbox" id="{{ 'is_active_' . $id }}"
        @checked($is_active == 1) />
    <label class="form-check-label d-none" for="is_active">{{ $is_active == 1 ? 'Active' : 'Not Active'}}</label>
</div>
