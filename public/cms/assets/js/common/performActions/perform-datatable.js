$(function () {
    // var ajaxFilter = function (d) {
    //     d.title = $("#title").val();
    // };

    var filterItems = extractNames(filters);
    var ajaxFilter = function (d) {
        filterItems.forEach(function (item) {
            d[item] = $("#" + item).val();
        });
        d.table_language = $('input[name="table_language"]:checked').val();
    };

    var table = $("#kt_datatable_example_1").DataTable({
        processing: true,
        searching: false,
        serverSide: true,
        // ajax: route,
        ajax: {
            url: route,
            data: ajaxFilter,
        },
        columns: columns,
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
        pageLength: 4, // 25
        // lengthMenu: [25, 50, 100],
        responsive: true,
        // stateSave: true, // good choice for filtering with pagination
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
        dom: "Bfrtip",
        // select: true,
        buttons: buttons,
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
        createdRow: function (row, data, dataIndex) {
            $("td", row).addClass("align-middle");

            // give each <tr> a class del_{$id} for x_delete
            $(row).addClass("del_" + data.id);
        },
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
        columnDefs: [
            {
                targets: "_all",
                orderable: false,
                defaultContent: "",
            },
        ],
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
        // dom:
        //     "<'table-responsive'tr>" +
        //     "<'row'" +
        //     "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'li>" +
        //     "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        //     ">",
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
        language: {
            lengthMenu: currentLanguage === 'en' ? "Show _MENU_" : "عرض _MENU_",
            processing: currentLanguage === 'en' ? ".:: Loading ::." : ".:: جار التحميل ::.",
            info: currentLanguage === 'en' ? "Show _START_ to _END_ from _TOTAL_ record" : "عرض _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            infoEmpty: currentLanguage === 'en' ? "Show 0 to 0 from 0 record" : "عرض 0 إلى 0 من أصل 0 مدخل",
            // "processing": '<div class="spinner-border text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>',

            paginate: {
                previous: currentLanguage === 'en' ? "<i class='fa-solid fa-chevron-left'></i>" : "<i class='fa-solid fa-chevron-right'></i>",
                next: currentLanguage === 'en' ? "<i class='fa-solid fa-chevron-right'></i>" : "<i class='fa-solid fa-chevron-left'></i>",
            },
        },
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
        initComplete: function (settings, json) {
            // style the th`s
            $("#kt_datatable_example_1 thead th").attr("scope", "col");
            $("#kt_datatable_example_1 thead th:first-child").addClass(
                "text-start ms-0 rounded-start"
            );
            $("#kt_datatable_example_1 thead th:last-child").addClass(
                "text-end rounded-end"
            );

            // handle the empty table - no data
            var api = this.api();
            var data = api.rows().data();
            // var noDataImage = "{{ asset('cms/assets/media/illustrations/sigma-1/15.png') }}";
            if (data.length === 0) {
                $("#kt_datatable_example_1 tbody").html(
                    '<tr><td colspan="' +
                        api.columns().count() +
                        '"><div class="text-center"><img class="opacity-75 w-25 h-25" src="' +
                        noDataImage +
                        '" alt="No Data" /><div class="my-5">' + (currentLanguage === 'en' ? 'Sorry, we could not find any data to show here' : 'نأسف, لا يوجد أي بيانات لعرضها') + '</div></div></td></tr>'
                );
            }
        },
        /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////
    });

    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    // Filtering Events
    var typingTimer;
    $(".__searchable").on("input change", function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function () {
            table.draw();
        }, 900);
    });

    $(".__searchable_select").on("change", function () {
        table.draw();
    });


    // Listen for language switcher changes
    $('input[name="table_language"]').change(function () {
        table.draw();
    });


    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    // append the colvis dropdown to custom place
    $("button.buttons-colvis").appendTo($("#colvis-btn"));
    $("#colvis-btn button.buttons-colvis").addClass(
        "btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info px-3 py-2 ms-2"
    );
    $("button.buttons-print, button.buttons-pdf, button.buttons-excel").hide();
    ////////////
    // $(".dataTables_length").appendTo($(".foot-left"));
    $(".dataTables_info").appendTo($(".foot-left"));
    $(".dataTables_paginate").appendTo($(".foot-right"));
    ////////////
    $("#customExportExcelButton").on("click", function () {
        $("button.buttons-excel").click();
    });
    $("#customExportPDFButton").on("click", function () {
        $("button.buttons-pdf").click();
    });
    $("#customPrintButton").on("click", function () {
        $("button.buttons-print").click();
    });
});
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
var buttons = [
    // PRINT all
    {
        extend: "print",
        text: "Print",
        download: "open", // open pdf in new window before download
        title: this.formatResource(resourceName) + " List Report",
        messageTop: "",
        messageBottom: "",
        exportOptions: {
            columns: ":visible", //[":not(:last-child)", ":visible"],
        },
    },
    /////////////////////////////////////////////////////////////////////
    // PDF
    {
        extend: "pdfHtml5",
        text: "Export PDF",
        title: this.formatResource(resourceName) + " List Report",
        messageTop: "",
        messageBottom: "",
        exportOptions: {
            columns: ":visible", //[":not(:last-child)", ":visible"], //[1, ":visible"] // ":visible"
        },
    },
    /////////////////////////////////////////////////////////////////////
    // EXCEL
    {
        extend: "excelHtml5",
        text: "Export Excel",
        // title: this.formatResource(resourceName) + " List Report",
        // messageTop: "",
        // messageBottom: "",
        exportOptions: {
            columns: ":visible",
        },
        // just for excel
        autoFilter: true,
    },
    /////////////////////////////////////////////////////////////////////
    {
        extend: "colvis",
        text: currentLanguage === 'en' ? "Show/Hide Col`s" : "إظهار/إخفاء الأعمدة",
    },
];

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
// helpers
function formatResource(text) {
    text = text.replace(/_/g, " ");
    text = text.replace(/(\w)([A-Z])/g, "$1 $2");
    text = text.toLowerCase().replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase();
    });
    return text;
}

function extractNames(obj, result = []) {
    if (typeof obj === "object") {
        for (const key in obj) {
            if (key === "name") {
                result.push(obj[key]);
            } else {
                extractNames(obj[key], result);
            }
        }
    }
    return result;
}


