$(".select2-affiliation")
    .select2({
        allowClear: true,
        placeholder: "Select an affilation",
    })
    .on("select2:select", function (e) {
        validator.checkAll(form[0]);
    });

$(".select2-transit")
    .select2({
        allowClear: true,
        placeholder: "Select a transit",
    })
    .on("select2:select", function (e) {
        validator.checkAll(form[0]);
    });

$(".select2-sex")
    .select2({
        allowClear: true,
        placeholder: "Select a sex",
    })
    .on("select2:select", function (e) {
        validator.checkAll(form[0]);
    });

$(".select2-class").select2({
    ajax: {
        url: "/api/select2/classes",
        dataType: "json",
        data: function (params) {
            params.api_token = $('meta[name="api-token"]').attr("content");
            return params;
        },
    },
    allowClear: true,
    placeholder: "Select a class",
});

var table = $(".dt-report-student-balances").DataTable({
    order: [[0, "asc"]],
    pageLength: 50,
    responsive: true,
    dom: "lBftip",
    exportOptions: {
        stripHtml: false,
    },
    buttons: [
        {
            extend: "excel",
            footer: true,
            title:
                $(".dt-report-student-balances").data("title") +
                "\n" +
                $(".dt-report-student-balances").data("subtitle"),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.`,
        },
        {
            extend: "pdf",
            title:
                $(".dt-report-student-balances").data("title") +
                "\n" +
                $(".dt-report-student-balances").data("subtitle"),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.`,
            footer: true,
        },
        {
            extend: "print",
            footer: true,
            title:
                $(".dt-report-student-balances").data("title") +
                "\n" +
                $(".dt-report-student-balances").data("subtitle"),
            messageTop: `Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.`,
        },
    ],
    drawCallback: function () {
        $(".dataTables_paginate .paginate_button")
            .css("background", "#fff")
            .css("border-radius", ".3em")
            .css("border-color", "transparent")
            .css("box-shadow", "3px 3px #eee")
            .mouseover(function () {
                $(this).hasClass("disabled")
                    ? null
                    : $(this)
                          .css("background", "#0101f0")
                          .children()
                          .css("color", "white");
            })
            .mouseout(function () {
                $(this).hasClass("disabled")
                    ? null
                    : $(this).hasClass("active")
                    ? $(this)
                          .css("background", "#0101f0")
                          .children()
                          .css("color", "white")
                    : $(this)
                          .css("background", "#fff")
                          .children()
                          .css("color", "black");
            });
        $(".dataTables_paginate .paginate_button").each(function (i, e) {
            $(e).hasClass("active")
                ? $(e)
                      .css("background", "#0101f0")
                      .children()
                      .css("color", "white")
                : $(e)
                      .css("background", "#fff")
                      .children()
                      .css("color", "black");
        });
    },
});

$(".dataTables_wrapper .dataTables_length select").css(
    "padding",
    "6px 30px 6px 20px"
);
$(".dt-buttons").css("margin", "auto 10px auto 10px");
$(".dataTables_paginate")
    .css("margin-top", "5px")
    .css("background-color", "#f8f8f8")
    .css("border-radius", ".3em")
    .css("background", "#f8f8f8")
    .css("box-shadow", "3px 3px #eee");

$("button.dt-button")
    .css("background-color", "#fff")
    .css("border-radius", ".3em")
    .css("background", "#fff")
    .css("box-shadow", "3px 3px #eee");

    $(".print").on("click", function (e) {
        $(".student-list").printThis({
            footer: `<span class="text-xs"><em>Generate with SYMANUS ${APP_VERSION} © ${APP_VERSION_YEAR}.</em></span>`,
          });
      });