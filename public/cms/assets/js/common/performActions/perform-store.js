function performStore() {
    event.preventDefault();

    const form = document.getElementById("create_form");
    const url = form.getAttribute("action");
    const redirectUrl = form.getAttribute("redirectto");
    let formData = new FormData();

    for (let i = 0; i < data.length; i++) {
        let item = data[i];
        console.log(item);

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
            } else if (inputType === "radio") {
                const checkedRadio = document.querySelector(
                    'input[name="' + inputId + '"]:checked'
                );
                if (checkedRadio) {
                    formData.append(inputId, checkedRadio.value);
                }
            } else if (inputType === "checkbox") {
                const checkedCheckboxes = document.querySelectorAll(
                    'input[name="' + inputId + '[]"]:checked'
                );
                checkedCheckboxes.forEach((checkbox) => {
                    formData.append(inputId + "[]", checkbox.value);
                });
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

                tagsElement.querySelectorAll("tag").forEach((tagElement) => {
                    codesArray.push(tagElement.getAttribute("value"));
                });

                formData.append(inputId, JSON.stringify(codesArray));
            }
            // else if (inputType === "array") {
            //     // Get the tags input value as an array
            //     let tagsArray = [];
            //     let tagsInput = document.getElementsByName('tags' + '[]');
            //     for (let j = 0; j < tagsInput.length; j++) {
            //         tagsArray.push(tagsInput[j].value);
            //     }
            //     // Append the tags array to the FormData object
            //     // formData.append(inputId, tagsArray);
            //     formData.append(inputId, JSON.stringify(tagsArray));
            //     console.log(JSON.stringify(tagsArray));

            // }
        }
    }
    x_store(url, formData, redirectUrl);
    // x_store_cont(url, formData);
    // x_spa_store(url, formData, redirectUrl);
}

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

function performStoreAndCont() {
    event.preventDefault();

    const form = document.getElementById("create_form");
    const url = form.getAttribute("action");
    const redirectUrl = form.getAttribute("redirectto");
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
            }
        }
    }
    // x_store(url, formData, redirectUrl);
    x_store_cont(url, formData);
    // x_spa_store(url, formData, redirectUrl);
}
