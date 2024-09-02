document.addEventListener("DOMContentLoaded", function () {
    // Function to handle the showing/hiding of conditional inputs
    function handleConditionalInput(
        element,
        controllingElement,
        conditionValue
    ) {
        const showElement = () => {
            if (element.style.display === "none") {
                element.style.display = "block";
                element.style.opacity = 0;
                element.style.pointerEvents = "auto"; // Enable interaction
                let opacity = 0;
                const fadeInInterval = setInterval(() => {
                    if (opacity >= 1) {
                        clearInterval(fadeInInterval);
                    } else {
                        opacity += 0.1;
                        element.style.opacity = opacity;
                    }
                }, 30);
            }
        };

        const hideElement = () => {
            let opacity = 1;
            const fadeOutInterval = setInterval(() => {
                if (opacity <= 0) {
                    clearInterval(fadeOutInterval);
                    element.style.display = "none";
                    element.style.pointerEvents = "none"; // Disable interaction
                    element.setAttribute("disabled", "disabled"); // Disable the input
                } else {
                    opacity -= 0.1;
                    element.style.opacity = opacity;
                }
            }, 30);
        };

        const evaluateCondition = () => {
            if (controllingElement.type === "checkbox") {
                // For checkboxes, check if the state matches the condition value
                if (controllingElement.checked.toString() === conditionValue) {
                    showElement();
                } else {
                    hideElement();
                }
            } else if (
                controllingElement.type === "select-one" ||
                controllingElement.type === "text"
            ) {
                // For select and text inputs, compare the value
                if (controllingElement.value === conditionValue) {
                    showElement();
                } else {
                    hideElement();
                }
            } else if (controllingElement.type === "radio") {
                // Get all radio buttons with the same name
                const radios = document.getElementsByName(
                    controllingElement.name
                );
                let isMatching = false;
                radios.forEach((radio) => {
                    if (radio.checked && radio.value === conditionValue) {
                        isMatching = true;
                    }
                });
                if (isMatching) {
                    showElement();
                } else {
                    hideElement();
                }
            }
        };

        // Initial evaluation on page load
        evaluateCondition();

        // Add event listener for changes
        if (controllingElement.type === "radio") {
            document
                .getElementsByName(controllingElement.name)
                .forEach((radio) => {
                    radio.addEventListener("change", evaluateCondition);
                });
        } else {
            controllingElement.addEventListener("change", evaluateCondition);
        }
    }

    document.querySelectorAll(".conditional-input").forEach(function (element) {
        const conditionId = element.getAttribute("data-condition-id");
        const conditionValue = element.getAttribute("data-condition-value");

        const controllingElement = document.getElementById(conditionId);
        if (controllingElement) {
            handleConditionalInput(element, controllingElement, conditionValue);
        }
    });
});

// used to collect data from the form in perform-store and perform-update
function handleDataCollection(data, formData) {
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
            } else if (inputType === "repeater") {
                document
                    .querySelectorAll(".kh_repeater")
                    .forEach(function (repeater) {
                        let repeaterListElement = repeater.querySelector(
                            "[data-repeater-list]"
                        );
                        let repeaterListName =
                            repeaterListElement.getAttribute(
                                "data-repeater-list"
                            );
                        let repeaterItems = repeater.querySelectorAll(
                            "[data-repeater-item]"
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
                                let formDataKey = `${repeaterListName}[${index}]${fieldName}`;

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
}
