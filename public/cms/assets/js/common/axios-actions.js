//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//Store

function x_store(url, data, redirectUrl = null) {
    // disable save button to prevent multi create
    const saveBtn = $('button[type="submit"]');
    saveBtn.prop("disabled", true);
    saveBtn.attr("data-kt-indicator", "on");

    axios
        .post(url, data)
        .then(function (response) {
            toastr_showMessage(response.data);

            if (redirectUrl != null) {
                var delay = 1750;
                setTimeout(function () {
                    window.location.href = redirectUrl;
                }, delay);
            }
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
                alert_showErrors(error.response.data.errors);
                // showErrorMessages(error.response.data.errors);

            } else {
                toastr_showMessage(error.response.data);
            }
        })
        .then(function () {
            setTimeout(function () {
                saveBtn.prop("disabled", false);
                saveBtn.removeAttr("data-kt-indicator");
            }, 2000);
        });
}
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//Store and keep storing

function x_store_cont(url, data) {
    // disable save button to prevent multi create
    const saveBtn = $('button[type="submit"]');
    saveBtn.prop("disabled", true);
    saveBtn.attr("data-kt-indicator", "on");

    axios
        .post(url, data)
        .then(function (response) {
            toastr_showMessage(response.data);
            setTimeout(function () {
                clearForm();
            }, 2000);
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
                alert_showErrors(error.response.data.errors);
            } else {
                toastr_showMessage(error.response.data);
            }
        })
        .then(function () {
            setTimeout(function () {
                saveBtn.prop("disabled", false);
                saveBtn.removeAttr("data-kt-indicator");
            }, 2000);
        });
}
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//Update

function x_update(url, data, redirectUrl = null) {
    // disable save button to prevent multi create
    const saveBtn = $('button[type="submit"]');
    saveBtn.prop("disabled", true);
    saveBtn.attr("data-kt-indicator", "on");

    axios
        .post(url, data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then(function (response) {
            toastr_showMessage(response.data);

            if (redirectUrl != null) {
                var delay = 1750;
                setTimeout(function () {
                    window.location.href = redirectUrl;
                    // loadContent(redirectUrl);
                }, delay);
            }
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
                alert_showErrors(error.response.data.errors);
            } else {
                toastr_showMessage(error.response.data);
            }
        })
        .then(function () {
            setTimeout(function () {
                saveBtn.prop("disabled", false);
                saveBtn.removeAttr("data-kt-indicator");
            }, 2000);
        });
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Delete

function x_delete(url, id) {
    axios
        .delete(url)
        .then(function (response) {
            $("tr.del_" + id).addClass("table-row-deleted");

            setTimeout(function () {
                $("tr.del_" + id).remove();

                // re draw the table after delete, to show the correct pagination.
                $("#kt_datatable_example_1").DataTable().draw(false); // true: reset to the first page
            }, 500);
            toastr_showMessage(response.data);
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
            } else {
                toastr_showMessage(error.response.data);
            }
        })
        .then(function () {
            // always executed
        });
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Force Delete

function x_force_delete(url, id) {
    axios
        .delete(url)
        .then(function (response) {
            $("tr.del_" + id).addClass("table-row-deleted");

            setTimeout(function () {
                $("tr.del_" + id).remove();

                // re draw the table after delete, to show the correct pagination.
                $("#kt_datatable_example_1").DataTable().draw(false); // true: reset to the first page
            }, 500);
            toastr_showMessage(response.data);
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
            } else {
                toastr_showMessage(error.response.data);
            }
        })
        .then(function () {
            // always executed
        });
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Restore

function x_restore(url, id) {
    axios
        .put(url)
        .then(function (response) {
            $("tr.del_" + id).addClass("table-row-deleted");

            setTimeout(function () {
                $("tr.del_" + id).remove();

                // re draw the table after delete, to show the correct pagination.
                $("#kt_datatable_example_1").DataTable().draw(false); // true: reset to the first page
            }, 500);
            toastr_showMessage(response.data);
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
            } else {
                toastr_showMessage(error.response.data);
            }
        })
        .then(function () {
            // always executed
        });
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Delete Multi Rows Of The Table

// multiDelete();
// function multiDelete() {
//     $(".multiDeleteCheckbox").change(function () {
//         const multiDeleteButton = $(".multiDeleteButton");

//         if ($(this).is(":checked")) {
//             multiDeleteButton.show();
//         } else {
//             multiDeleteButton.hide();
//         }
//     });
// }

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Delete Group Of Records

function x_delete_group(url, selected_ids) {
    axios
        .delete(url, {
            data: {
                selected_ids: selected_ids,
            },
        })
        .then(function (response) {
            // hide records after delete
            selected_ids.forEach(function (recordId) {
                $("tr.del_" + recordId).addClass("table-row-deleted");
                setTimeout(function () {
                    $("tr.del_" + recordId).remove();
                    $(".multiDeleteButton").hide();
                    $("#kt_datatable_example_1").DataTable().draw(false);
                }, 500);
            });
            toastr_showMessage(response.data);
        })
        .catch(function (error) {
            toastr_showMessage(error.response.data);
        })
        .then(function (response) {
            $("#kt_modal_multi_delete").modal("hide");
        });
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Toggle Switch Status (is_active = [1 or 0])

function x_editableSwitch(url, name, id) {
    const switcher = document.getElementById(name + "_" + id);
    switcher.disabled = true;

    setTimeout(function () {
        axios
            .post(url)
            .then(function (response) {
                toastr_showMessage(response.data);
                switcher.checked = !switcher.checked;
            })
            .catch(function (error) {
                toastr_showMessage(error.response.data);
                switcher.checked = switcher.checked;
            })
            .then(function () {
                // always executed
                switcher.disabled = false;
            });
    }, 750);
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Clear form of data
function clearForm() {
    $("#create_form").trigger("reset");
}
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// show error message under each input
function showErrorMessages(errors) {
    for (let field in errors) {
        let inputElement = document.querySelector(`[name="${field}"]`);
        let errorMessage = errors[field][0];

        // Create a span element for the error message
        let errorElement = document.createElement('span');
        errorElement.className = 'text-danger'; // Add Bootstrap class for red text
        errorElement.innerText = errorMessage;

        // Insert the error message after the input element
        if (inputElement) {
            inputElement.classList.add('is-invalid'); // Add Bootstrap class for red border
            inputElement.parentNode.appendChild(errorElement);
        }
    }
}

