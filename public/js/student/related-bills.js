var billTable = $(".dt-related-bills").DataTable({
    dom: "PlBftip",
    buttons: [
        {
            text: "Reload",
            action: function (e, dt, node, config) {
                dt.ajax.reload();
            },
        },
        "print",
        "pdf",
        "excel",
        "selectAll",
        "selectNone",
    ],
    ajax: {
        url: "/api/datatables/student-related-bills",
        dataType: "json",
        contentType: "application/json",
        data: function (param) {
            param.api_token = $('meta[name="api-token"]').attr("content");
            param.student_id = $('.dt-related-bills').data('student-id');
        },
    },
    responsive:true,
    processing: true,
    serverSide: true,
    search: true,
    stateSave: true,
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
    columns: [
        {
            data: "id",
            render: function (data, type, row) {
                return null;
            },
        },
        {
            data: null,name:'id',
            render: function (data, type, row) {
                if (type === "display") {
                    let amount = Number(0); 
                    data.fees.forEach(fee => {
                        amount += Number.parseFloat(fee.amount);
                    });
                    let icon = $(".svg-icon-payment")[0].outerHTML;

                    let d =
                        '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">' +
                        '<a class="hs-tooltip-toggle inline text-left" href="../bills/' +
                        data.id +
                        '">' +
                        '<span class="text-sm px-1  hover:bg-white hover:text-blue-600 transition">' +
                        data.id +
                        '</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">' +
                        '<p class="flex uppercase py-3">' +
                        icon +
                        '<span class="underline">Bill</span></p>' +
                        "<p><b>Bill Ref: </b>" +
                        data.id +
                        "</p>" +
                        "<p><b>Bill Date: </b>" +
                        data.bdate +
                        "</p>" +
                        "<p><b>Bill Amount: </b>" +
                        amount.toFixed(2)+
                        "</p>" +
                        "</div> </a> </div>";
                    return d;
                }

                return data.id;
            },
        },
        { data: "bdate" },
        {
            data: "fees",name:'id',
            render: function (data, type, row) {

                let amount = Number(0); 
                data.forEach(fee => {
                    amount += Number.parseFloat(fee.amount);
                });
                if(type === 'display')
                    return amount.toFixed(2);
                return null;
            },
        },
        {
            data: "user",
            name: "user_id",
            render: function (data, type, row) {
                if (type === "display" && data) {
                    let d =
                        '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">' +
                        '<a class="hs-tooltip-toggle inline text-left" href="../users/' +
                        data.id +
                        '">' +
                        '<span class="px-1 hover:bg-white hover:text-blue-600 transition">' +
                        data.firstname +
                        " " +
                        data.surname +
                        '</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">' +
                        '<p class="flex py-3 items-end"><img class="h-8 mx-1" src="' +
                        (data.avatar ? "" : "../img/user.png") +
                        '"><span class="underline uppercase">User</span></p>' +
                        "<p><b>User Ref: </b>" +
                        data.username +
                        "</p>" +
                        "<p><b>User Name: </b>" +
                        data.firstname +
                        " " +
                        data.surname +
                        "</p>" +
                        "<p><b>User Email: </b>" +
                        data.email +
                        "</p>" +
                        "</div> </a> </div>";

                    return d;
                }

                return data
                    ? data.firstname + " " + data.surname
                    : "<span>Not Assigned</span>";
            },
        },
        { data: "updated_at" },
        {
            data: "id",
            render: function (data, type, row) {
                if (type === "display") {
                    return `<div class="flex gap-3 items-center"><a href="../bills/${data}" class="text-gray-600 hover:text-sky-600"><i class="fa fa-eye"></i></a>
                        <a href="../bills/${data}/edit" class="text-gray-600 hover:text-sky-600"><i class="fa fa-edit"></i></a></div>`;
                }
                return data;
            },
        },
    ],
    searchPanes: {
        columns: [2],
    },
    columnDefs: [
        {
            orderable: false,
            className: "select-checkbox",
            targets: [0],
        },
    ],
    select: {
        style: "multi",
        selector: "td:first-child",
    },
    order: [[1, "asc"]],
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

$(".alert-processing").hide();
$(".dt-related-bills").removeClass("hidden");

dtRowSelectAction(billTable);
