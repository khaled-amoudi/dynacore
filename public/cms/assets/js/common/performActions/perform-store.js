function performStore() {
    event.preventDefault();

    const form = document.getElementById("create_form");
    const url = form.getAttribute("action");
    const redirectUrl = form.getAttribute("redirectto");
    let formData = new FormData();
    handleDataCollection(data, formData);

    // x_store(url, formData, redirectUrl);
    // x_store_cont(url, formData);
    x_spa_store(url, formData, redirectUrl);
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

    handleDataCollection(data, formData);

    // x_store(url, formData, redirectUrl);
    x_store_cont(url, formData);
    // x_spa_store(url, formData, redirectUrl);
}
