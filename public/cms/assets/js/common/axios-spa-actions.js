//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Store (redirect to the next page as a SPA [without refresh] using XMLHttpRequest)

function x_spa_store(url, data, redirectUrl = null) {
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
                    loadContent(redirectUrl).then(function() {
                        $("#kt_datatable_example_1").DataTable().draw(false);
                    }).catch(function(error) {
                        console.error(error);
                    });
                    // loadContent(redirectUrl).then(function() {
                    //     $("#kt_datatable_example_1").DataTable().draw(false);
                    // });
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
// Update (redirect to the next page as a SPA [without refresh] using XMLHttpRequest)

function x_spa_update(url, data, redirectUrl = null) {
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
                    loadContent(redirectUrl);
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
function loadContent2(url) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the content
                var newContent = xhr.responseText;
                document.getElementById("kt_body").innerHTML = newContent;
                // Update the URL without refresh
                history.pushState({}, "", url);

                // Resolve the promise
                resolve();
            } else {
                // If there's an error, reject the promise
                reject("Failed to load content. Status: " + xhr.status);
            }
        };

        xhr.onerror = function () {
            // If there's a network error, reject the promise
            reject("Network error.");
        };

        xhr.send();
    });
}
// Function to load content without page refresh
function loadContent(url, callback = null) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            // update the content
            var newContent = xhr.responseText;
            document.getElementById("kt_body").innerHTML = newContent;
            // Update the URL without refresh
            history.pushState({}, "", url);

            // Call the callback function (we use it to initialize the datatable after redirect to index page)
            if (callback && typeof callback === "function") {
                callback();
            }
        }
    };
    xhr.send();
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//Update (fetch the next redirect page while toaster is runing => high performance)

// load the content of redirect page while showing the toaster, it will make the reload faster
function x_spa_alpha_update(url, data, redirectUrl = null) {
    // disable save button to prevent multi create
    const saveBtn = $('button[type="submit"]');
    saveBtn.prop("disabled", true);

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
                // After the delay, fetch the content and files
                fetchContentAndFiles(redirectUrl).then(function (content) {
                    // Hide loading message
                    setTimeout(function () {
                        // Display the fetched content
                        displayContent(content);

                        // Redirect to the new page
                        // window.location.href = redirectUrl;
                        history.pushState({}, "", url);
                    }, delay);
                });
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
            }, 2000);
        });
}

// // Function to fetch content and files from the new page
function fetchContentAndFiles(url) {
    return fetch(url)
        .then(function (response) {
            if (response.ok) {
                return response.text();
            } else {
                // throw new Error("Failed to fetch content");
                loadContent(url);
            }
        })
        .catch(function (error) {
            // console.error(error);
            loadContent(url);
        });
}
// Function to display fetched content
function displayContent(content) {
    // document.body.innerHTML = content;
    document.getElementById("kt_body").innerHTML = content;
}


//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Clear form of data
function clearForm() {
    $("#create_form").trigger("reset");
}
