function storeRoute(url, data) {
    axios
        .post(url, data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then(function (response) {
            window.location = response.data.redirect;
            // showMessage(response.data);
            // clearForm();
            // clearAndHideErrors();
        })
        .catch(function (error) {
            if (error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else {
                showMessage(error.response.data);
            }
        });
}


function update(url, data, redirectUrl) {
    axios
        .put(url, data)

        .then(function (response) {
            console.log(response);

            if (redirectUrl != null) window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updateRoute(url, data) {
    axios
        .put(url, data)

        .then(function (response) {
            console.log(response);

            window.location = response.data.redirect;
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updateReload(url, data, redirectUrl) {
    axios
        .put(url, data)
        .then(function (response) {
            console.log(response);
            location.reload();
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updatePage(url, data) {
    axios
        .post(url, data)
        .then(function (response) {
            console.log(response);
            location.reload();
            // showMessage(response.data);
        })
        .catch(function (error) {
            console.log(error.response);
        });
}


function destroy(url, td) {
    axios
        .delete(url)
        .then(function (response) {
            // handle success
            console.log(response.data);
            td.closest("tr").remove();
            // showToaster(response.data.message, true);
        })
        .catch(function (error) {
            // handle error
            console.log(error.response);
            // showToaster(error.response.data.message, false);
        })
        .then(function () {
            // always executed
        });
}


// function showErrorMessages(errors) {
//     document.getElementById("error_alert").hidden = false;
//     var errorMessagesUl = document.getElementById("error_messages_ul");
//     errorMessagesUl.innerHTML = "";

//     for (var key of Object.keys(errors)) {
//         var newLI = document.createElement("li");
//         newLI.appendChild(document.createTextNode(errors[key]));
//         errorMessagesUl.appendChild(newLI);
//     }
// }
function clearAndHideErrors() {
    document.getElementById("error_alert").hidden = true;
    var errorMessagesUl = document.getElementById("error_messages_ul");
    errorMessagesUl.innerHTML = "";
}
function clearForm() {
    document.getElementById("create_form").reset();
    // document.getElementById("image").reset();
}
