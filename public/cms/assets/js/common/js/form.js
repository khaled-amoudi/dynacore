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
