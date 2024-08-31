function performModalStore(modal_resource, ajax_for_new_options, name) {
    event.preventDefault();

    console.log("performModalStore() function start");

    const form = document.getElementById("modal_create_form_" + modal_resource);
    const url = form.getAttribute("action");
    const data = JSON.parse(form.getAttribute("formData"));
    let modalFormData = new FormData();

    console.log(url, data, modalFormData);

    for (let i = 0; i < data.length; i++) {
        let item = data[i];
        // console.log(item);

        console.log(item);

        if (!Array.isArray(item)) {
            // If it's not an array, treat it as a regular input type
            modalFormData.append(item, form.querySelector("#" + item).value);
        } else {
            let inputId = item[0];
            let inputType = item[1];

            // Perform custom edits based on the inputType
            if (inputType === "switch") {
                modalFormData.append(
                    inputId,
                    form.querySelector("#" + inputId).checked ? 1 : 0
                );
            } else if (inputType === "radio") {
                const checkedRadio = form.querySelector(
                    'input[name="' + inputId + '"]:checked'
                );
                if (checkedRadio) {
                    modalFormData.append(inputId, checkedRadio.value);
                }
            } else if (inputType === "checkbox") {
                const checkedCheckboxes = form.querySelectorAll(
                    'input[name="' + inputId + '[]"]:checked'
                );
                checkedCheckboxes.forEach((checkbox) => {
                    modalFormData.append(inputId + "[]", checkbox.value);
                });
            } else if (inputType === "image") {
                if (form.querySelector("#" + inputId).files[0]) {
                    modalFormData.append(
                        inputId,
                        form.querySelector("#" + inputId).files[0]
                    );
                }
            } else if (inputType === "file") {
                if (form.querySelector("#" + inputId).files[0]) {
                    modalFormData.append(
                        inputId,
                        form.querySelector("#" + inputId).files[0]
                    );
                }
            } else if (inputType === "tagify") {
                let inputElement = form.querySelector("#" + item);
                let tagsElement = inputElement.previousElementSibling;
                let codesArray = [];

                tagsElement.querySelectorAll("tag").forEach((tagElement) => {
                    codesArray.push(tagElement.getAttribute("value"));
                });

                modalFormData.append(inputId, JSON.stringify(codesArray));
            } else if (inputType === "repeater") {
                // console.log('repeater id: kh_repeater_' + inputId);

                form.querySelectorAll(".kh_repeater").forEach(function (
                    repeater
                ) {
                    let repeaterListElement = repeater.querySelector(
                        "[data-repeater-list]"
                    );
                    let repeaterListName =
                        repeaterListElement.getAttribute("data-repeater-list");
                    let repeaterItems = repeater.querySelectorAll(
                        "[data-repeater-item]"
                    );

                    console.log(
                        "repeaterListElement: " + repeaterListElement,
                        "repeaterListName: " + repeaterListName,
                        "repeaterItems: " + repeaterItems
                    );

                    repeaterItems.forEach(function (item, index) {
                        item.querySelectorAll(
                            "input, select, textarea"
                        ).forEach(function (field) {
                            // let fieldName = field.getAttribute('name'); // field.getAttribute('name').split('[').pop().replace(']', '');
                            let fieldName = field
                                .getAttribute("name")
                                .replace(/^.*?\[(\d+)\]/, "")
                                .replace(/\[\]$/, "");
                            let fieldValue = field.value;

                            // Create the form data key in the format `repeaterName[index][fieldName]`
                            let modalFormDataKey = `${repeaterListName}[${index}]${fieldName}`;

                            // Append the field to the modalFormData object
                            modalFormData.append(modalFormDataKey, fieldValue);
                        });
                    });
                });
            } else if (inputType === "repeater_table") {
                const tableRows = form.querySelectorAll(
                    ".dynamic-table tbody tr"
                );
                tableRows.forEach((row, rowIndex) => {
                    row.querySelectorAll("input").forEach((field) => {
                        let fieldName = field
                            .getAttribute("name")
                            .replace(/^.*?\[(\d+)\]/, "");
                        let fieldValue = field.value;

                        // Construct the modalFormDataKey to include rowIndex and the fieldName
                        let modalFormDataKey = `${inputId}[${rowIndex}]${fieldName}`;

                        // Append the field's value to the modalFormData object
                        modalFormData.append(modalFormDataKey, fieldValue);
                    });
                });
            }
        }
    }
    x_modal_store(modal_resource, url, modalFormData, ajax_for_new_options, name);
}

function x_modal_store(
    modal_resource,
    url,
    modalFormData,
    ajax_for_new_options,
    name
) {
    // disable save button to prevent multi create
    const modalSaveBtn = $("#submit_modal_create_form_" + modal_resource);
    modalSaveBtn.prop("disabled", true);
    modalSaveBtn.attr("data-kt-indicator", "on");

    axios
        .post(url, modalFormData)
        .then(function (response) {
            toastr_showMessage(response.data);
            $("#" + modal_resource).modal("hide");

            axios
                .get(ajax_for_new_options)
                .then(function (response) {
                    console.log('enter fetch options');
                    const selectInput = document.getElementById(name);
                    const options = response.data;

                    // Clear the current options
                    selectInput.innerHTML = "";
                    // Populate the select with new options
                    for (const [id, label] of Object.entries(options)) {
                        const newOption = new Option(
                            label,
                            id
                        );
                        selectInput.add(newOption);
                    }
                    selectInput.selectedIndex = selectInput.options.length - 1;
                    selectInput.dispatchEvent(new Event("change")); // Trigger change event for the select input
                })
                .catch(function (error) {
                    console.error("Error fetching options:", error);
                });
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
                modal_alert_showErrors(error.response.data.errors);
            } else {
                toastr_showMessage(error.response.data);
            }
        })
        .then(function () {
            setTimeout(function () {
                modalSaveBtn.prop("disabled", false);
                modalSaveBtn.removeAttr("data-kt-indicator");
            }, 2000);
        });
}
