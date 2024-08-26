function performUpdate(id) {
    event.preventDefault();

    const form = document.getElementById('update_form');
    const url = form.getAttribute('action');
    const redirectUrl = form.getAttribute('redirectto');

    let formData = new FormData();

    for (let i = 0; i < data.length; i++) {
        let item = data[i];

        if (!Array.isArray(item)) {
            // If it's not an array, treat it as a regular input type
            formData.append(item, document.getElementById(item).value);
        } else {
            let inputId = item[0];
            let inputType = item[1];

            // Perform custom edits based on the inputType
            if (inputType === "switch") {
                formData.append(
                    inputId,
                    document.getElementById(inputId).checked ? 1 : 0
                );
            } else if (inputType === "image") {
                if (document.getElementById(inputId).files[0]) {
                    formData.append(
                        inputId,
                        document.getElementById(inputId).files[0]
                    );
                }
            } else if (inputType === "file") {
                if (document.getElementById(inputId).files[0]) {
                    formData.append(
                        inputId,
                        document.getElementById(inputId).files[0]
                    );
                }
            } else if (inputType === "tagify") {
                let inputElement = document.querySelector("#" + item);
                let tagsElement = inputElement.previousElementSibling;
                let codesArray = [];

                tagsElement.querySelectorAll('tag').forEach(tagElement => {
                    codesArray.push(tagElement.getAttribute('value'));
                });

                formData.append(inputId, JSON.stringify(codesArray));
            } else if (inputType === "repeater") {
                console.log('repeater id: kh_repeater_' + inputId);

                document.querySelectorAll('.kh_repeater').forEach(function(repeater) {
                    let repeaterListElement = repeater.querySelector('[data-repeater-list]');
                    let repeaterListName = repeaterListElement.getAttribute('data-repeater-list');
                    let repeaterItems = repeater.querySelectorAll('[data-repeater-item]');

                    repeaterItems.forEach(function(item, index) {
                        item.querySelectorAll('input, select, textarea').forEach(function(field) {
                            console.log(field.getAttribute('name'));

                            let fieldName = field.getAttribute('name').split('[').pop().replace(']', ''); //field.getAttribute('name');
                            let fieldValue = field.value;

                            // Create the form data key in the format `repeaterName[index][fieldName]`
                            let formDataKey = `${repeaterListName}[${index}][${fieldName}]`;

                            // Append the field to the formData object
                            formData.append(formDataKey, fieldValue);
                        });
                    });
                });
            } else if (inputType === "repeater_table") {
                const tableRows = document.querySelectorAll(
                    ".dynamic-table tbody tr"
                );
                tableRows.forEach((row, rowIndex) => {
                    row.querySelectorAll("input").forEach(
                        (field) => {
                            let fieldName = field
                                .getAttribute("name")
                                .replace(/^.*?\[(\d+)\]/, "");
                            let fieldValue = field.value;

                            // Construct the formDataKey to include rowIndex and the fieldName
                            let formDataKey = `${inputId}[${rowIndex}]${fieldName}`;

                            // Append the field's value to the formData object
                            formData.append(formDataKey, fieldValue);
                        }
                    );
                });
            }
        }
    }
    x_update(url, formData, redirectUrl);
}
