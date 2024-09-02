function performUpdate(id) {
    event.preventDefault();

    const form = document.getElementById('update_form');
    const url = form.getAttribute('action');
    const redirectUrl = form.getAttribute('redirectto');

    let formData = new FormData();

    handleDataCollection(data, formData);

    x_update(url, formData, redirectUrl);
}
