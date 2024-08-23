//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Store (redirect to the next page as a SPA [without refresh] using XMLHttpRequest)

function x_spa_store(url, data, redirectUrl = null) {
    // disable save button to prevent multi create
    const saveBtn = $('button[type="submit"]');
    saveBtn.prop("disabled", true);

    axios
        .post(url, data)
        .then(function (response) {
            toastr_showMessage(response.data);
            if (redirectUrl != null) {
                var delay = 1750;
                setTimeout(function () {
                    loadContent(redirectUrl, function () {
                        // call the function that get the datatable in index page
                        initializeDataTable();
                    });
                }, delay);
            }
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
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

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Update (redirect to the next page as a SPA [without refresh] using XMLHttpRequest)

function x_spa_update(url, data, redirectUrl = null) {
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
                setTimeout(function () {
                    loadContent(redirectUrl);
                }, delay);
            }
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                toastr_showErrors(error.response.data.errors);
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

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

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
    // document.getElementById("create_form").reset();
}
