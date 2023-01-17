var classTable = $(".dt-attendances").DataTable({
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
        url: "/api/datatables/attendances",
        dataType: "json",
        contentType: "application/json",
        data: function (param) {
            param.api_token = $('meta[name="api-token"]').attr("content");
        },
    },
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
    initComplete: function (settings) {
        $(".dataTables_wrapper table").wrap(
            '<div style="overflow-x:auto;" class="w-full"></div>'
        );
    },
    columns: [
        {
            data: "id",
            render: function (data, type, row) {
                return null;
            },
        },
        {
            data: null,
            name: "id",
            render: function (data, type, row) {
                if (type === "display") {
                    let icon = $(".svg-icon-attendance")[0].outerHTML;
                    let d =
                        '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">' +
                        '<a class="hs-tooltip-toggle inline text-left" href="/attendances/' +
                        data.id +
                        '">' +
                        '<span class="text-sm px-1  hover:bg-white hover:text-blue-600 transition">' +
                        data.id +
                        '</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">' +
                        '<p class="flex uppercase py-3">' +
                        icon +
                        '<span class="underline">Attendance</span></p>' +
                        "<p><b>Attendance Ref: </b>" +
                        data.id +
                        "</p>" +
                        "<p><b>Attendance Date: </b>" +
                        data.adate +
                        "</p>" +
                        "<p><b>For Class: </b>" +
                        data?.class.name +
                        "</p>" +
                        "<p><b>Creator: </b>" +
                        data?.user.firstname +
                        " " +
                        data?.user.surname +
                        "</p>" +
                        "</div> </a> </div>";
                    return d;
                }

                return data.id;
            },
        },
        {
            data: "adate",
            render: function (data, type, row) {
                return data;
            },
        },
        {
            data: "class", name:'class_id',
            render: function (data, type, row) {
                return data.name;
            },
        },
        
        {
            data: "user",
            name: "user_id",
            render: function (data, type, row) {
                if (type === "display" && data) {
                    let d =
                        '<div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">' +
                        '<a class="hs-tooltip-toggle inline text-left" href="/users/' +
                        data.id +
                        '">' +
                        '<span class="px-1 hover:bg-white hover:text-blue-600 transition">' +
                        data.firstname +
                        " " +
                        data.surname +
                        '</span><div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden md:inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">' +
                        '<p class="flex py-3 items-end"><img class="h-8 mx-1" src="' +
                        (data.avatar ? "" : "/img/user.png") +
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
        {
            data: 'status',
            render:function(data, type, row){
                if(type === 'display'){
                    let labels = {
                        draft: 'bg-yellow-600',
                        submitted: 'bg-sky-600',
                        approved: 'bg-green-600',
                        rejected: 'bg-red-600',
                    };
                    return `<span class="p-1 px-2 text-white rounded ${labels[data]}">${data.toUpperCase()}</span>`;
                }
                return data;
            }
        },

        { data: "created_at" },
        {
            data: "id",
            render: function (data, type, row) {
                if (type === "display") {
                    return `<div class="flex gap-3 items-center"><a href="attendances/${data}" class="text-gray-600 hover:text-sky-600"><i class="fa fa-eye"></i></a>
                        <a href="attendances/${data}/edit" class="text-gray-600 hover:text-sky-600"><i class="fa fa-edit"></i></a></div>`;
                }
                return data;
            },
        },
    ],
    searchPanes:{
        columns:[2,3,5],
        serverSide: true,
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
$(".dt-attendances").removeClass("hidden");

dtRowSelectAction(classTable);
