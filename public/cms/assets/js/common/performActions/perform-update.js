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
            }
        }
    }
    x_update(url, formData, redirectUrl);
}
