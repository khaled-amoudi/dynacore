//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// delete single row (main delete action)
function performDelete(id) {
    // this will prevent the black screen response from being shown
    event.preventDefault();

    const form = document.getElementById("delete_form_" + id);
    const url = form.getAttribute("action");

    $("#kt_modal_" + id).modal("hide");

    $.ajax({
        url: url,
        type: 'DELETE',
        success: function(result) {
            // On successful deletion, redraw the table
            $('#kt_datatable_example_1').DataTable().draw(true); // true: to refresh the table after delete an item
        },
        error: function(xhr) {
            // Handle error
            console.error("Deletion failed:", xhr.responseText);
        }
    });

    x_delete(url, id);
}

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// delete single row from Trash (force delete)
function performForceDelete(id) {
    // this will prevent the black screen response from being shown
    event.preventDefault();

    const form = document.getElementById("delete_form_" + id);
    const url = form.getAttribute("action");

    $("#kt_modal_" + id).modal("hide");

    x_force_delete(url, id);
}

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// Restore row
function performRestore(id) {
    // this will prevent the black screen response from being shown
    event.preventDefault();

    const form = document.getElementById("restore_form_" + id);
    const url = form.getAttribute("action");

    x_restore(url, id);
}

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// show/hide btn of delete all
$(document).ready(function () {
    $(document).on("change", ".multiDeleteCheckbox", function () {
        const checkboxes = $(".multiDeleteCheckbox");
        const multiDeleteButton = $(".multiDeleteButton");

        const atLeastOneChecked = checkboxes.is(":checked");

        if (atLeastOneChecked) {
            multiDeleteButton.show();
        } else {
            multiDeleteButton.hide();
        }
    });
});

function confirmDeleteAll() {
    const selectedItems = document.querySelectorAll(".deletegroup:checked");
    const selected_ids = Array.from(selectedItems).map((item) => item.value);
    x_delete_group("/dashboard/" + resourceName + "/delete-all", selected_ids);
}
// function confirmTrashAll() {
//     const selectedItems = document.querySelectorAll(".deletegroup:checked");
//     const selected_ids = Array.from(selectedItems).map(item => item.value);
//     x_delete_group("/dashboard/category/trash-all", selected_ids);
// }

//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// edit the switch
function editableSwitch(id) {
    event.preventDefault();

    x_editableSwitch(
        "/dashboard/" + resourceName + "/update-status/" + id,
        "is_active",
        id
    );
}
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
