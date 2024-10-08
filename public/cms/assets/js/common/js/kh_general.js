function getCurrentLanguage() {
    return $("html").attr("lang");
}
var currentLanguage = getCurrentLanguage();

function translation_en_ar(en_text, ar_text) {
    return currentLanguage == "en" ? en_text : ar_text;
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Toaster configrations

function toastr_showErrors(errors) {
    setToastrOptions();
    for (const fieldName in errors) {
        const fieldErrors = errors[fieldName];
        fieldErrors.forEach((error) => {
            toastr.error(error, translation_en_ar("Fail !!", "خطأ !!"));
        });
    }
}

function toastr_showMessage(data) {
    setToastrOptions();
    if (data.type == "success") {
        toastr.success(data.message, translation_en_ar("Success", "أحسنت"));
    } else if (data.type == "error") {
        toastr.error(data.message, translation_en_ar("Fail !!", "خطأ !!"));
    } else if (data.type == "warning") {
        toastr.warning(
            data.message,
            translation_en_ar("Warning !!", "تحذير !!")
        );
    } else {
        toastr.info(data.message, translation_en_ar("Info !!", "إخطار !!"));
    }
}

function setToastrOptions() {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass:
            currentLanguage === "en"
                ? "toastr-bottom-right"
                : "toastr-bottom-left",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "2000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "swing",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
}

function alert_showErrors(errors) {
    const alertElement = $("#form_errors_alert");
    const errorListElement = $("#form_errors_validation_list");
    errorListElement.empty();
    alertElement.removeClass("d-none").hide().fadeIn(500);
    $.each(errors, function (key, messages) {
        messages.forEach(function (message) {
            const errorItem = $("<span>").text(message).hide();
            errorListElement.append(errorItem);
            errorItem.fadeIn(300);
        });
    });
}
function alert_closeAlert() {
    $("#form_errors_alert").fadeOut(500, function() {
        $(this).addClass('d-none'); // Add d-none after fade out
    });
}

function modal_alert_showErrors(errors) {
    const alertElement = $("#modal_form_errors_alert");
    const errorListElement = $("#modal_form_errors_validation_list");
    errorListElement.empty();
    alertElement.removeClass("d-none").hide().fadeIn(500);
    $.each(errors, function (key, messages) {
        messages.forEach(function (message) {
            const errorItem = $("<span>").text(message).hide();
            errorListElement.append(errorItem);
            errorItem.fadeIn(300);
        });
    });
}
function modal_alert_closeAlert() {
    $("#modal_form_errors_alert").fadeOut(500, function() {
        $(this).addClass('d-none'); // Add d-none after fade out
    });
}

