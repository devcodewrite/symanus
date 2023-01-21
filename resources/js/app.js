require("./bootstrap");

import "preline";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import $ from "jquery";
window.$ = window.jQuery = $;

require('./vue-attendance');

window.JSZip = require("jszip");
let pdfmake = require("pdfmake");
let pdffonts = require("pdfmake/build/vfs_fonts.js");
pdfmake.vfs = pdffonts.pdfMake.vfs;
import Swal from "sweetalert2";
window.Swal = Swal;

require("datatables.net");
require("datatables.net-bs5");
require("datatables.net-buttons");
require("datatables.net-responsive");
require("datatables.net-responsive-dt");
require("datatables.net-buttons/js/buttons.colVis.js");
require("datatables.net-buttons/js/buttons.html5.js");
require("datatables.net-buttons/js/buttons.print.js");
require("datatables.net-buttons/js/buttons.flash");
require("datatables.net-datetime");
require("datatables.net-searchbuilder-dt");
require("datatables.net-searchpanes-dt");
require("datatables.net-select-dt");
require("select2");

$(".select2").select2({
    allowClear: true,
    placeholder: "Select an option",
});

$(".dt-action-select")
    .select2()
    .on("change select2:select", function (e) {
        if ($(this).val() !== "")
            $(".dt-action").find(".dt-action-btn").prop("disabled", false);
        else $(".dt-action").find(".dt-action-btn").prop("disabled", true);
    });

window.dtRowSelectAction = function (table) {
    table.on("select deselect", function (e, dt, type, indexes) {
        if (type === "row" && dt.rows({ selected: true }).count() > 0) {
            $(".dt-action").addClass("show");
        } else if (type === "row") {
            $(".dt-action").removeClass("show");
        }
    });

    $(".dt-action-btn").on("click", function (e) {
        let action = $(".dt-action-select").val();
        let target = $(this).data("target-url");
        if (action === "delete") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "Once deleted, you will not be able to recover this record!",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "open-rstate") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to open.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "close-rstate") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to close.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "present-status") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to present.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
        else if (action === "absent-status") {
            swal({
                icon: "warning",
                title: "Are you sure ?",
                text: "This will set the record(s) status to absent.",
                buttons: true,
            }).then(function (val) {
                let data = [],
                    rows = table.rows({ selected: true}).data();
                for (let i = 0; i < rows.length; i++) {
                    data.push(rows[i]);
                }
                if (val) {
                  handleDtPostAction(table, action,target, data);
                } else {
                    swal("Your record is safe!");
                }
            });
        }
    });
};

function handleDtPostAction(table, action, target, data){
    $.ajax({
        url: target,
        method: "PUT",
        data: JSON.stringify({
            action: action,
            data: data,
            api_token: $('meta[name="api-token"]').attr(
                "content"
            ),
        }),
        dataType: "json",
        contentType: "application/json",
        cache: false,
        processData: false,
        success: function (d, r) {
            if (!d || r === "nocontent") {
                swal({
                    icon: "error",
                    text: "No content! Please try agian.",
                });
                return;
            }
            if (
                typeof d.status !== "boolean" ||
                typeof d.message !== "string"
            ) {
                swal({
                    icon: "error",
                    text: "Malformed data response! Please try agian.",
                });
                return;
            }
            $(".dt-action-select").val(null).trigger('change');

            if (d.status === true) {
                swal({
                    icon: "success",
                    text: d.message,
                });
                table.ajax.reload();
                table.ajax.searchPanes.reload();
                $(".dt-action-btn").prop('disabled', true);
                $(".dt-action").removeClass("show");
            } else {
                swal({
                    icon: "error",
                    text: d.message,
                });
            }
        },
        error: function (r) {
            Swal.fire({
                icon: "error",
                text: "Unable to submit form! Please try agian.",
            });
        },
    });
}

 window.changeParam = function(url, param, val) {
    var href = new URL(url);
    href.searchParams.set(param, val);
    return href.toString();
}

window.readURL = function(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.avatar-placeholder').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$( window).on('scroll',function() {
    sessionStorage.setItem("scroll_position_y"+location.href, $(this).first().scrollTop());
});

let activeNavList = $("li.hs-accordion.active").first().offset();
$('#application-sidebar').animate({
    scrollTop: activeNavList?activeNavList.top:0
}, 2000);

let scrollPositionY = sessionStorage.getItem("scroll_position_y"+location.href);
setTimeout(function(){
    $('html,body').animate({
        scrollTop: scrollPositionY?scrollPositionY:0
    }, 100);
},1000);


$('.rdelete').on('click',function(e){
    let targetUrl = location.href;
    if($(this).attr('href') && $(this).attr('href') !== 'javascript:;') targetUrl = $(this).attr('href');
    
    Swal.fire({
        title: "Are you sure ?",
        text:  `You want to delete this record! You wouldn't be able to recover it!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: `Yes! delete it`,
    }).then((result) => {
        if (!result.isConfirmed) return Swal.fire("Record is safe!");

        $.ajax({
            method: "DELETE",
            url: targetUrl,
            data: {
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            dataType: "json",
            cache: false,
            success: function (d, r) {
                if (!d || r === "nocontent") {
                    Swal.fire({
                        icon: "error",
                        text: "Malformed form data sumbitted! Please try agian.",
                    });
                    return;
                }
                if (
                    typeof d.status !== "boolean" ||
                    typeof d.message !== "string"
                ) {
                    Swal.fire({
                        icon: "error",
                        text: "Malformed data response! Please try agian.",
                    });
                    return;
                }

                if (d.status === true) {
                    Swal.fire({
                        icon: "success",
                        text: d.message,
                    });
                    setTimeout(() => {
                        let segments = location.href.toString().split('/').pop();
                        location.assign(segments.join('/'));
                    }, 600);
                } else {
                    Swal.fire({
                        icon: "error",
                        text: d.message,
                    });
                }
            },
            error: function (r) {
                Swal.fire({
                    icon: "error",
                    text: "Unable to submit form! Please try agian.",
                });
            },
        });
    });
});
